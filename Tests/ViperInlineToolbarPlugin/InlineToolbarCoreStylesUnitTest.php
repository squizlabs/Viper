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
        $text    = 'IPSUM';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->keyDown('Key.CMD + b');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
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
        $text    = 'IPSUM';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->keyDown('Key.CMD + i');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
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
        $text    = 'IPSUM';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton('subscript');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SUB</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
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
        $text    = 'IPSUM';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton('superscript');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SUP</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
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
        $text    = 'IPSUM';
        $textLoc = $this->find($text);
        $this->selectText($text);

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
        $this->selectText('XyZ');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('XyZ DFG', $this->getSelectedText(), 'Bold text is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectText('DFG');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('XyZ DFG', $this->getSelectedText(), 'Bold text is not selected.');

    }//end testSelectingTheBoldTagInTheLineage()


    /**
     * Test that when you select the Italic tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheItalicTagInTheLineage()
    {
        $this->selectText('Food');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Italic</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals('Food Source', $this->getSelectedText(), 'Italics text is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectText('Source');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('Food Source', $this->getSelectedText(), 'Italics text is not selected.');

    }//end testSelectingTheItalicTagInTheLineage()


    /**
     * Test that when you select the Subscript tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheSubscriptTagInTheLineage()
    {
        $this->selectText('SUB');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">SUB</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals('SUB RRR', $this->getSelectedText(), 'Subscript text is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SUB</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectText('RRR');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('SUB RRR', $this->getSelectedText(), 'Subscript text is not selected.');

    }//end testSelectingTheItalicTagInTheLineage()


    /**
     * Test that when you select the Superscript tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheSuperscriptTagInTheLineage()
    {
        $this->selectText('ORSM');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">SUP</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals('VerY ORSM', $this->getSelectedText(), 'Superscript text is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SUP</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectText('VerY');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('VerY ORSM', $this->getSelectedText(), 'superscript text is not selected.');

    }//end testSelectingTheSuperscriptTagInTheLineage()


    /**
     * Test that when you select the strike through tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheStrikethroughTagInTheLineage()
    {
        $this->selectText('ORSM');
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
        $this->selectText('IPSUM');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + b');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + b');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Italic</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + i');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->selectText('IPSUM');
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
        $this->selectText('IPSUM', 'dolor');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->selectText('dolor');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('IPSUM dolor', $this->getSelectedText(), 'Formatted text is not selected');

        $this->selectText('IPSUM');
        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals('IPSUM dolor', $this->getSelectedText(), 'Formatted text is not selected');


    }//end testSelectingBoldAndItalic()


}//end class

?>
