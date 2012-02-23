<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_ClassUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that you can add the class attribute to a word.
     *
     * @return void
     */
    public function testAddingClassAttributeToAWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'Lorem';

        $this->selectText($text);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->clickInlineToolbarButton($dir.'input_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span class="test">Lorem</span> xtn dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Squiz <span class="myclass">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

    }//end testAddingClassAttributeToAWord()


    /**
     * Test that you can add the class attribute to a paragraph.
     *
     * @return void
     */
    public function testAddingClassAttributeToAParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'Lorem';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->clickInlineToolbarButton($dir.'input_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p class="test">Lorem xtn dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Squiz <span class="myclass">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

    }//end testAddingClassAttributeToAParagraph()


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

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet <strong>WoW</strong></p><p>Squiz <span class="myclass">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

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

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Squiz LABS is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the inline toolbar.');

    }//end testRemovingClassAttributeFromAParagraph()


    /**
     * Test the auto save for a word.
     *
     * @return void
     */
    public function testAutoSaveForClassFieldForAWord()
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
        sleep(3);
        $this->assertEquals('WoW', $this->getSelectedText(), 'Bold text is not selected.');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p class="test">sit amet <strong class="test">WoW</strong></p><p>Squiz <span class="myclass">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon is not active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon is not active in the inline toolbar.');

    }//end testAutosaveForClassField()


    /**
     * Test the auto save for a paragraph.
     *
     * @return void
     */
    public function testAutoSaveForClassFieldForAParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'Lorem';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
         $this->clickInlineToolbarButton($dir.'input_class.png');
        $this->type('t');
        sleep(3);
        $this->type('e');
        sleep(3);
        $this->type('s');
        sleep(3);
        $this->type('t');
        sleep(3);
        $this->assertEquals('Lorem xtn dolor', $this->getSelectedText(), 'Paragraph is not selected');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p class="test">Lorem xtn dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Squiz <span class="myclass">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

        //$this->click($this->find($text));
        //$this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon is not active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon is not active in the inline toolbar.');

    }//end testAutosaveForClassField()


    /**
     * Test that you can apply a class to a pargraph where the first word is bold.
     *
     * @return void
     */
    public function testAddingClassToAParagraphWithBoldFirstWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'OVER';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->clickInlineToolbarButton($dir.'input_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Squiz <span class="myclass">LABS</span> is orsm</p><p><em>The</em> QUICK brown fox</p><p class="test"><strong>jumps</strong> OVER the lazy dog</p>');

    }//end testAddingClassToAParagraphWithBoldFirstWord()


    /**
     * Test that you can apply a class to a pargraph where the first word is italic.
     *
     * @return void
     */
    public function testAddingClassToAParagraphWithItalicFirstWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'QUICK';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->clickInlineToolbarButton($dir.'input_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Squiz <span class="myclass">LABS</span> is orsm</p><p strong="test"><em>The</em> QUICK brown fox</p><p><strong>jumps</strong> OVER the lazy dog</p>');

    }//end testAddingClassToAParagraphWithItalicFirstWord()


}//end class

?>
