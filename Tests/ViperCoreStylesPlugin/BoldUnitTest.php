<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_BoldUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testStartOfParaBold()
    {
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

        $this->assertHTMLMatch('<p><strong>Lorem</strong> xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testStartOfParaBold()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaBold()
    {
        $this->selectText('xtn');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

        $this->assertHTMLMatch('<p>Lorem <strong>xtn</strong> dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testMidOfParaBold()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaBold()
    {
        $this->selectText('dolor');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

        $this->assertHTMLMatch('<p>Lorem xtn <strong>dolor</strong></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testEndOfParaBold()


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
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

        // Click the Top Toolbar icon to make whole paragraph bold.
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');

        $this->assertHTMLMatch('<p><strong>Lorem xtn dolor</strong></p><p>sit amet <strong>consectetur</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

    }//end testParagraphSelection()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectText('xtn');
        $this->keyDown('Key.CMD + b');

        $this->selectText('Lorem', 'xtn');
        $this->keyDown('Key.CMD + b');

        $this->selectText('xtn', 'dolor');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p><strong>Lorem xtn dolor</strong></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectText('xtn');
        $this->keyDown('Key.CMD + b');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $this->selectText('dolor');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p><strong>Lorem</strong> <strong>xtn</strong> <strong>dolor</strong></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that style can be removed.
     *
     * @return void
     */
    public function testRemoveBold()
    {
        $this->selectText('consectetur');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet consectetur</p>');

    }//end testRemoveBold()


}//end class

?>
