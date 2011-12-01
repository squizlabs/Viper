<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_UnderlineUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testStartOfParaUnderline()
    {
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));

        $this->assertHTMLMatch('<p><u>Lorem</u> xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testStartOfParaUnderline()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaUnderline()
    {
        $this->selectText('xtn');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));

        $this->assertHTMLMatch('<p>Lorem <u>xtn</u> dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testMidOfParaUnderline()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaUnderline()
    {
        $this->selectText('dolor');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));

        $this->assertHTMLMatch('<p>Lorem xtn <u>dolor</u></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testEndOfParaUnderline()


    /**
     * Test that VITP icon is not shown when whole P tag is selected but style can be applied using top toolbar.
     *
     * @return void
     */
    public function testParagraphSelection()
    {
        $start = $this->find('Lorem');
        $end   = $this->find('dolor');
        $this->dragDrop($this->getTopLeft($start), $this->getTopRight($end));

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));

        // Click the Top Toolbar icon to make whole paragraph underline.
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');

        $this->assertHTMLMatch('<p><u>Lorem xtn dolor</u></p><p>sit amet <strong>consectetur</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));

    }//end testParagraphSelection()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectText('xtn');
        $this->keyDown('Key.CMD + u');

        $this->selectText('Lorem', 'xtn');
        $this->keyDown('Key.CMD + u');

        $this->selectText('xtn', 'dolor');
        $this->keyDown('Key.CMD + u');

        $this->assertHTMLMatch('<p><u>Lorem xtn dolor</u></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectText('xtn');
        $this->keyDown('Key.CMD + u');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + u');

        $this->selectText('dolor');
        $this->keyDown('Key.CMD + u');

        $this->assertHTMLMatch('<p><u>Lorem</u> <u>xtn</u> <u>dolor</u></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that style can be removed.
     *
     * @return void
     */
    public function testRemoveUnderline()
    {
        $this->selectText('consectetur');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + u');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'));

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet consectetur</p>');

    }//end testRemoveUnderline()


}//end class

?>
