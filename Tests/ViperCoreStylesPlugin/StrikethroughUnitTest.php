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
        $this->selectText('Lorem');

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><del>Lorem</del> XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testStartOfParaStrikethrough()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaStrikethrough()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <del>XuT</del> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testMidOfParaStrikethrough()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaStrikethrough()
    {
        $this->selectText('dolor');

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT <del>dolor</del></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testEndOfParaStrikethrough()


    /**
     * Test that strikethrough is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemovingFormatFromPartOfTheContent()
    {
        $dolor = $this->find('dolor');
        $xut   = $this->find('XUT');

        $this->selectText('XuT', 'dolor');

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <del>XuT dolor</del></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->doubleClick($dolor);

        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>Lorem <del>XuT </del>dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->doubleClick($xut);
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

    }//end testRemovingFormatFromPartOfTheContent()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectText('XuT');
        $this->clickTopToolbarButton('strikethrough');

        $this->selectText('Lorem', 'XuT');
        $this->clickTopToolbarButton('strikethrough');

        $this->selectText('dolor');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->clickTopToolbarButton('strikethrough');

        $this->assertHTMLMatch('<p><del>Lorem XuT dolor</del></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectText('XuT');
         $this->clickTopToolbarButton('strikethrough');

        $this->selectText('Lorem');
        $this->clickTopToolbarButton('strikethrough');

        $this->selectText('dolor');
        $this->clickTopToolbarButton('strikethrough');

        $this->assertHTMLMatch('<p><del>Lorem</del> <del>XuT</del> <del>dolor</del></p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that strikethrough can be removed.
     *
     * @return void
     */
    public function testRemoveFormating()
    {
        $text    = 'WoW';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong><del>WoW</del></strong></p>');

        $this->click($textLoc);
        $this->selectText($text);

         $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon is still active in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

    }//end testRemoveFormating()


    /**
     * Test that the Strikethrough icon is active when you select a word that has strikethrough applied.
     *
     * @return void
     */
    public function testIconsIsActive()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

        $this->selectText('Lorem');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

    }//end testIconsIsActive()


    /**
     * Test that you can undo strikethrough after you have applied it.
     *
     * @return void
     */
    public function testUndoStrikethrough()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>Lorem <del>XuT</del> dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p>');

        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar should not be active');

    }//end testUndoStrikethrough()

}//end class

?>
