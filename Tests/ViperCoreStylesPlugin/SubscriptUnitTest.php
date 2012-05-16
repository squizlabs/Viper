<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_SubscriptUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testStartOfParaSubscript()
    {
        $this->selectText('Lorem');

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><sub>Lorem</sub> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testStartOfParaSubscript()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaSubscript()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <sub>XuT</sub> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testMidOfParaSubscript()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaSubscript()
    {
        $this->selectText('dolor');

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT <sub>dolor</sub></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testEndOfParaSubscript()


    /**
     * Test that strikethrough is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemovingFormatFromPartOfTheContentA()
    {
        $dolor = $this->find('dolor');
        $xut   = $this->find('xut');

        $this->selectText('XuT', 'dolor');

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <sub>XuT dolor</sub></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->doubleClick($dolor);

        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>Lorem <sub>XuT </sub>dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('XuT');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

    }//end testRemovingFormatFromPartOfTheContent()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectText('XuT');
        $this->clickTopToolbarButton('subscript');

        $this->selectText('Lorem');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('subscript');

        $this->selectText('XuT', 'dolor');
        $this->clickTopToolbarButton('subscript');

        $this->assertHTMLMatch('<p><sub>Lorem XuT dolor</sub></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectText('XuT');
        $this->clickTopToolbarButton('subscript');

        $this->selectText('Lorem');
        $this->clickTopToolbarButton('subscript');

        $this->selectText('dolor');
        $this->clickTopToolbarButton('subscript');

        $this->assertHTMLMatch('<p><sub>Lorem</sub> <sub>XuT</sub> <sub>dolor</sub></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that subscript can be removed.
     *
     * @return void
     */
    public function testRemoveFormating()
    {
        $text    = 'WoW';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong><sub>WoW</sub></strong></p>');

        $this->click($textLoc);
        $this->selectText($text);

         $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon is still active in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testRemoveFormating()


    /**
     * Test that the subscript icon is active when you select a word that has strikethrough applied.
     *
     * @return void
     */
    public function testIconsIsActive()
    {
        $text    = 'WoW';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

    }//end testIconsIsActive()


    /**
     * Test that you can undo subscript after you have applied it.
     *
     * @return void
     */
    public function testUndoSubscript()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <sub>XuT</sub> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar should not be active');

    }//end testUndoSubscript()



}//end class

?>
