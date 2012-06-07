<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCharMapPlugin_CharacterMapPluginUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that the character map opens and the correct symbols are shown for each menu.
     *
     * @return void
     */
    public function testInsertingCharacter()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->assertTrue($this->topToolbarButtonExists('charMap'), 'Character map icon should be enabled.');

        $this->clickTopToolbarButton('charMap');

        // Insert char.
        $char = $this->findImage('ViperCharMapPlugin-symbolChar-1', 'table.VCMP-table.Viper-visible td', 10);
        $this->click($char);

        // Insert char.
        $char = $this->findImage('ViperCharMapPlugin-symbolChar-2', 'table.VCMP-table.Viper-visible td', 11);
        $this->click($char);

        // Change to Latin char list.
        $this->click($this->findImage('ViperCharMapPlugin-latinList', 'ul.VCMP-list li', 1));

        // Insert char.
        $char = $this->findImage('ViperCharMapPlugin-symbolChar-3', 'table.VCMP-table.Viper-visible td', 5);
        $this->click($char);

        // Change to Mathematics char list.
        $this->click($this->findImage('ViperCharMapPlugin-mathList', 'ul.VCMP-list li', 2));

        // Insert char.
        $char = $this->findImage('ViperCharMapPlugin-symbolChar-4', 'table.VCMP-table.Viper-visible td', 3);
        $this->click($char);

        // Change to Mathematics char list.
        $this->click($this->findImage('ViperCharMapPlugin-currList', 'ul.VCMP-list li', 3));

        // Insert char.
        $char = $this->findImage('ViperCharMapPlugin-symbolChar-5', 'table.VCMP-table.Viper-visible td', 10);
        $this->click($char);

        $this->assertHTMLMatch('<p>LOREM %1%&para;&sect;&acirc;&times;&#3647; dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testOpeningCharacterMap()


    /**
     * Test inserting a symbol from the character map and clicking undo.
     *
     * @return void
     */
    public function testInsertingASymbolAndClickingUndo()
    {
        $this->click($this->findKeyword(1));
        $this->clickTopToolbarButton('charMap');

        // Insert char.
        $char = $this->findImage('ViperCharMapPlugin-symbolChar-1', 'table.VCMP-table.Viper-visible td', 10);
        $this->click($char);

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>LOREM %1% dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testInsertingASymbolAndClickingUndo()


}//end class

?>
