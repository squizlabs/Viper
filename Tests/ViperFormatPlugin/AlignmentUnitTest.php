<?php

require_once 'AbstractFormatsUnitTest.php';

class Viper_Tests_ViperFormatPlugin_AlignmentUnitTest extends AbstractFormatsUnitTest
{


    /**
     * Test that you can apply and remove justification when clicking inside a word.
     *
     * @return void
     */
    public function testApplyAndRemoveJustificationWhenClickingInWord()
    {
        $this->useTest(1);

        // Apply left justify
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

        // Remove left justify
        $this->moveToKeyword(1);
        usleep(300000);
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');

        // Apply centre justify
        $this->moveToKeyword(1);
        usleep(300000);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p style="text-align: center;">%1% test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active centrr justify icon does not appear in the top toolbar');

        // Remove centre justify
        $this->moveToKeyword(1);
        usleep(300000);
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');

        // Apply right justify
        $this->moveToKeyword(1);
        usleep(300000);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p style="text-align: right;">%1% test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

        // Remove left justify
        $this->moveToKeyword(1);
        usleep(300000);
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');

        // Apply block justify
        $this->moveToKeyword(1);
        usleep(300000);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p style="text-align: justify;">%1% test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active block justify icon does not appear in the top toolbar');

        // Remove block justify
        $this->moveToKeyword(1);
        usleep(300000);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');

    }//end testApplyAndRemoveJustificationWhenClickingInWord()


    /**
     * Test that you can apply and remove justification when selecting a word.
     *
     * @return void
     */
    public function testApplyAndRemoveJustificationWhenSelectingAWord()
    {
        $this->useTest(1);

        // Apply left justify
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

        // Remove left justify
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');

        // Apply centre justify
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p style="text-align: center;">%1% test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active centrr justify icon does not appear in the top toolbar');

        // Remove centre justify
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');

        // Apply right justify
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p style="text-align: right;">%1% test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

        // Remove left justify
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');

        // Apply block justify
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p style="text-align: justify;">%1% test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active block justify icon does not appear in the top toolbar');

        // Remove block justify
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');

    }//end testApplyAndRemoveJustificationWhenSelectingAWord()


    /**
     * Test that you can apply and remove justification when selecting a paragraph.
     *
     * @return void
     */
    public function testApplyAndRemoveJustificationWhenSelectingParagraph()
    {
        $this->useTest(1);

        // Apply left justify
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

        // Remove left justify
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');

        // Apply centre justify
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p style="text-align: center;">%1% test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active centrr justify icon does not appear in the top toolbar');

        // Remove centre justify
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');

        // Apply right justify
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p style="text-align: right;">%1% test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

        // Remove left justify
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');

        // Apply block justify
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p style="text-align: justify;">%1% test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active block justify icon does not appear in the top toolbar');

        // Remove block justify
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');

    }//end testApplyAndRemoveJustificationWhenSelectingParagraph()


    /**
     * Test that you can apply and remove each justification type to a paragraph when selecting a bold word.
     *
     * @return void
     */
    public function testApplyAndRemoveJustificationWhenSelectingBoldWord()
    {
        $this->useTest(2);

        // Apply left justification
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p style="text-align: left;">test content <strong>%1%</strong> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

        //Remove left justification
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->assertHTMLMatch('<p>test content <strong>%1%</strong> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Active left justify icon should not appear in the top toolbar');

        // Apply centre justification
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p style="text-align: center;">test content <strong>%1%</strong> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active centre justify icon does not appear in the top toolbar');

        //Remove center justification
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->assertHTMLMatch('<p>test content <strong>%1%</strong> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Active center justify icon should not appear in the top toolbar');

        // Apply right justification
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p style="text-align: right;">test content <strong>%1%</strong> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

        //Remove center justification
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>test content <strong>%1%</strong> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Active right justify icon should not appear in the top toolbar');

        // Apply block justification
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p style="text-align: justify;">test content <strong>%1%</strong> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active block justify icon does not appear in the top toolbar');

        //Remove block justification
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>test content <strong>%1%</strong> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Active block justify icon should not appear in the top toolbar');

    }//end testApplyAndRemoveJustificationWhenSelectingBoldWord()


    /**
     * Test that you can apply and remove each justification type to a paragraph when selecting an italic word.
     *
     * @return void
     */
    public function testApplyAndRemoveJustificationWhenSelectingItalicWord()
    {
        $this->useTest(3);

        // Apply left justification
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p style="text-align: left;">test content <em>%1%</em> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Active left justify icon does not appear in the top toolbar');

        //Remove left justification
        $this->clickTopToolbarButton('justifyLeft', 'active');
        $this->assertHTMLMatch('<p>test content <em>%1%</em> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Active left justify icon should not appear in the top toolbar');

        // Apply centre justification
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p style="text-align: center;">test content <em>%1%</em> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Active centre justify icon does not appear in the top toolbar');

        //Remove center justification
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->assertHTMLMatch('<p>test content <em>%1%</em> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Active center justify icon should not appear in the top toolbar');

        // Apply right justification
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p style="text-align: right;">test content <em>%1%</em> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Active right justify icon does not appear in the top toolbar');

        //Remove center justification
        $this->clickTopToolbarButton('justifyRight', 'active');
        $this->assertHTMLMatch('<p>test content <em>%1%</em> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Active right justify icon should not appear in the top toolbar');

        // Apply block justification
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p style="text-align: justify;">test content <em>%1%</em> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Active block justify icon does not appear in the top toolbar');

        //Remove block justification
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->assertHTMLMatch('<p>test content <em>%1%</em> more test content</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Active block justify icon should not appear in the top toolbar');

    }//end testApplyAndRemoveJustificationWhenSelectingItalicWord()


