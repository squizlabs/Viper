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
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold');
        $this->clickTopToolbarButton('italic');
        $this->clickTopToolbarButton('subscript');
        $this->clickTopToolbarButton('superscript');
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p><strong><em><sub><sup><del>%1%</del></sup></sub></em></strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove strike.
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<p><strong><em><sub><sup>%1%</sup></sub></em></strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove sub.
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('<p><strong><em><sup>%1%</sup></em></strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        //Remove italics
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p><strong><sup>%1%</sup></strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        //Remove bold
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p><sup>%1%</sup> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        //Remove superscript
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAllStyles()


    /**
     * Test that styling.
     *
     * @return void
     */
    public function testStyleTags()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p><em><strong>%1%</strong> %2%</em> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStyleTags()


    /**
     * Tests that removing multiple styles spanning multiple paragraphs work.
     *
     * @return void
     */
    public function testMultiParaRemoveStyles()
    {
        $this->useTest(1);

        $this->selectKeyword(1, 4);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar should be active');
        $this->assertHTMLMatch('<p><strong><em>%1% %2% %3%</em></strong></p><p><em><strong>sit %4%</strong></em> <strong>%5%</strong></p>');

        $this->selectKeyword(1, 4);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar should not be active');
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar should not be active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar should not be active');

    }//end testMultiParaRemoveStyles()


    /**
     * Tests that applying styles to whole paragraph and selecting the P in lineage shows paragraph tools.
     *
     * @return void
     */
    public function testSelectParaFromToolbarLineageAfterStyling()
    {
        $this->useTest(1);

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

    }//end testSelectParaFromToolbarLineageAfterStyling()


    /**
     * Test that bold and italics work together.
     *
     * @return void
     */
    public function testBoldAndItalic()
    {
        $this->useTest(1);

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
        $this->assertHTMLMatch('<p><strong>%1%</strong> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        //Remove bold
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon is still active in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon is still active in the top toolbar');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testBoldAndItalic()


    /**
     * Test that starting and stopping styles is working with keyboard shortcuts.
     *
     * @return void
     */
    public function testStartAndStopStyleWithShortcut()
    {
        $this->useTest(1);

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
        $this->useTest(1);

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
        $this->useTest(1);

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
        $this->useTest(1);

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
        $this->useTest(1);

        // Test using keyboard shortcuts
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon in the top toolbar should be active');
        $this->type('This is a new paragraph');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p><strong><em>This is a new paragraph</em></strong></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Test using icons
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar should be active');
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon in the top toolbar should be active');
        $this->type('This is another new paragraph');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p><strong><em>This is a new paragraph</em></strong></p><p><strong><em>This is another new paragraph</em></strong></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');


    }//end testStartingStylesForNewParagraph()


    /**
     * Test stopping and starting styles after a word that is already styled.
     *
     * @return void
     */
    public function testStartingAndStoppingStylesAfterWordThatIsStyled()
    {
        $this->useTest(1);

        // Test using keyboard shortcuts
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'italic icon in the top toolbar should not be active');
        $this->type(' test ');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon in the top toolbar should be active');
        $this->type('%6%');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> test <em>%6%</em> <strong>%5%</strong></p>');

        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'bold icon in the top toolbar should not be active');
        $this->type(' test ');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'bold icon in the top toolbar should be active');
        $this->type('%7%');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> test <em>%6%</em> <strong>%5%</strong> test <strong>%7%</strong></p>');

        // Test using toolbar icons
        $this->moveToKeyword(6, 'right');
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'italic icon in the top toolbar should not be active');
        $this->type('test');
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon in the top toolbar should be active');
        $this->type('test');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> test <em>%6%</em>test<em>test</em> <strong>%5%</strong> test <strong>%7%</strong></p>');

        $this->moveToKeyword(7, 'right');
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'bold icon in the top toolbar should not be active');
        $this->type('test');
        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'bold icon in the top toolbar should be active');
        $this->type('test');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> test <em>%6%</em>test<em>test</em> <strong>%5%</strong> test <strong>%7%</strong>test<strong>test</strong></p>');

    }//end testStartingAndStoppingStylesAfterWordThatIsStyled()


    /**
     * Test checking that the strong and italic tags is not used when you delete content and add new content.
     *
     * @return void
     */
    public function testDeletingBoldAndItalicContent()
    {
        // Test using forward delete
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>%1% this is new content %3%</p>');

        // Test using backspace
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>%1% this is new content %3%</p>');

        // Test selecting the content and typing over it keeps the formatting.
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->type('this is new content');
        $this->assertHTMLMatch('<p>%1% <em><strong>this is new content</strong></em> %3%</p>');

    }//end testDeletingBoldAndItalicContent()


    /**
     * Test that undo and redo buttons for bold formatting.
     *
     * @return void
     */
    public function testRemoveBoldAndItalicFromLinkInBoldAndItalicParagraph()
    {

        // Test removing bold and italic for link using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p><strong><em>Test content </em></strong><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> <strong><em>more test content.</em></strong></p>');

        // Test removing bold and italic for link using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p><strong><em>Test content </em></strong><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> <strong><em>more test content.</em></strong></p>');

        // Test removing bold and italic for link using the keyboard shortcuts
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p><strong><em>Test content </em></strong><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> <strong><em>more test content.</em></strong></p>');

    }//end testRemoveBoldAndItalicFromLinkInBoldAndItalicParagraph()


}//end class

?>
