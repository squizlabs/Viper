<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_StylesUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that style can be applied to the selection.
     *
     * @return void
     */
    public function testAllStyles()
    {
        $this->selectKeyword(1);

        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->clickTopToolbarButton('subscript');
        $this->clickTopToolbarButton('superscript');
        $this->clickTopToolbarButton('strikethrough');

        // Remove strike and sub.
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->clickTopToolbarButton('subscript', 'active');

        $this->assertHTMLMatch('<p><strong><em><sup>%1%</sup></em></strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        //Remove italics
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p><strong><sup>%1%</sup></strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        //Remove bold
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p><sup>%1%</sup> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAllStyles()


    /**
     * Test that styling.
     *
     * @return void
     */
    public function testStyleTags()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');

        $this->selectKeyword(1, 2);
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p><em><strong>%1%</strong> %2%</em> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStyleTags()


    /**
     * Test that style can be removed from the selection.
     *
     * @return void
     */
    public function testRemoveFormat()
    {
        $this->selectKeyword(1);

        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p><strong><em>%1%</em></strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('removeFormat');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testRemoveFormat()


    /**
     * Tests that adding styles spanning multiple paragraphs work.
     *
     * @return void
     */
    public function testMultiParaApplyStyle()
    {
        $this->selectKeyword(1, 4);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p><strong>%1% %2% %3%</strong></p><p><strong>sit <em>%4%</em></strong> <strong>%5%</strong></p>');

    }//end testMultiParaApplyStyle()


    /**
     * Tests that removing styles spanning multiple paragraphs work.
     *
     * @return void
     */
    public function testMultiParaRemoveStyle()
    {
        $this->selectKeyword(1, 4);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testMultiParaRemoveStyle()


    /**
     * Tests that removing multiple styles spanning multiple paragraphs work.
     *
     * @return void
     */
    public function testMultiParaRemoveStyles()
    {
        $this->selectKeyword(1, 4);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $this->keyDown('Key.CMD + i');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

    }//end testMultiParaRemoveStyles()


    /**
     * Tests that applying styles to whole paragraph and selecting the P in lineage shows paragraph tools.
     *
     * @return void
     */
    public function testSelectParaAfterStyling()
    {
        $this->selectKeyword(1, 3);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->selectInlineToolbarLineageItem(0);

        // Make sure bold icon is not shown in the toolbar.
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active bold icon is still shown in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon is still shown in the inline toolbar');

        // Make sure italic icon is not shown in the toolbar.
        $this->assertFalse($this->inlineToolbarButtonExists('italic', 'active'), 'Active italic icon is still shown in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon is still shown in the inline toolbar');

    }//end testSelectParaAfterStyling()


    /**
     * Test that bold and italics work together.
     *
     * @return void
     */
    public function testBoldAndItalic()
    {
        $this->selectKeyword(1);

        //Add bold and italics
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon is not active in the top toolbar');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon is not active in the top toolbar');

        $this->assertHTMLMatch('<p><strong><em>%1%</em></strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        //Remove italics
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');

        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon is still active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon is still active in the top toolbar');

        //Remove bold
        $this->keyDown('Key.CMD + b');

        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon is still active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon is still active in the top toolbar');

    }//end testBoldAndItalic()


     /**
     * Tests selecting text in a paragraph.
     *
     * @return void
     */
    public function testSelectingTextInAParagraph()
    {
        $this->selectKeyword(1, 4);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon appears in the inline toolbar');
        $this->assertFalse($this->topToolbarButtonExists('italic', 'active'), 'Active Italic icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active Bold icon appears in the inline toolbar');

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon appears in the inline toolbar');
        $this->assertFalse($this->topToolbarButtonExists('italic', 'active'), 'Active Italic icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active Bold icon appears in the inline toolbar');

    }//end testSelectingTextInAParagraph()

}//end class

?>
