<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_SuperscriptUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testStartOfParaSuperscript()
    {
        $this->selectText('Lorem');

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><sup>Lorem</sup> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testStartOfParaSuperscript()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaSuperscript()
    {

        $this->selectText('XuT');

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <sup>XuT</sup> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testMidOfParaSuperscript()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaSuperscript()
    {
        $this->selectText('dolor');

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT <sup>dolor</sup></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testEndOfParaSuperscript()


    /**
     * Test that superscript is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemovingFormatFromPartOfTheContent()
    {
        $dolor = $this->find('dolor');
        $this->selectText('XuT', 'dolor');

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <sup>XuT dolor</sup></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->doubleClick($dolor);

        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>Lorem <sup>XuT </sup>dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->selectText('XuT');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

    }//end testRemovingFormatFromPartOfTheContent()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectText('XuT');
        $this->clickTopToolbarButton('superscript');

        $this->selectText('Lorem', 'XuT');
        $this->clickTopToolbarButton('superscript');

        $this->selectText('XuT', 'dolor');
        $this->clickTopToolbarButton('superscript');

        $this->assertHTMLMatch('<p><sup>Lorem XuT dolor</sup></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectText('XuT');
         $this->clickTopToolbarButton('superscript');

        $this->selectText('Lorem');
        $this->clickTopToolbarButton('superscript');

        $this->selectText('dolor');
        $this->clickTopToolbarButton('superscript');

        $this->assertHTMLMatch('<p><sup>Lorem</sup> <sup>XuT</sup> <sup>dolor</sup></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that subscripy can be removed.
     *
     * @return void
     */
    public function testRemoveFormating()
    {
        $text    = 'WoW';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong><sup>WoW</sup></strong></p>');

        $this->click($textLoc);
        $this->selectText($text);

         $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon is still active in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testRemoveFormating()


    /**
     * Test that the superscript icon is active when you select a word that has superscript applied.
     *
     * @return void
     */
    public function testIconsIsActive()
    {
        $text    = 'WoW';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');

    }//end testIconsIsActive()


    /**
     * Test that you can undo superscript after you have applied it.
     *
     * @return void
     */
    public function testUndoSuperscript()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <sup>XuT</sup> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar should not be active');

    }//end testUndoSuperscript()

}//end class

?>
