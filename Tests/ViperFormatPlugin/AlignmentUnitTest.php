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
        $this->sikuli->click($this->findKeyword(7));

        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'));

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: center;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

    }//end testAlignmentInNoneBlockTag()


    /**
     * Test that you can apply left justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingLeftJustify()
    {
        $this->selectKeyword(6, 8);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: left;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

    }//end testApplyingLeftJustify()


    /**
     * Test that you can apply left justification to a paragraph when selecting a bold word.
     *
     * @return void
     */
    public function testApplyingLeftJustifyWithBoldWord()
    {
        $this->selectKeyword(9);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p>%6% %7% %8%</p><p style="text-align: left;">test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

    }//end testApplyingLeftJustifyWithBoldWord()


    /**
     * Test that you can apply left justification to a paragraph when selecting a italic word.
     *
     * @return void
     */
    public function testApplyingLeftJustifyWithItalicWord()
    {
        $this->selectKeyword(10);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p>%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p style="text-align: left;">test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

    }//end testApplyingLeftJustifyWithItalicWord()


    /**
     * Test that when you select a paragraph that has left justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithLeftJustification()
    {
        $this->selectKeyword(1, 2);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left justify icon is not active in the top toolbar');

    }//end testSelectingParagraphWithLeftJustification()


    /**
     * Test removing left justification.
     *
     * @return void
     */
    public function testRemovingLeftJustification()
    {
        $this->selectKeyword(1, 2);

        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->clickTopToolbarButton('justifyLeft', 'active');

        $this->assertHTMLMatch('<p>%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p>%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

    }//end testRemovingLeftJustification()


    /**
     * Test that you can apply right justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingRightJustify()
    {
        $this->selectKeyword(6, 8);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: right;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right justify active icon does not appear in the top toolbar');

    }//end testApplyingRightJustify()


    /**
     * Test that you can apply right justification to a paragraph when selecting a bold word.
     *
     * @return void
     */
    public function testApplyingRightJustifyWithBoldWord()
    {
        $this->selectKeyword(9);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p>%6% %7% %8%</p><p style="text-align: right;">test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

    }//end testApplyingRightJustifyWithBoldWord()


    /**
     * Test that you can apply right justification to a paragraph when selecting a italic word.
     *
     * @return void
     */
    public function testApplyingRightJustifyWithItalicWord()
    {
        $this->selectKeyword(10);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p>%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p style="text-align: right;">test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

    }//end testApplyingRightJustifyWithItalicWord()


    /**
     * Test that when you select a paragraph that has right justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithRightJustification()
    {
        $this->selectkeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right justify active icon does not appear in the top toolbar');

    }//end testSelectingParagraphWithRightJustification()


    /**
     * Test removing right justification.
     *
     * @return void
     */
    public function testRemovingRightJustification()
    {
        $this->selectKeyword(4);

        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->clickTopToolbarButton('justifyRight', 'active');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p>%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p>%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

    }//end testRemovingRightJustification()


    /**
     * Test that you can apply centre justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingCentreJustify()
    {
        $this->selectKeyword(6, 8);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: center;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Centre justify active icon does not appear in the top toolbar');

    }//end testApplyingCentreJustify()


    /**
     * Test that you can apply centre justification to a paragraph when selecting a bold word.
     *
     * @return void
     */
    public function testApplyingCentreJustifyWithBoldWord()
    {
        $this->selectKeyword(9);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p>%6% %7% %8%</p><p style="text-align: center;">test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active right justify icon does not appear in the top toolbar');

    }//end testApplyingCenterJustifyWithBoldWord()


    /**
     * Test that you can apply center justification to a paragraph when selecting a italic word.
     *
     * @return void
     */
    public function testApplyingCenterJustifyWithItalicWord()
    {
        $this->selectKeyword(10);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p>%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p style="text-align: center;">test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');

    }//end testApplyingCenterJustifyWithItalicWord()


    /**
     * Test that when you select a paragraph that has centre justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithCentreJustification()
    {
        $this->selectKeyword(3);
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
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyCenter', 'active');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p>%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p>%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

    }//end testRemovingCentreJustification()


    /**
     * Test that you can apply block justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingBlockJustify()
    {
        $this->selectKeyword(6, 8);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: justify;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Toogle justification icon is not selected');

    }//end testApplyingBlockJustify()


    /**
     * Test that you can apply block justification to a paragraph when selecting a bold word.
     *
     * @return void
     */
    public function testApplyingBlockJustifyWithBoldWord()
    {
        $this->selectKeyword(9);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p>%6% %7% %8%</p><p style="text-align: justify;">test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active right justify icon does not appear in the top toolbar');

    }//end testApplyingBlockJustifyWithBoldWord()


    /**
     * Test that you can apply block justification to a paragraph when selecting a italic word.
     *
     * @return void
     */
    public function testApplyingBlockJustifyWithItalicWord()
    {
        $this->selectKeyword(10);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p>%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p style="text-align: justify;">test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active center justify icon does not appear in the top toolbar');

    }//end testApplyingBlockJustifyWithItalicWord()


    /**
     * Test that when you select a paragraph that has block justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithBlockJustification()
    {
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block justify active icon does not appear in the toolbar');

    }//end testSelectingParagraphWithBlockJustification()


    /**
     * Test removing block justification.
     *
     * @return void
     */
    public function testRemovingBlockJustification()
    {
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyBlock', 'active');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p>%5% GaG</p><p>%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

    }//end testRemovingBlockJustification()


    /**
     * Test that justification is applied to the paragraph when you select a word.
     *
     * @return void
     */
    public function testJustificationWhenSelectingAWord()
    {
        $this->selectKeyword(6);

        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: left;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Acitve left justify icon does not appear in the top toolbar');

    }//end testJustificationWhenSelectingAWord()


    /**
     * Test that when you click in a word and select a justification, it is applied to the paragraph that the word is in..
     *
     * @return void
     */
    public function testJustificationWhenClickingInAWord()
    {
        $this->sikuli->click($this->findKeyword(8));

        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: right;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Acitve right justify icon does not appear in the top toolbar');

    }//end testJustificationWhenClickingInAWord()


    /**
     * Test applying justification to mulitple paragraphs where alignment has already been applied.
     *
     * @return void
     */
    public function testJustificationMultipleParagraphsWithAlignmentsApplied()
    {
        $this->selectkeyword(2, 7);

        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');

        $this->assertHTMLMatch('<p style="text-align: right;">%1% amet %2%</p><p style="text-align: right;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: right;">%5% GaG</p><p style="text-align: right;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->sikuli->click($this->findkeyword(9));

        $this->selectkeyword(2, 7);
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Acitve right justify icon does not appear in the top toolbar');

    }//end testJustificationMultipleParagraphsWithAlignmentsApplied()


    /**
     * Test applying justification to mulitple paragraphs where alignment has not been applied.
     *
     * @return void
     */
    public function testJustificationMultipleParagraphsWithNoAlignmentsApplied()
    {
        $this->selectKeyword(6, 10);

        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: center;">%6% %7% %8%</p><p style="text-align: center;">test <strong>%9%</strong> text</p><p style="text-align: center;">test <em>%10%</em> text.</p>');

    }//end testJustificationMultipleParagraphsWithNoAlignmentsApplied()


    /**
     * Test that you can apply different alignments to an image.
     *
     * @return void
     */
    public function testAligningAnImage()
    {
        $this->clickElement('img', 0);
        $this->clickTopToolbarButton('justifyLeft');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight'), 'Right justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter'), 'Center justify icon does not appear in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'disabled'), 'Block justify icon appears in the top toolbar');

        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" style="float: left; margin: 1em 1em 1em 0px;" />%2% ttt uuu pp %3%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" style="margin: 1em auto; display: block;" />%2% ttt uuu pp %3%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active center justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" style="float: right; margin: 1em 0px 1em 1em;" />%2% ttt uuu pp %3%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>%1% aaa xx cccc</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="354" height="160" />%2% ttt uuu pp %3%</p>');

    }//end testAligningAnImage()


    /**
     * Test undo and redo icons.
     *
     * @return void
     */
    public function testUndoAndRedoForAlignments()
    {
        $this->selectKeyword(6, 8);

        // Test left justification
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: left;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p>%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: left;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        // Test center justification
        $this->clickTopToolbarButton('justifyCenter');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: center;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: left;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: center;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        // Test right justification
        $this->clickTopToolbarButton('justifyRight');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: right;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: center;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: right;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        // Test block justification
        $this->clickTopToolbarButton('justifyBlock');

        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: justify;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: right;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: justify;">%6% %7% %8%</p><p>test <strong>%9%</strong> text</p><p>test <em>%10%</em> text.</p>');

    }//end testUndoAndRedoForAlignments()


}//end class

?>
