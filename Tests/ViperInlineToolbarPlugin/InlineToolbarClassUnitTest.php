<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperInlineToolbarPlugin_InlineToolbarClassUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that VITP changes when a class is added to the selected text and is then removed using the inline toolbar.
     *
     * @return void
     */
    public function testLineageChangesWhenClassIsAppliedAndRemovedUsingInlineToolbar()
    {
        $text = 1;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenClassIsAppliedAndRemovedUsingInlineToolbar()


    /**
     * Test that VITP changes when a class is added to the selected text and is then removed using the top toolbar.
     *
     * @return void
     */
    public function testLineageChangesWhenClassIsAppliedAndRemovedUsingTopToolbar()
    {
        $text = 1;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenClassIsAppliedAndRemovedUsingTopToolbar()


    /**
     * Test that VITP changes when a class is added and removed to a word at the start of the paragraph.
     *
     * @return void
     */
    public function testLineageChangesWhenClassIsAppliedAndRemovedToFirstWordInParagraph()
    {
        $text = 2;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenClassIsAppliedAndRemovedToFirstWordInParagraph()


    /**
     * Test that VITP doesn't change when a class is added to the selected paragraph.
     *
     * @return void
     */
    public function testLineageDoesNotChangeWhenClassIsAppliedToAParagraph()
    {
        $text = 1;
        $textLoc = $this->findKeyword($text);

        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

    }//end testLineageDoesNotChangeWhenClassIsAppliedToAParagraph()


    /**
     * Test that when you select the SPAN tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheSpanTagInTheLineage()
    {
        $this->selectKeyword(3);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">SPAN</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals($this->replaceKeywords('%8% %3%'), $this->getSelectedText(), 'Span tag is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectKeyword(8);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals($this->replaceKeywords('%8% %3%'), $this->getSelectedText(), 'Span tag is not selected.');

    }//end testSelectingTheSpanTagInTheLineage()


    /**
     * Test that VITP changes when a class is added to bold text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenClassIsAppliedAndRemovedToBoldText()
    {
        $text = 4;
        $textLoc = $this->findKeyword($text);
        $this->selectKeyword($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

    }//end testLineageChangesWhenClassIsAppliedAndRemovedToBoldText()


    /**
     * Test that VITP changes when a class is added to italic text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenClassIsAppliedAndRemovedToItalicText()
    {
        $text = 5;
        $textLoc = $this->findKeyword($text);
        $this->selectKeyword($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->selectKeyword($text);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->click($textLoc);
        $this->selectKeyword($text);
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');
        $this->selectKeyword($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

    }//end testLineageChangesWhenClassIsAppliedAndRemovedToItalicText()


    /**
     * Test that span is shown in lineage when a class to one word out of two words that are bold.
     *
     * @return void
     */
    public function testLineageWhenAddingClassToAOneBoldWord()
    {
        $this->selectKeyword(6, 7);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

        $this->selectKeyword(7);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

        $this->click($this->find(6));
        $this->selectKeyword(7);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

    }//end testLineageWhenAddingClassToAOneBoldWord()


    /**
     * Test that span is shown in lineage when a class to one word out of two words that are italics.
     *
     * @return void
     */
    public function testLineageWhenAddingClassToAOneItalicWord()
    {
        $this->selectKeyword(6, 7);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Italic</li>', $lineage);

        $this->selectKeyword(7);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Italic</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

        $this->click($this->find(6));
        $this->selectKeyword(7);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Italic</li><li class="ViperITP-lineageItem Viper-selected">SPAN</li>', $lineage);

    }//end testLineageWhenAddingClassToAOneItalicWord()


}//end class

?>
