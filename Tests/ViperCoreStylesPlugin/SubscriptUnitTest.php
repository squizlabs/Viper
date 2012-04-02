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
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');

        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sub_active.png'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><sub>Lorem</sub> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testStartOfParaSubscript()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaSubscript()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sub_active.png'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <sub>XuT</sub> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testMidOfParaSubscript()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaSubscript()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');

        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sub_active.png'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT <sub>dolor</sub></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testEndOfParaSubscript()


    /**
     * Test that strikethrough is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemovingFormatFromPartOfTheContent()
    {
        $dir = dirname(__FILE__).'/Images/';

        $dolor = $this->find('dolor');
        $xut   = $this->find('xut');

        $this->selectText('XuT', 'dolor');

        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sub_active.png'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <sub>XuT dolor</sub></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->doubleClick($dolor);

        $this->clickTopToolbarButton($dir.'toolbarIcon_sub_acitve.png');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_sub.png'), 'Subscript icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>Lorem <sub>XuT </sub>dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        // Stop here as we need a way to select text that has a strikethrough.
        $this->markTestIncomplete('Need a way to select text that has is sub script.');

        $this->doubleClick($xut);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sub_active.png'), 'Subscript icon in the top toolbar is not active');

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
        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');

        $this->selectText('Lorem', 'XuT');
        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');

        $this->selectText('XuT', 'dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');

        $this->assertHTMLMatch('<p><sub>Lorem XuT dolor</sub></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

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
         $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');

        $this->selectText('Lorem');
        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');

        $this->selectText('dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');

        $this->assertHTMLMatch('<p><sub>Lorem</sub> <sub>XuT</sub> <sub>dolor</sub></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

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

        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sub_active.png'), 'Subscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong><sub>WoW</sub></strong></p>');

        $this->click($textLoc);
        $this->selectText($text);

         $this->clickTopToolbarButton($dir.'toolbarIcon_sub_active.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sub.png'), 'Subscript icon is still active in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testRemoveFormating()


    /**
     * Test that the subscript icon is active when you select a word that has strikethrough applied.
     *
     * @return void
     */
    public function testIconsIsActive()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text    = 'WoW';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sub_active.png'), 'Subscript icon in the top toolbar is not active');

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sub_active.png'), 'Subscript icon in the top toolbar is not active');

    }//end testIconsIsActive()


    /**
     * Test that you can undo subscript after you have applied it.
     *
     * @return void
     */
    public function testUndoSubscript()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_sub.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_sub_active.png'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <sub>XuT</sub> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testUndoSubscript()



}//end class

?>
