<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_ItalicUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that italic style can be applied to the selection.
     *
     * @return void
     */
    public function testStartOfParaItalic()
    {
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->assertHTMLMatch('<p><em>Lorem</em> IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testStartOfParaItalic()


    /**
     * Test that italic style can be applied to the selection.
     *
     * @return void
     */
    public function testMidOfParaItalic()
    {
        $this->selectText('IPSUM');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->assertHTMLMatch('<p>Lorem <em>IPSUM</em> dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testMidOfParaItalic()


    /**
     * Test that italic style can be applied to the selection.
     *
     * @return void
     */
    public function testEndOfParaItalic()
    {
        $this->selectText('dolor');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->assertHTMLMatch('<p>Lorem IPSUM <em>dolor</em></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testEndOfParaItalic()


    /**
     * Test that italic style can be removed.
     *
     * @return void
     */
    public function testParagraphSelection()
    {
        $start = $this->find('Lorem');
        $end = $this->find('dolor');
        $this->dragDrop($this->getTopLeft($start), $this->getTopRight($end));

        // Inline Toolbar icon should not be displayed.
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        // Click the Top Toolbar icon to make whole paragraph italic.
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');

        $this->assertHTMLMatch('<p><em>Lorem IPSUM dolor</em></p><p>sit amet <strong>consectetur</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

    }//end testParagraphSelection()


    /**
     * Test that italic style can be applied to the selection.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + i');

        $this->selectText('Lorem', 'IPSUM');
        $this->keyDown('Key.CMD + i');

        $this->selectText('IPSUM', 'dolor');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p><em>Lorem IPSUM dolor</em></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that italic style can be applied to the selection.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + i');

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $this->selectText('dolor');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<p><em>Lorem</em> <em>IPSUM</em> <em>dolor</em></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that italic style can be removed.
     *
     * @return void
     */
    public function testRemoveItalic()
    {
        $this->selectText('consectetur');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet consectetur</p>');

    }//end testRemoveItalic()


}//end class

?>
