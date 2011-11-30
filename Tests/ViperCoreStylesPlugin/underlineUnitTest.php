<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_UnderlineUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that underline style can be applied to the selection.
     *
     * @return void
     */
    public function testStartOfParaUnderline()
    {
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));

        $this->assertHTMLMatch('<p><u>Lorem</u> IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testStartOfParaUnderline()


    /**
     * Test that underline style can be applied to the selection.
     *
     * @return void
     */
    public function testMidOfParaUnderline()
    {
        $this->selectText('IPSUM');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));

        $this->assertHTMLMatch('<p>Lorem <u>IPSUM</u> dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testMidOfParaUnderline()


    /**
     * Test that underline style can be applied to the selection.
     *
     * @return void
     */
    public function testEndOfParaUnderline()
    {
        $this->selectText('dolor');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));

        $this->assertHTMLMatch('<p>Lorem IPSUM <u>dolor</u></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testEndOfParaUnderline()


    /**
     * Test that underline style can be removed.
     *
     * @return void
     */
    public function testParagraphSelection()
    {
        $start = $this->find('Lorem');
        $end = $this->find('dolor');
        $this->dragDrop($this->getTopLeft($start), $this->getTopRight($end));

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));

        // Click the Top Toolbar icon to make whole paragraph underline.
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_underline.png');

        $this->assertHTMLMatch('<p><u>Lorem IPSUM dolor</u></p><p>sit amet <strong>consectetur</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_underline_active.png'));

    }//end testParagraphSelection()


    /**
     * Test that underline style can be applied to the selection.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + u');

        $this->selectText('Lorem', 'IPSUM');
        $this->keyDown('Key.CMD + u');

        $this->selectText('IPSUM', 'dolor');
        $this->keyDown('Key.CMD + u');

        $this->assertHTMLMatch('<p><u>Lorem IPSUM dolor</u></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that underline style can be applied to the selection.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + u');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + u');

        $this->selectText('dolor');
        $this->keyDown('Key.CMD + u');

        $this->assertHTMLMatch('<p><u>Lorem</u> <u>IPSUM</u> <u>dolor</u></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that underline style can be removed.
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

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet consectetur</p>');

    }//end testRemoveUnderline()


}//end class

?>
