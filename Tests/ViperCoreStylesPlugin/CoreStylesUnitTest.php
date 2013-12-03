<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_CoreStylesUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that style can be applied to the selection.
     *
     * @return void
     */
    public function testAllStyles()
    {
        $this->selectKeyword(1);

        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');

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
        $this->sikuli->keyDown('Key.CMD + b');

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + i');

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

        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');
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
        $this->sikuli->click($this->findKeyword(2));
        $this->selectKeyword(1, 4);
        $this->sikuli->keyDown('Key.CMD + b');

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
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + b');

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
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        usleep(50000);
        $this->sikuli->keyDown('Key.CMD + i');
        usleep(50000);
        $this->sikuli->keyDown('Key.CMD + i');
        usleep(50000);
        $this->sikuli->keyDown('Key.CMD + b');
        usleep(50000);

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
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');

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
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon is not active in the top toolbar');

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon is not active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon is not active in the top toolbar');

        $this->assertHTMLMatch('<p><strong><em>%1%</em></strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        //Remove italics
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon is still active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon is still active in the top toolbar');

        //Remove bold
        $this->sikuli->keyDown('Key.CMD + b');

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
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon appears in the inline toolbar');
        $this->assertFalse($this->topToolbarButtonExists('italic', 'active'), 'Active Italic icon appears in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active Bold icon appears in the inline toolbar');

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon appears in the inline toolbar');
        $this->assertFalse($this->topToolbarButtonExists('italic', 'active'), 'Active Italic icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon appears in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active Bold icon appears in the inline toolbar');

    }//end testSelectingTextInAParagraph()


    /**
     * Test that starting and stopping styles is working with keyboard shortcuts.
     *
     * @return void
     */
    public function testStartAndStopStyleWithShortcut()
    {
        $this->moveToKeyword(1, 'right');

        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->type('TEST');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');

        $this->type(' ');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->type('TEST');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');

        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->type('TEST');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->type('TEST');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->type('TEST');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->sikuli->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>%1%<strong>TEST</strong><em><strong>TEST</strong></em>TEST<strong>TEST<em>TEST</em></strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStartAndStopStyleWithShortcut()


    /**
     * Test that starting and stopping styles is working with toolbar buttons.
     *
     * @return void
     */
    public function testStartAndStopStyleWithButtons()
    {
        $this->moveToKeyword(1, 'right');

        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->type('TEST');
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');

        $this->type(' ');
        $this->clickTopToolbarButton('italic');
        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->type('TEST');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->type('TEST');
        $this->clickTopToolbarButton('bold');
        $this->type('TEST');
        $this->clickTopToolbarButton('italic');
        $this->type('TEST');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertHTMLMatch('<p>%1%<strong>TEST</strong><em><strong>TEST</strong></em>TEST<strong>TEST<em>TEST</em></strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStartAndStopStyleWithButtons()


    /**
     * Test that starting and stopping styles is working inside existing styles.
     *
     * @return void
     */
    public function testStartAndStopStylesInActiveStyles()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p><em><strong>%1% %2% %3%</strong></em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->moveToKeyword(1, 'right');

        $this->type(' ');

        // Turn on and off bold.
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->type('TEST');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->type('TEST');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->type('TEST');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->type('TEST');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->type('TEST');

        $this->assertHTMLMatch('<p><em><strong>%1%</strong></em>TESTTEST<strong>TEST</strong>TEST<strong><em>TEST</em></strong><em><strong> %2% %3%</strong></em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStartAndStopStylesInActiveStyles()


    /**
     * Test that stopping styles is working at the end of an existing style.
     *
     * @return void
     */
    public function testStopStyleAtTheEndOfStyleTag()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p><em><strong>%1% %2% %3%</strong></em></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->moveToKeyword(3, 'right');

        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'italic icon in the top toolbar is active');
        $this->type('TEST');

        $this->assertHTMLMatch('<p><em><strong>%1% %2% %3%</strong></em>TEST</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStopStyleAtTheEndOfStyleTag()


    /**
     * Test that you can start styles for a new parargraph.
     *
     * @return void
     */
    public function testStartingStylesForNewParagraph()
    {
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');

        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon in the top toolbar should be active');
        $this->type('This is a new paragraph');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p><strong><em>This is a new paragraph</em></strong></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStartingStylesForNewParagraph()


    /**
     * Test that you can start styles for a new parargraph using icon.
     *
     * @return void
     */
    public function testStartingStylesForNewParagraphUsingIcons()
    {
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');

        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon in the top toolbar should be active');
        $this->type('This is a new paragraph');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p><strong><em>This is a new paragraph</em></strong></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStartingStylesForNewParagraphUsingIcons()


    /**
     * Test stopping and starting styles after a word that is already styled.
     *
     * @return void
     */
    public function testStartingAndStoppingStylesAfterWordThatIsStyled()
    {
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'italic icon in the top toolbar should not be active');
        $this->type('test');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon in the top toolbar should be active');
        $this->type('test');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em>test<em>test</em> <strong>%5%</strong></p>');

        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'bold icon in the top toolbar should not be active');
        $this->type('test');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'bold icon in the top toolbar should be active');
        $this->type('test');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em>test<em>test</em> <strong>%5%</strong>test<strong>test</strong></p>');


    }//end testStartingAndStoppingStylesAfterWordThatIsStyled()


    /**
     * Test that you can start styles for a new parargraph using icon.
     *
     * @return void
     */
    public function testStartingAndStoppingStylesAfterWordThatIsStyledUsingIcons()
    {
        $this->moveToKeyword(4, 'right');
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'italic icon in the top toolbar should not be active');
        $this->type('test');
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon in the top toolbar should be active');
        $this->type('test');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em>test<em>test</em> <strong>%5%</strong></p>');

        $this->moveToKeyword(5, 'right');
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'bold icon in the top toolbar should not be active');

        $this->type('test');
        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'bold icon in the top toolbar should be active');
        $this->type('test');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em>test<em>test</em> <strong>%5%</strong>test<strong>test</strong></p>');

    }//end testStartingAndStoppingStylesAfterWordThatIsStyledUsingIcons()


}//end class

?>
