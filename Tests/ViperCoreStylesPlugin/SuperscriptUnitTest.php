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
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');

        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sup_active.png'), 'Superscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><sup>Lorem</sup> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testStartOfParaSuperscript()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaSuperscript()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sup_active.png'), 'Superscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <sup>XuT</sup> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testMidOfParaSuperscript()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaSuperscript()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');

        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sup_active.png'), 'Superscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT <sup>dolor</sup></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testEndOfParaSuperscript()


    /**
     * Test that superscript is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemovingFormatFromPartOfTheContent()
    {
        $dir = dirname(__FILE__).'/Images/';

        $dolor = $this->find('dolor');
        $xut   = $this->find('xut');

        $this->selectText('XuT', 'dolor');

        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sup_active.png'), 'Superscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <sup>XuT dolor</sup></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->doubleClick($dolor);

        $this->clickTopToolbarButton($dir.'toolbarIcon_sup_active.png');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_sup.png'), 'Superscript icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>Lorem <sup>XuT </sup>dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->markTestIncomplete('Need a way to select text that has is superscript.');

        $this->doubleClick($xut);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sup_active.png'), 'Superscript icon in the top toolbar is not active');

    }//end testRemovingFormatFromPartOfTheContent()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');

        $this->selectText('Lorem', 'XuT');
        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');

        $this->selectText('XuT', 'dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');

        $this->assertHTMLMatch('<p><sup>Lorem XuT dolor</sup></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
         $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');

        $this->selectText('Lorem');
        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');

        $this->selectText('dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');

        $this->assertHTMLMatch('<p><sup>Lorem</sup> <sup>XuT</sup> <sup>dolor</sup></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that subscripy can be removed.
     *
     * @return void
     */
    public function testRemoveFormating()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text    = 'WoW';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sup_active.png'), 'Superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong><sup>WoW</sup></strong></p>');

        $this->click($textLoc);
        $this->selectText($text);

         $this->clickTopToolbarButton($dir.'toolbarIcon_sup_active.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sup.png'), 'Superscript icon is still active in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testRemoveFormating()


    /**
     * Test that the superscript icon is active when you select a word that has superscript applied.
     *
     * @return void
     */
    public function testIconsIsActive()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text    = 'WoW';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sup_active.png'), 'Superscript icon in the top toolbar is not active');

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sup_active.png'), 'Superscript icon in the top toolbar is not active');

    }//end testIconsIsActive()


    /**
     * Test that you can undo superscript after you have applied it.
     *
     * @return void
     */
    public function testUndoSuperscript()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_sup.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sup_active.png'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <sup>XuT</sup> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testUndoSuperscript()

}//end class

?>
