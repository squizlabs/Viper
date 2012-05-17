<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_AlignmentUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that only block level elements are aligned.
     *
     * @return void
     */
    public function testAlignmentInNoneBlockTag()
    {
        $this->selectText('XuT');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.LEFT');

        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'));
        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: center;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

    }//end testAlignmentInNoneBlockTag()


    /**
     * Test that you can apply left justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingLeftJustify()
    {
        $this->selectText('LOREM', 'dolor');
        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyLeft');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: left;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

    }//end testApplyingLeftJustify()


    /**
     * Test that you can apply left justification to a paragraph when selecting a bold word.
     *
     * @return void
     */
    public function testApplyingLeftJustifyWithBoldWord()
    {
        $this->selectText('BOLD');
        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyLeft');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p style="text-align: left;">test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

    }//end testApplyingLeftJustifyWithBoldWord()


    /**
     * Test that you can apply left justification to a paragraph when selecting a italic word.
     *
     * @return void
     */
    public function testApplyingLeftJustifyWithItalicWord()
    {
        $this->selectText('ITALICS');
        $this->keyDown('Key.CMD + i');
        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyLeft');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p style="text-align: left;">test <em>ITALICS</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

    }//end testApplyingLeftJustifyWithItalicWord()


    /**
     * Test that when you select a paragraph that has left justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithLeftJustification()
    {
        $this->selectText('sit', 'WoW');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left justify icon is not active in the top toolbar');

    }//end testSelectingParagraphWithLeftJustification()


    /**
     * Test removing left justification.
     *
     * @return void
     */
    public function testRemovingLeftJustification()
    {
        $this->selectText('sit', 'WoW');

        $this->clickTopToolbarButton('justifyLeft', 'active');
        sleep(1);
        $this->clickTopToolbarButton('justifyLeft', 'active');

        $this->assertHTMLMatch('<p>sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

    }//end testRemovingLeftJustification()


    /**
     * Test that you can apply right justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingRightJustify()
    {
        $this->selectText('LOREM', 'dolor');
        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyRight');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: right;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right justify active icon does not appear in the top toolbar');

    }//end testApplyingRightJustify()


    /**
     * Test that you can apply right justification to a paragraph when selecting a bold word.
     *
     * @return void
     */
    public function testApplyingRightJustifyWithBoldWord()
    {
        $this->selectText('BOLD');
        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyRight');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p style="text-align: right;">test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

    }//end testApplyingRightJustifyWithBoldWord()


    /**
     * Test that you can apply right justification to a paragraph when selecting a italic word.
     *
     * @return void
     */
    public function testApplyingRightJustifyWithItalicWord()
    {
        $this->selectText('ITALICS');
        $this->keyDown('Key.CMD + i');
        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyRight');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p style="text-align: right;">test <em>ITALICS</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

    }//end testApplyingRightJustifyWithItalicWord()


    /**
     * Test that when you select a paragraph that has right justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithRightJustification()
    {
        $this->selectText('QvQ', 'Kyk');

        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right justify active icon does not appear in the top toolbar');

    }//end testSelectingParagraphWithRightJustification()


    /**
     * Test removing right justification.
     *
     * @return void
     */
    public function testRemovingRightJustification()
    {
        $this->selectText('QvQ', 'Kyk');

        $this->clickTopToolbarButton('justifyRight', 'active');
        sleep(1);
        $this->clickTopToolbarButton('justifyRight', 'active');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p>QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

    }//end testRemovingRightJustification()


    /**
     * Test that you can apply centre justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingCentreJustify()
    {
        $this->selectText('LOREM', 'dolor');
        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyCenter');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: center;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Centre justify active icon does not appear in the top toolbar');

    }//end testApplyingCentreJustify()


    /**
     * Test that you can apply centre justification to a paragraph when selecting a bold word.
     *
     * @return void
     */
    public function testApplyingCentreJustifyWithBoldWord()
    {
        $this->selectText('BOLD');
        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyCenter');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p style="text-align: center;">test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active right justify icon does not appear in the top toolbar');

    }//end testApplyingCenterJustifyWithBoldWord()


    /**
     * Test that you can apply center justification to a paragraph when selecting a italic word.
     *
     * @return void
     */
    public function testApplyingCenterJustifyWithItalicWord()
    {
        $this->selectText('ITALICS');
        $this->keyDown('Key.CMD + i');
        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyCenter');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p style="text-align: center;">test <em>ITALICS</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');

    }//end testApplyingCenterJustifyWithItalicWord()


    /**
     * Test that when you select a paragraph that has centre justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithCentreJustification()
    {
        $this->selectText('RsR');
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Centre justify active icon does not appear int he top toolbar');

    }//end testSelectingParagraphWithCentreJustification()


    /**
     * Test removing centre justification.
     *
     * @return void
     */
    public function testRemovingCentreJustification()
    {
        $this->selectText('RsR');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyCenter', 'active');
        sleep(1);
        $this->clickTopToolbarButton('justifyCenter', 'active');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p>RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

    }//end testRemovingCentreJustification()


    /**
     * Test that you can apply block justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingBlockJustify()
    {
        $this->selectText('LOREM', 'dolor');
        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyBlock');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: justify;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');


        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Toogle justification icon is not selected');

    }//end testApplyingBlockJustify()


    /**
     * Test that you can apply block justification to a paragraph when selecting a bold word.
     *
     * @return void
     */
    public function testApplyingBlockJustifyWithBoldWord()
    {
        $this->selectText('BOLD');
        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyBlock');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p style="text-align: justify;">test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active right justify icon does not appear in the top toolbar');

    }//end testApplyingBlockJustifyWithBoldWord()


    /**
     * Test that you can apply block justification to a paragraph when selecting a italic word.
     *
     * @return void
     */
    public function testApplyingBlockJustifyWithItalicWord()
    {
        $this->selectText('ITALICS');
        $this->keyDown('Key.CMD + i');
        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyBlock');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p style="text-align: justify;">test <em>ITALICS</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active center justify icon does not appear in the top toolbar');

    }//end testApplyingBlockJustifyWithItalicWord()


    /**
     * Test that when you select a paragraph that has block justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithBlockJustification()
    {
        $this->selectText('MrM', 'GaG');

        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block justify active icon does not appear in the toolbar');

    }//end testSelectingParagraphWithBlockJustification()


    /**
     * Test removing block justification.
     *
     * @return void
     */
    public function testRemovingBlockJustification()
    {
        $this->selectText('MrM', 'GaG');

        $this->clickTopToolbarButton('justifyBlock', 'active');
        sleep(1);
        $this->clickTopToolbarButton('justifyBlock', 'active');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p>MrM GaG</p><p>LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

    }//end testRemovingBlockJustification()


    /**
     * Test that justification is applied to the paragraph when you select a word.
     *
     * @return void
     */
    public function testJustificationWhenSelectingAWord()
    {
        $this->selectText('LOREM');

        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyLeft');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: left;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Acitve left justify icon does not appear in the top toolbar');

    }//end testJustificationWhenSelectingAWord()


    /**
     * Test that when you click in a word and select a justification, it is applied to the paragraph that the word is in..
     *
     * @return void
     */
    public function testJustificationWhenClickingInAWord()
    {
        $this->click($this->find('dolor'));

        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyRight');

        $this->assertHTMLMatch('<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: right;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Acitve right justify icon does not appear in the top toolbar');

    }//end testJustificationWhenClickingInAWord()


    /**
     * Test applying justification to mulitple paragraphs where alignment has already been applied.
     *
     * @return void
     */
    public function testJustificationMultipleParagraphsWithAlignmentsApplied()
    {
        $this->selectText('WoW', 'XuT');

        $this->clickTopToolbarButton('justifyLeft', 'active');
        sleep(1);
        $this->clickTopToolbarButton('justifyRight');

        $this->assertHTMLMatch(
            '<p style="text-align: right;">sit amet WoW</p><p style="text-align: right;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: right;">MrM GaG</p><p>LOREM XuT dolor</p><p style="text-align: right;">test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>',
            '<p style="text-align: right; ">sit amet WoW</p><p style="text-align: right; ">RsR TpT</p><p style="text-align: right; ">QvQ KyK</p><p style="text-align: right; ">MrM GaG</p><p style="text-align: right;">LOREM XuT dolor</p><p>test <strong>BOLD</strong> text</p><p>test ITALICS text.</p>');

        $this->click($this->find('BOLD'));

        $this->selectText('WoW', 'XuT');

        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Acitve right justify icon does not appear in the top toolbar');

    }//end testJustificationMultipleParagraphsWithAlignmentsApplied()


    /**
     * Test applying justification to mulitple paragraphs where alignment has not been applied.
     *
     * @return void
     */
    public function testJustificationMultipleParagraphsWithNoAlignmentsApplied()
    {
        $this->selectText('XuT', 'ITALICS');

        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyCenter');

        $this->assertHTMLMatch(
            '<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: center;">LOREM XuT dolor</p><p style="text-align: center;">test <strong>BOLD</strong> text</p><p style="text-align: center;">test ITALICS text.</p>',
            '<p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p><p style="text-align: center; ">LOREM XuT dolor</p><p style="text-align: center; ">test <strong>BOLD</strong> text</p><p style="text-align: center;">test ITALICS text.</p>');

    }//end testJustificationMultipleParagraphsWithNoAlignmentsApplied()


    /**
     * Test that you can apply different alignments to an image.
     *
     * @return void
     */
    public function testAligningAnImage()
    {
        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight'), 'Right justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter'), 'Center justify icon does not appear in the top toolbar');
       // $this->assertFalse($this->topToolbarButtonExists('justifyBlock'), 'Block justify icon appears in the top toolbar');

        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines at the minimum compliance level (Single A) by the end of 2012.</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" width="354" height="160.5854748603352" style="float: left; margin: 1em 1em 1em 0px;" />Federal government agencies must update <strong>all government</strong> websites (as specified within scope under the Website Accessibility National Transition Strategy (NTS)) to WCAG 2.0 conformance.</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines at the minimum compliance level (Single A) by the end of 2012.</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" width="354" height="160.5854748603352" style="margin: 1em auto; display: block;" />Federal government agencies must update <strong>all government</strong> websites (as specified within scope under the Website Accessibility National Transition Strategy (NTS)) to WCAG 2.0 conformance.</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines at the minimum compliance level (Single A) by the end of 2012.</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" width="354" height="160.5854748603352" style="float: right; margin: 1em 0px 1em 1em;" />Federal government agencies must update <strong>all government</strong> websites (as specified within scope under the Website Accessibility National Transition Strategy (NTS)) to WCAG 2.0 conformance.</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>Australian governments at all levels have <strong><em>endorsed</em></strong> WCAG 2.0, and require all government websites (federal, state and territory) to meet the new guidelines at the minimum compliance level (Single A) by the end of 2012.</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="" width="354" height="160.5854748603352" />Federal government agencies must update <strong>all government</strong> websites (as specified within scope under the Website Accessibility National Transition Strategy (NTS)) to WCAG 2.0 conformance.</p>');

    }//end testAligningAnImage()


}//end class

?>
