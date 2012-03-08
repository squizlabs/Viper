<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_ClassUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that you can add the class attribute to a word using the inline toolbar.
     *
     * @return void
     */
    public function testAddingClassAttributeToAWordUsingTheInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';

        $this->selectText($text);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem <span class="test">XuT</span> dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $text = 'dolor';
        $this->selectText($text);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('class');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_updateChanges.png');
        $this->assertHTMLMatch('<p>Lorem <span class="test">XuT</span> <span class="class">dolor</span></p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassAttributeToAWordUsingTheInlineToolbar()


    /**
     * Test that the class icon appears in the inline toolbar for the last word in a paragraph.
     *
     * @return void
     */
    public function testClassIconAppearsInTheInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('ORSM');
        $this->type('Key.RIGHT');
        $this->type('Key.ENTER');
        $this->type('This is a new line of ConTenT');

        $this->selectText('ConTenT');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon should appear in the inline toolbar.');

    }//end testClassIconAppearsInTheInlineToolbar()


    /**
     * Test that you can add the class attribute to a word using the top toolbar.
     *
     * @return void
     */
    public function testAddingClassAttributeToAWordUsingTheTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem <span class="test">XuT</span> dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $text = 'dolor';
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('class');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');
        $this->assertHTMLMatch('<p>Lorem <span class="test">XuT</span> <span class="class">dolor</span></p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');


    }//end testAddingClassAttributeToAWordUsingTheTopToolbar()


    /**
     * Test that the update changes button is disabled when you initially click on the class icon.
     *
     * @return void
     */
    public function testUpdateChangesButtonIsDisabledForClassIcon()
    {
        // Stop here as the unit testing framework doesn't recognise the disabled update changes button.
        $this->markTestIncomplete('Need a way for the unit testing framework to recongnise the disabled update changes button');

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_updateChanges_disabled.png'), 'Update Changes button should be disabled.');

        $this->selectText('dolor');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_updateChanges_disabled.png'), 'Update Changes button should be disabled.');

    }//end testUpdateChangesButtonIsDisabledForClassIcon()


    /**
     * Test that you can remove a class from a word using the inline toolbar.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromAWordUsingTheInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'lABs';

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz lABs is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the inline toolbar.');

        // Reapply the class so that we can delete it with the Update Changes button
        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="test">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz lABs is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

    }//end testRemovingClassAttributeFromAWordUsingTheInlineToolbar()


    /**
     * Test that you can remove a class from a word using the top toolbar.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromAWordUsingTheTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'lABs';

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz lABs is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the inline toolbar.');

        // Reapply the class so that we can delete it with the Update Changes button
        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="test">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz lABs is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

    }//end testRemovingClassAttributeFromAWordUsingTheTopToolbar()


    /**
     * Test that you can update the class applied to a word using the inline toolbar.
     *
     * @return void
     */
    public function testUpdatingAClassUsingTheInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'lABs';

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclassabc">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->type('def');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclassabcdef">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

    }//end testUpdatingAClassUsingTheInlineToolbar()


    /**
     * Test that you can update the class applied to a word using the top toolbar.
     *
     * @return void
     */
    public function testUpdatingAClassUsingTheTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'lABs';

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclassabc">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->type('def');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclassabcdef">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

    }//end testUpdatingAClassUsingTheTopToolbar()


    /**
     * Test that you can add the class attribute to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testAddingClassAttributeToAParagraphUsingTheInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'Lorem';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p class="test">Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $this->click($this->find($text));

        // Need to add the sleep so that the test passes in Firefox otherwise it doesn't click AbC
        sleep(1);

        $text = 'AbC';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_updateChanges_disabled.png'), 'Update Changes button should be disabled.');

        $this->type('class');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_updateChanges.png');
        $this->assertHTMLMatch('<p class="test">Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p class="class">Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassAttributeToAParagraphUsingTheInlineToolbar()


    /**
     * Test that you can add the class attribute to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testAddingClassAttributeToAParagraphUsingTheTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'Lorem';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p class="test">Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $this->click($this->find($text));
        $text = 'AbC';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_updateChanges_disabled.png'), 'Update Changes button should be disabled.');

        $this->type('class');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');
        $this->assertHTMLMatch('<p class="test">Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p class="class">Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassAttributeToAParagraphUsingTheTopToolbar()


    /**
     * Test adding a class to a paragraph that was a class applied to a word.
     *
     * @return void
     */
    public function testAddingClassToParagraphWithClassAppliedToWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'ORSM';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p class="test">Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $this->click($this->find($text));
        $text = 'lABs';
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

    }//end testAddingClassAttributeToAParagraphUsingTheInlineToolbar()


    /**
     * Test that you can remove a class from a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromParagraphUsingInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text    = 'WoW';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the inline toolbar.');

        //Reapply the class so that we can delete again using the Update Changes button
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

    }//end testRemovingClassAttributeFromParagraphUsingInlineToolbar()


    /**
     * Test that you can remove a class from a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromParagraphUsingTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'WoW';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon is still active in the inline toolbar.');

        //Reapply the class so that we can delete again using the Update Changes button
        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_delete_class.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

    }//end testRemovingClassAttributeFromParagraphUsingTopToolbar()


    /**
     * Test that you can edit the class applied to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testEditingTheClassForAParagraphUsingInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'WoW';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="testabc">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->type('def');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="testabcdef">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

    }//end testEditingTheClassUsingInlineToolbar()


    /**
     * Test that you can edit the class applied to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testEditingTheClassUsingTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'WoW';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_class_active.png');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="testabc">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('def');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="testabcdef">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

    }//end testEditingTheClassUsingTopToolbar()


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
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p class="test"><strong>jumps</strong> OVER the lazy dogggg</p>');

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
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p class="test"><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassToAParagraphWithItalicFirstWord()


    /**
     * Test that you can apply a class to bold word.
     *
     * @return void
     */
    public function testAddingClassToABoldWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'jumps';

        $this->selectText($text);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong class="test">jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassToAParagraphWithBoldFirstWord()


    /**
     * Test that you can apply a class to italac word.
     *
     * @return void
     */
    public function testAddingClassToAItalicWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'OVER';

        $this->selectText($text);
        $this->keyDown('Key.CMD + i');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> <em class="test">OVER</em> the lazy dogggg</p>');

    }//end testAddingClassToAItalicWord()


    /**
     * Test applying a class to one word out of two words that are bold.
     *
     * @return void
     */
    public function testAddingClassToAOneBoldWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('jumps', 'OVER');
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps OVER </strong>the lazy dogggg</p>');

        $this->selectText('OVER');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps <span class="test">OVER</span> </strong>the lazy dogggg</p>');

    }//end testAddingClassToAOneBoldWord()


    /**
     * Test applying a class to one word out of two words that are italics.
     *
     * @return void
     */
    public function testAddingClassToAOneItalicWord()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('QUICK', 'brown');
        $this->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> <em>QUICK brown</em> foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText('QUICK');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> <em><span class="test">QUICK</span> brown</em> foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassToAOneItalicWord()


    /**
     * Test that selection is maintained when opening and closing the class icon for a word.
     *
     * @return void
     */
    public function testSelectionIsMaintainedForWordWhenOpeningAndClosingClassFields()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->assertEquals('XuT', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_class_subActive.png');
        $this->assertEquals('XuT', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->assertEquals('XuT', $this->getSelectedText(), 'Selected text is not highlighted.');

    }//end testSelectionIsMaintainedForWordWhenOpeningAndClosingClassFields()


    /**
     * Test that selection is maintained when opening and closing the class icon for a paragraph.
     *
     * @return void
     */
    public function testSelectionIsMaintainedForParaWhenOpeningAndClosingClassFields()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->assertEquals('Lorem XuT dolor', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_class_subActive.png');
        $this->assertEquals('Lorem XuT dolor\n', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton($dir.'toolbarIcon_class.png');
        $this->assertEquals('Lorem XuT dolor', $this->getSelectedText(), 'Selected text is not highlighted.');

    }//end testSelectionIsMaintainedForParaWhenOpeningAndClosingClassFields()


}//end class

?>
