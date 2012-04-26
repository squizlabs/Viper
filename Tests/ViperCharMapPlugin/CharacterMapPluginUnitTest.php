<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCharMapPlugin_CharacterMapPluginUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that the character map opens and the correct symbols are shown for each menu.
     *
     * @return void
     */
    public function testOpeningCharacterMap()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';
        $this->click($this->find($text));
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_character_map.png'), 'Character map icon should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_character_map.png');

        // Check to make sure the symbol characters appear.
        $imageFound = true;
        try
        {
            $this->find($dir.'symbols_characters.png');
        }
        catch(Exception $e)
        {
            $imageFound = false;
        }

        $this->assertTrue($imageFound, 'The symbol characters were not found');

        $this->clickTopToolbarButton($dir.'toolbarIcon_character_map_subActive.png');

        sleep(1);
        try
        {
            $this->find($dir.'symbols_characters.png');
        }
        catch(Exception $e)
        {
            // Expecting the expection as we closed the sub toolbar
            $imageFound = false;
        }

        $this->assertFalse($imageFound, 'The symbol characters were found');

    }//end testOpeningCharacterMap()


    /**
     * Test inserting a symbol from the character map.
     *
     * @return void
     */
    public function testInsertingSymbol()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';
        $this->selectText('XuT');
        $this->keyDown('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_character_map.png');
        $symbol = $this->find($dir.'toolbarIcon_symbol.png');
        $this->click($symbol);

        $this->assertHTMLMatch('<p>LOREM XuT&reg; dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testInsertingSymbol()


    /**
     * Test inserting a latin symbol from the character map.
     *
     * @return void
     */
    public function testInsertingLatin()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';
        $this->selectText('XuT');
        $this->keyDown('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_character_map.png');
        $latinMenu = $this->find($dir.'latin_menu.png');
        $this->click($latinMenu);
        $latinSymbol = $this->find($dir.'toolbarIcon_latin.png');
        $this->click($latinSymbol);

        $this->assertHTMLMatch('<p>LOREM XuT&szlig; dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testInsertingLatin()


    /**
     * Test inserting a mathematics symbol from the character map.
     *
     * @return void
     */
    public function testInsertingMathematics()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';
        $this->selectText('XuT');
        $this->keyDown('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_character_map.png');
        $mathematicsMenu = $this->find($dir.'mathematics_menu.png');
        $this->click($mathematicsMenu);
        $mathematicsSymbol = $this->find($dir.'toolbarIcon_mathematics.png');
        $this->click($mathematicsSymbol);

        $this->assertHTMLMatch('<p>LOREM XuT&infin; dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testInsertingMathematics()


    /**
     * Test inserting a currency symbol from the character map.
     *
     * @return void
     */
    public function testInsertingCurrency()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';
        $this->selectText('XuT');
        $this->keyDown('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_character_map.png');
        $currencyMenu = $this->find($dir.'currency_menu.png');
        $this->click($currencyMenu);
        $currencySymbol = $this->find($dir.'toolbarIcon_currency.png');
        $this->click($currencySymbol);

        $this->assertHTMLMatch('<p>LOREM XuT&#65020; dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testInsertingCurrency()


    /**
     * Test inserting a symbol from the character map and clicking undo.
     *
     * @return void
     */
    public function testInsertingASymbolAndClickingUndo()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';
        $this->selectText('XuT');
        $this->keyDown('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_character_map.png');
        $latinMenu = $this->find($dir.'latin_menu.png');
        $this->click($latinMenu);
        $latinSymbol = $this->find($dir.'toolbarIcon_latin.png');
        $this->click($latinSymbol);

        $this->assertHTMLMatch('<p>LOREM XuT&szlig; dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');
        $this->assertHTMLMatch('<p>LOREM XuT dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testInsertingASymbolAndClickingUndo()


}//end class

?>
