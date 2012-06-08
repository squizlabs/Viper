<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_DivUnitTest extends AbstractViperUnitTest
{


    /**
     * Test applying the div tag to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testApplingTheDivStyleUsingInlineToolbar()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);

        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><div>%3% is a paragraph to change to a %4%</div>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');

        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);

        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div>%3% is a paragraph to change to a %4%');

    }//end testApplingTheDivStyleUsingInlineToolbar()


    /**
     * Test applying the div tag to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testApplingTheDivStyleUsingTopToolbar()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);

        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><div>%3% is a paragraph to change to a %4%</div>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');

        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);

        $this->assertTrue($this->topToolbarButtonExists('formats', 'selected'), 'Formats icon is not enabled');

    }//end testApplingTheDivStyleUsingTopToolbar()


    /**
     * Test that applying styles to whole Div and selecting the DIV in lineage shows quote tools only.
     *
     * @return void
     */
    public function testSelectDivAfterStylingShowsCorrectIcons()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);

        $this->keyDown('Key.CMD + b');
        sleep(1);
        $this->keyDown('Key.CMD + i');
        sleep(1);

        $this->selectInlineToolbarLineageItem(0);

        // Make sure the correct icons are being shown in the inline toolbar.
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('DIV', 'active', TRUE), 'Div icon is not active');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon is not active');

    }//end testSelectDivAfterStylingShowsCorrectIcons()


     /**
     * Test selecting text in a Div shows the Div icons in the inline toolbar.
     *
     * @return void
     */
    public function testSelectingDivWithFormattedTextShowsCorrectIcons()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('DIV', 'active', TRUE), 'Div icon is not active');

        $this->click($this->findKeyword(4));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('DIV', 'active', TRUE), 'Div icon is not active');

    }//end testSelectingDivWithFormattedTextShowsCorrectIcons()


    /**
     * Test bold works in Div.
     *
     * @return void
     */
    public function testUsingBoldInDiv()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<div><strong>%1%</strong> xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p>');

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p>');

    }//end testUsingBoldInDiv()


    /**
     * Test italics works in Div.
     *
     * @return void
     */
    public function testUsingItalicInDiv()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<div><em>%1%</em> xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p>');

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p>');

    }//end testUsingItalicInDiv()


    /**
     * Test that the div icon is selected when you switch between selection and div.
     *
     * @return void
     */
    public function testDivIconIsActiveWhenSelectingDivTag()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('DIV', 'active', TRUE), 'Div icon is not active');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is still active in the inline toolbar');

    }//end testDivIconIsActiveWhenSelectingDivTag()


    /**
     * Test that when you only select part of a paragraph and apply the div, it applies it to the whole paragraph.
     *
     * @return void
     */
    public function testDivAppliedToParagraphOnPartialSelection()
    {
        $this->selectKeyword(3);
        $this->assertFalse($this->inlineToolbarButtonExists('formats-p', 'active'), 'Toogle formats icon should not appear in the inline toolbar');

        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);

        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><div>%3% is a paragraph to change to a %4%</div>');

    }//end testDivAppliedToParagraphOnPartialSelection()


    /**
     * Test applying and then removing the Div format.
     *
     * @return void
     */
    public function testApplyingAndRemovingDiv()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);

        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><div>%3% is a paragraph to change to a %4%</div>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(3 );
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);

        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div>%3% is a paragraph to change to a %4%');

        $this->assertFalse($this->topToolbarButtonExists('DIV', 'active', TRUE));

    }//end testApplyingAndRemovingDiv()


    /**
     * Test creating new content in div's.
     *
     * @return void
     */
    public function testCreatingNewContentWithADivTag()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('New %5%');
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->selectKeyword(5);
        $this->keyDown('Key.RIGHT');
        $this->type(' on the page');
        $this->keyDown('Key.ENTER');
        $this->type('More new content');

        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>New %5% on the page</div><p>More new content</p>');

    }//end testCreatingNewContentWithADivTag()


}//end class

?>
