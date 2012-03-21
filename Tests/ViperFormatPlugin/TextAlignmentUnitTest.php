<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_TextAlignmentUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that you can apply left justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingLeftJustify()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LOREM', 'dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: left;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignLeft_active.png'), 'Active left justify icon does not appear in the top toolbar');

    }//end testApplyingLeftJustify()


    /**
     * Test that you can apply left justification to a paragraph when selecting a bold word.
     *
     * @return void
     */
    public function testApplyingLeftJustifyWithBoldWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('BOLD');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p style="text-align: left;">test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignLeft_active.png'), 'Active left justify icon does not appear in the top toolbar');

    }//end testApplyingLeftJustifyWithBoldWord()


    /**
     * Test that you can apply left justification to a paragraph when selecting a italic word.
     *
     * @return void
     */
    public function testApplyingLeftJustifyWithItalicWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('ITALICS');
        $this->keyDown('Key.CMD + i');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p style="text-align: left;">test <em>ITALICS</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignLeft_active.png'), 'Active left justify icon does not appear in the top toolbar');

    }//end testApplyingLeftJustifyWithItalicWord()


    /**
     * Test that when you select a paragraph that has left justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithLeftJustification()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('sit', 'WoW');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignLeft_active.png'), 'Left justify icon is not active in the top toolbar');

    }//end testSelectingParagraphWithLeftJustification()


    /**
     * Test removing left justification.
     *
     * @return void
     */
    public function testRemovingLeftJustification()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('sit', 'WoW');

        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft_active.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft_active.png');

        $this->assertHTMLMatch('<p>sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

    }//end testRemovingLeftJustification()


    /**
     * Test that you can apply right justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingRightJustify()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LOREM', 'dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: right;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignRight_active.png'), 'Right justify active icon does not appear in the top toolbar');

    }//end testApplyingRightJustify()


    /**
     * Test that you can apply right justification to a paragraph when selecting a bold word.
     *
     * @return void
     */
    public function testApplyingRightJustifyWithBoldWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('BOLD');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p style="text-align: right;">test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignRight_active.png'), 'Active right justify icon does not appear in the top toolbar');

    }//end testApplyingRightJustifyWithBoldWord()


    /**
     * Test that you can apply right justification to a paragraph when selecting a italic word.
     *
     * @return void
     */
    public function testApplyingRightJustifyWithItalicWord()
    {

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('ITALICS');
        $this->keyDown('Key.CMD + i');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p style="text-align: right;">test <em>ITALICS</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignRight_active.png'), 'Active right justify icon does not appear in the top toolbar');

    }//end testApplyingRightJustifyWithItalicWord()


    /**
     * Test that when you select a paragraph that has right justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithRightJustification()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('QvQ', 'Kyk');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignRight_active.png'), 'Right justify active icon does not appear in the top toolbar');

    }//end testSelectingParagraphWithRightJustification()


    /**
     * Test removing right justification.
     *
     * @return void
     */
    public function testRemovingRightJustification()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('QvQ', 'Kyk');

        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight_active.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight_active.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p>QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

    }//end testRemovingRightJustification()


    /**
     * Test that you can apply centre justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingCentreJustify()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LOREM', 'dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: center;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignCenter_active.png'), 'Centre justify active icon does not appear in the top toolbar');

    }//end testApplyingCentreJustify()


    /**
     * Test that you can apply centre justification to a paragraph when selecting a bold word.
     *
     * @return void
     */
    public function testApplyingCentreJustifyWithBoldWord()
    {

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('BOLD');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p style="text-align: center;">test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignCenter_active.png'), 'Active right justify icon does not appear in the top toolbar');

    }//end testApplyingCenterJustifyWithBoldWord()


    /**
     * Test that you can apply center justification to a paragraph when selecting a italic word.
     *
     * @return void
     */
    public function testApplyingCenterJustifyWithItalicWord()
    {

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('ITALICS');
        $this->keyDown('Key.CMD + i');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p style="text-align: center;">test <em>ITALICS</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignCenter_active.png'), 'Active center justify icon does not appear in the top toolbar');

    }//end testApplyingCenterJustifyWithItalicWord()


    /**
     * Test that when you select a paragraph that has centre justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithCentreJustification()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('RsR', 'TpT');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignCenter_active.png'), 'Centre justify active icon does not appear int he top toolbar');

    }//end testSelectingParagraphWithCentreJustification()


    /**
     * Test removing centre justification.
     *
     * @return void
     */
    public function testRemovingCentreJustification()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('RsR');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter_active.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter_active.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p>RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

    }//end testRemovingCentreJustification()


    /**
     * Test that you can apply block justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingBlockJustify()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LOREM', 'dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignJustify.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: justify;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');


        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignJustify_active.png'), 'Toogle justification icon is not selected');

    }//end testApplyingBlockJustify()


    /**
     * Test that you can apply block justification to a paragraph when selecting a bold word.
     *
     * @return void
     */
    public function testApplyingBlockJustifyWithBoldWord()
    {

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('BOLD');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignJustify.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p style="text-align: justify;">test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignJustify_active.png'), 'Active right justify icon does not appear in the top toolbar');

    }//end testApplyingBlockJustifyWithBoldWord()


    /**
     * Test that you can apply block justification to a paragraph when selecting a italic word.
     *
     * @return void
     */
    public function testApplyingBlockJustifyWithItalicWord()
    {

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('ITALICS');
        $this->keyDown('Key.CMD + i');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignJustify.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p style="text-align: justify;">test <em>ITALICS</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignJustify_active.png'), 'Active center justify icon does not appear in the top toolbar');

    }//end testApplyingBlockJustifyWithItalicWord()


    /**
     * Test that when you select a paragraph that has block justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithBlockJustification()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('MrM', 'GaG');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignJustify_active.png'), 'Block justify active icon does not appear in the toolbar');

    }//end testSelectingParagraphWithBlockJustification()


    /**
     * Test removing block justification.
     *
     * @return void
     */
    public function testRemovingBlockJustification()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('MrM', 'GaG');

        $this->clickTopToolbarButton($dir.'toolbarIcon_alignJustify_active.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignJustify_active.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p>MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

    }//end testRemovingBlockJustification()


    /**
     * Test that justification is applied to the paragraph when you select a word.
     *
     * @return void
     */
    public function testJustificationWhenSelectingAWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LOREM');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: left;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignLeft_active.png'), 'Acitve left justify icon does not appear in the top toolbar');

    }//end testJustificationWhenSelectingAWord()


    /**
     * Test that when you click in a word and select a justification, it is applied to the paragraph that the word is in..
     *
     * @return void
     */
    public function testJustificationWhenClickingInAWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->click($this->find('dolor'));

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight.png');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: right;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignRight_active.png'), 'Acitve right justify icon does not appear in the top toolbar');

    }//end testJustificationWhenClickingInAWord()


    /**
     * Test applying justification to mulitple paragraphs where alignment has already been applied.
     *
     * @return void
     */
    public function testJustificationMultipleParagraphsWithAlignmentsApplied()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('WoW', 'XuT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft_active.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight.png');

        $this->assertHTMLMatch(
            '<p style="text-align: right;">sit amet WoW</p><p style="text-align: right;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: right;">MrM GaG</p><p>LOREM XuT dolor</p><p style="text-align: right;">test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>',
            '<p style="text-align: right; ">sit amet WoW</p><p style="text-align: right; ">RsR TpT</p><p style="text-align: right; ">QvQ KyK</p><p style="text-align: right; ">MrM GaG</p><p style="text-align: right;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->click($this->find('BOLD'));

        $this->selectText('WoW', 'XuT');

        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignRight_active.png'), 'Acitve right justify icon does not appear in the top toolbar');

    }//end testJustificationMultipleParagraphsWithAlignmentsApplied()


    /**
     * Test applying justification to mulitple paragraphs where alignment has not been applied.
     *
     * @return void
     */
    public function testJustificationMultipleParagraphsWithNoAlignmentsApplied()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT', 'ITALICS');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter.png');

        $this->assertHTMLMatch(
            '<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: center;">LOREM XuT dolor</p><p style="text-align: center;">test <strong>BOLD</strong> text</p><p style="text-align: center;">test ITALICS text.</p>',
            '<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: center; ">LOREM XuT dolor</p><p style="text-align: center; ">test <strong>BOLD</strong> text</p><p style="text-align: center;">test ITALICS text.</p>');

    }//end testJustificationMultipleParagraphsWithNoAlignmentsApplied()


}//end class

?>