    /**
     * Test applying justification to mulitple paragraphs where alignment has already been applied.
     *
     * @return void
     */
    public function testJustificationMultipleParagraphsWithAlignmentsApplied()
    {
        // Apply left justify
        $this->useTest(4);
        $this->selectkeyword(2, 6);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% amet %2%</p><p style="text-align: left;">%3% TpT</p><p style="text-align: left;">%4% aaa</p><p style="text-align: left;">%5% GaG</p><p style="text-align: left;">test content %6% more test content</p>');
        $this->selectkeyword(2, 6);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Acitve left justify icon does not appear in the top toolbar');

        // Apply centre justify
        $this->useTest(4);
        $this->selectkeyword(2, 6);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p style="text-align: center;">%1% amet %2%</p><p style="text-align: center;">%3% TpT</p><p style="text-align: center;">%4% aaa</p><p style="text-align: center;">%5% GaG</p><p style="text-align: center;">test content %6% more test content</p>');
        $this->selectkeyword(2, 6);
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Acitve centre justify icon does not appear in the top toolbar');

        // Apply right justify
        $this->useTest(4);
        $this->selectkeyword(2, 6);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p style="text-align: right;">%1% amet %2%</p><p style="text-align: right;">%3% TpT</p><p style="text-align: right;">%4% aaa</p><p style="text-align: right;">%5% GaG</p><p style="text-align: right;">test content %6% more test content</p>');
        $this->selectkeyword(2, 6);
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Acitve right justify icon does not appear in the top toolbar');

        // Apply block justify
        $this->useTest(4);
        $this->selectkeyword(2, 6);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p style="text-align: justify;">%1% amet %2%</p><p style="text-align: justify;">%3% TpT</p><p style="text-align: justify;">%4% aaa</p><p style="text-align: justify;">%5% GaG</p><p style="text-align: justify;">test content %6% more test content</p>');
        $this->selectkeyword(2, 6);
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Acitve block justify icon does not appear in the top toolbar');

    }//end testJustificationMultipleParagraphsWithAlignmentsApplied()


    /**
     * Test applying justification to mulitple paragraphs where alignment has not been applied.
     *
     * @return void
     */
    public function testJustificationMultipleParagraphsWithNoAlignmentsApplied()
    {
        // Apply left justify
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% test content</p><p style="text-align: left;">another paragraph</p><p style="text-align: left;">more test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Acitve left justify icon does not appear in the top toolbar');
        $this->selectkeyword(1, 2);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Acitve left justify icon does not appear in the top toolbar');

        // Apply centre justify
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p style="text-align: center;">%1% test content</p><p style="text-align: center;">another paragraph</p><p style="text-align: center;">more test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Acitve centre justify icon does not appear in the top toolbar');
        $this->selectkeyword(1, 2);
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Acitve centre justify icon does not appear in the top toolbar');

        // Apply right justify
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p style="text-align: right;">%1% test content</p><p style="text-align: right;">another paragraph</p><p style="text-align: right;">more test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Acitve right justify icon does not appear in the top toolbar');
        $this->selectkeyword(1, 2);
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Acitve right justify icon does not appear in the top toolbar');

        // Apply block justify
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p style="text-align: justify;">%1% test content</p><p style="text-align: justify;">another paragraph</p><p style="text-align: justify;">more test content %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Acitve block icon does not appear in the top toolbar');
        $this->selectkeyword(1, 2);
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Acitve block icon does not appear in the top toolbar');

    }//end testJustificationMultipleParagraphsWithNoAlignmentsApplied()

    /**
     * Test undo and redo icons.
     *
     * @return void
     */
    public function testUndoAndRedoForAlignments()
    {

        // Test left justification
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% test content %2%</p>');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p style="text-align: left;">%1% test content %2%</p>');

        // Test center justification
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyCenter');
        $this->assertHTMLMatch('<p style="text-align: center;">%1% test content %2%</p>');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p style="text-align: center;">%1% test content %2%</p>');

        // Test right justification
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyRight');
        $this->assertHTMLMatch('<p style="text-align: right;">%1% test content %2%</p>');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p style="text-align: right;">%1% test content %2%</p>');

        // Test block justification
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyBlock');
        $this->assertHTMLMatch('<p style="text-align: justify;">%1% test content %2%</p>');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% test content %2%</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p style="text-align: justify;">%1% test content %2%</p>');

    }//end testUndoAndRedoForAlignments()


}//end class

?>
