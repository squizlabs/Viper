<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_ItalicUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testStartOfParaItalic()
    {
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Toolbar button is not active');

        $this->assertHTMLMatch('<p><em>Lorem</em> xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testStartOfParaItalic()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaItalic()
    {
        $this->selectText('xtn');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Toolbar button is not active');

        $this->assertHTMLMatch('<p>Lorem <em>xtn</em> dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testMidOfParaItalic()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaItalic()
    {
        $this->selectText('dolor');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Toolbar button is not active');

        $this->assertHTMLMatch('<p>Lorem xtn <em>dolor</em></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testEndOfParaItalic()


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
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Toolbar button is not active');

        // Click the Top Toolbar icon to make whole paragraph italic.
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');

        $this->assertHTMLMatch('<p><em>Lorem xtn dolor</em></p><p>sit amet <strong>consectetur</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'), 'Toolbar button is not active');

    }//end testParagraphSelection()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectText('xtn');
        $this->keyDown('Key.CMD + i');

        $this->selectText('Lorem', 'xtn');
        $this->keyDown('Key.CMD + i');

        $this->selectText('xtn', 'dolor');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p><em>Lorem xtn dolor</em></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectText('xtn');
        $this->keyDown('Key.CMD + i');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->selectText('dolor');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p><em>Lorem</em> <em>xtn</em> <em>dolor</em></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that style can be removed.
     *
     * @return void
     */
    public function testRemoveItalic()
    {
        $this->selectText('consectetur');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet consectetur</p>');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));

    }//end testRemoveItalic()


}//end class

?>
