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
        $dir = dirname(__FILE__).'/Images/';

        $text = 'IPSUM';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText($text);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">SPAN</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">SPAN</li>', $lineage);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->keyDown('Key.ENTER');

        // Take this line out to make the test fail as per issue #1467
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenClassIsAppliedAndRemovedUsingInlineToolbar()


    /**
     * Test that VITP changes when a class is added to the selected text and is then removed using the top toolbar.
     *
     * @return void
     */
    public function testLineageChangesWhenClassIsAppliedAndRemovedUsingTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'IPSUM';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">SPAN</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_class_active.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->keyDown('Key.ENTER');

        $this->click($textLoc);
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenClassIsAppliedAndRemovedUsingTopToolbar()


    /**
     * Test that VITP changes when a class is added and removed to a word at the start of the paragraph.
     *
     * @return void
     */
    public function testLineageChangesWhenClassIsAppliedAndRemovedToFirstWordInParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LABS';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText($text);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">SPAN</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">SPAN</li>', $lineage);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->keyDown('Key.ENTER');

        // Take this line out to make the test fail as per issue #1467
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenClassIsAppliedAndRemovedToFirstWordInParagraph()


    /**
     * Test that VITP doesn't change when a class is added to the selected paragraph.
     *
     * @return void
     */
    public function testLineageDoesNotChangeWhenClassIsAppliedToAParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'IPSUM';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">P</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

    }//end testLineageDoesNotChangeWhenClassIsAppliedToAParagraph()


    /**
     * Test that when you select the SPAN tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheSpanTagInTheLineage()
    {
        $this->selectText('WoW');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">SPAN</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $this->assertEquals('SUB WoW', $this->getSelectedText(), 'Span tag is not selected.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">SPAN</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->selectText('SUB');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('SUB WoW', $this->getSelectedText(), 'Span tag is not selected.');

    }//end testSelectingTheSpanTagInTheLineage()


    /**
     * Test that VITP changes when a class is added to bold text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenClassIsAppliedAndRemovedToBoldText()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'dolor';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

        $this->selectText($text);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->keyDown('Key.ENTER');

        // Take this line out to make the test fail as per issue #1467
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

    }//end testLineageChangesWhenClassIsAppliedAndRemovedToBoldText()


    /**
     * Test that VITP changes when a class is added to italic text and is then removed.
     *
     * @return void
     */
    public function testLineageChangesWhenClassIsAppliedAndRemovedToItalicText()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'Lorem';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->selectText($text);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->keyDown('Key.ENTER');

        // Take this line out to make the test fail as per issue #1467
        $this->selectText($text);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

    }//end testLineageChangesWhenClassIsAppliedAndRemovedToItalicText()


    /**
     * Test that span is shown in lineage when a class to one word out of two words that are bold.
     *
     * @return void
     */
    public function testLineageWhenAddingClassToAOneBoldWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LONG', 'PARA');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

        $this->selectText('PARA');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem selected">SPAN</li>', $lineage);

        $this->click($this->find('LONG'));
        $this->selectText('PARA');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem selected">SPAN</li>', $lineage);

    }//end testLineageWhenAddingClassToAOneBoldWord()


    /**
     * Test that span is shown in lineage when a class to one word out of two words that are italics.
     *
     * @return void
     */
    public function testLineageWhenAddingClassToAOneItalicWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LONG', 'PARA');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->selectText('PARA');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Italic</li><li class="ViperITP-lineageItem selected">SPAN</li>', $lineage);

        $this->click($this->find('LONG'));
        $this->selectText('PARA');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Italic</li><li class="ViperITP-lineageItem selected">SPAN</li>', $lineage);

    }//end testLineageWhenAddingClassToAOneItalicWord()


}//end class

?>
