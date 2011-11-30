<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_BoldUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that bold style can be applied to the selection.
     *
     * @return void
     */
    public function testStartOfParaBold()
    {
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

        $this->assertHTMLMatch('<p><strong>Lorem</strong> IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testStartOfParaBold()


    /**
     * Test that bold style can be applied to the selection.
     *
     * @return void
     */
    public function testMidOfParaBold()
    {
        $this->selectText('IPSUM');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

        $this->assertHTMLMatch('<p>Lorem <strong>IPSUM</strong> dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testMidOfParaBold()


    /**
     * Test that bold style can be applied to the selection.
     *
     * @return void
     */
    public function testEndOfParaBold()
    {
        $this->selectText('dolor');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

        $this->assertHTMLMatch('<p>Lorem IPSUM <strong>dolor</strong></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testEndOfParaBold()


    /**
     * Test that bold style can be removed.
     *
     * @return void
     */
    public function testParagraphSelection()
    {
        $start = $this->find('Lorem');
        $end = $this->find('dolor');
        $this->dragDrop($this->getTopLeft($start), $this->getTopRight($end));

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

        // Click the Top Toolbar icon to make whole paragraph bold.
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');

        $this->assertHTMLMatch('<p><strong>Lorem IPSUM dolor</strong></p><p>sit amet <strong>consectetur</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

    }//end testParagraphSelection()


    /**
     * Test that bold style can be applied to the selection.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + b');

        $this->selectText('Lorem', 'IPSUM');
        $this->keyDown('Key.CMD + b');

        $this->selectText('IPSUM', 'dolor');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p><strong>Lorem IPSUM dolor</strong></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that bold style can be applied to the selection.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + b');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $this->selectText('dolor');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p><strong>Lorem</strong> <strong>IPSUM</strong> <strong>dolor</strong></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that bold style can be removed.
     *
     * @return void
     */
    public function testRemoveBold()
    {
        $this->selectText('consectetur');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet consectetur</p>');

    }//end testRemoveBold()


}//end class

?>
