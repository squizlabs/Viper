<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_ClassUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that you can add the class attribute to a word.
     *
     * @return void
     */
    public function testAddingClassAttribute()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'Lorem';

        $this->selectText($text);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->clickInlineToolbarButton($dir.'input_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span class="test">Lorem</span> xtn dolor</p><p class="myclass">sit amet <strong>WoW</strong></p><p>Squiz <span class="myclass">LABS</span> is orsm</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

    }//end testAddingClassAttribute()


    /**
     * Test that you can remove a class from a paragraph.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromAParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'WoW';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <span class="myclass">LABS</span> is orsm</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the inline toolbar.');

    }//end testRemovingClassAttributeFromAParagraph()


    /**
     * Test that you can remove a class from a word.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromAWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'LABS';

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Squiz LABS is orsm</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the inline toolbar.');

    }//end testRemovingClassAttributeFromAParagraph()


    /**
     * Test the auto save.
     *
     * @return void
     */
    public function testAutosaveForClassField()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'WoW';

        $this->selectText($text);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
         $this->clickInlineToolbarButton($dir.'input_class.png');
        $this->type('t');
        sleep(3);
        $this->type('e');
        sleep(3);
        $this->type('s');
        sleep(3);
        $this->type('t');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p class="test">sit amet <strong class="test">WoW</strong></p><p>Squiz <span class="myclass">LABS</span> is orsm</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon is not active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon is not active in the inline toolbar.');

    }//end testAutosaveForClassField()


}//end class

?>
