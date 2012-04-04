<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_StrikethroughUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testStartOfParaStrikethrough()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');

        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_strike_active.png'), 'Strikethrough icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><del>Lorem</del> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testStartOfParaStrikethrough()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaStrikethrough()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_strike_active.png'), 'Strikethrough icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <del>XuT</del> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testMidOfParaStrikethrough()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaStrikethrough()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');

        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_strike_active.png'), 'Strikethrough icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT <del>dolor</del></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testEndOfParaStrikethrough()


    /**
     * Test that strikethrough is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemovingFormatFromPartOfTheContent()
    {
        $dir = dirname(__FILE__).'/Images/';

        $dolor = $this->find('dolor');
        $xut   = $this->find('XUT');

        $this->selectText('XuT', 'dolor');

        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_strike_active.png'), 'Strikethrough icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <del>XuT dolor</del></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->doubleClick($dolor);

        $this->clickTopToolbarButton($dir.'toolbarIcon_strike_active.png');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_strike.png'), 'Strikethrough icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>Lorem <del>XuT </del>dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->doubleClick($xut);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_strike_active.png'), 'Strikethrough icon in the top toolbar is not active');

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
        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');

        $this->selectText('Lorem', 'XuT');
        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');

        $this->selectText('XuT', 'dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');

        $this->assertHTMLMatch('<p><del>Lorem XuT dolor</del></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

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
         $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');

        $this->selectText('Lorem');
        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');

        $this->selectText('dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');

        $this->assertHTMLMatch('<p><del>Lorem</del> <del>XuT</del> <del>dolor</del></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that strikethrough can be removed.
     *
     * @return void
     */
    public function testRemoveFormating()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text    = 'WoW';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_strike_active.png'), 'Strikethrough icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong><del>WoW</del></strong></p>');

        $this->click($textLoc);
        $this->selectText($text);

         $this->clickTopToolbarButton($dir.'toolbarIcon_strike_active.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_strike.png'), 'Strikethrough icon is still active in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testRemoveFormating()


    /**
     * Test that the Strikethrough icon is active when you select a word that has strikethrough applied.
     *
     * @return void
     */
    public function testIconsIsActive()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text    = 'WoW';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_strike_active.png'), 'Strikethrough icon in the top toolbar is not active');

        $this->click($textLoc);
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_strike_active.png'), 'Strikethrough icon in the top toolbar is not active');

    }//end testIconsIsActive()


    /**
     * Test that you can undo strikethrough after you have applied it.
     *
     * @return void
     */
    public function testUndoStrikethrough()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_strike.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_strike_active.png'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <del>XuT</del> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_strike.png'), 'Strikethrough icon in the top toolbar should not be active');

    }//end testUndoStrikethrough()

}//end class

?>
