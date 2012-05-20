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
        $text = 'XuT';

        $this->selectText($text);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem <span class="test">XuT</span> dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $text = 'dolor';
        $this->selectText($text);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Lorem <span class="test">XuT</span> <span class="class">dolor</span></p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassAttributeToAWordUsingTheInlineToolbar()


    /**
     * Test that the class icon appears in the inline toolbar for the last word in a paragraph.
     *
     * @return void
     */
    public function testClassIconAppearsInTheInlineToolbar()
    {
        $this->selectText('ORSM');
        $this->type('Key.RIGHT');
        $this->type('Key.ENTER');
        $this->type('This is a new line of ConTenT');

        $this->selectText('ConTenT');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should appear in the inline toolbar.');

    }//end testClassIconAppearsInTheInlineToolbar()


    /**
     * Test that you can add the class attribute to a word using the top toolbar.
     *
     * @return void
     */
    public function testAddingClassAttributeToAWordUsingTheTopToolbar()
    {
        $text = 'XuT';

        $this->selectText($text);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem <span class="test">XuT</span> dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $text = 'dolor';
        $this->selectText($text);
        $this->clickTopToolbarButton('cssClass');
        $this->type('class');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Lorem <span class="test">XuT</span> <span class="class">dolor</span></p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');


    }//end testAddingClassAttributeToAWordUsingTheTopToolbar()


    /**
     * Test that the update changes button is disabled when you initially click on the class icon.
     *
     * @return void
     */
    public function testUpdateChangesButtonIsDisabledForClassIcon()
    {
        $this->selectText('XuT');
        $this->clickTopToolbarButton('cssClass');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');

        $this->selectText('dolor');
        $this->clickInlineToolbarButton('cssClass');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');

    }//end testUpdateChangesButtonIsDisabledForClassIcon()


    /**
     * Test that you can remove a class from a word using the inline toolbar.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromAWordUsingTheInlineToolbar()
    {
        $text = 'lABs';

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz lABs is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon is still active in the inline toolbar.');

        // Reapply the class so that we can delete it with the Update Changes button
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="test">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz lABs is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testRemovingClassAttributeFromAWordUsingTheInlineToolbar()


    /**
     * Test that you can remove a class from a word using the top toolbar.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromAWordUsingTheTopToolbar()
    {
        $text = 'lABs';

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz lABs is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon is still active in the inline toolbar.');

        // Reapply the class so that we can delete it with the Update Changes button
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="test">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz lABs is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testRemovingClassAttributeFromAWordUsingTheTopToolbar()


    /**
     * Test that you can update the class applied to a word using the inline toolbar.
     *
     * @return void
     */
    public function testUpdatingAClassUsingTheInlineToolbar()
    {
        $text = 'lABs';

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclassabc">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->type('def');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclassabcdef">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testUpdatingAClassUsingTheInlineToolbar()


    /**
     * Test that you can update the class applied to a word using the top toolbar.
     *
     * @return void
     */
    public function testUpdatingAClassUsingTheTopToolbar()
    {
        $text = 'lABs';

        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickTopToolbarButton('cssClass', 'active');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclassabc">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclassabcdef">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testUpdatingAClassUsingTheTopToolbar()


    /**
     * Test that you can add the class attribute to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testAddingClassAttributeToAParagraphUsingTheInlineToolbar()
    {
        $text = 'Lorem';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p class="test">Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->click($this->find($text));

        // Need to add the sleep so that the test passes in Firefox otherwise it doesn't click AbC
        sleep(1);

        $text = 'AbC';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p class="test">Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p class="class">Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassAttributeToAParagraphUsingTheInlineToolbar()


    /**
     * Test that you can add the class attribute to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testAddingClassAttributeToAParagraphUsingTheTopToolbar()
    {
        $text = 'Lorem';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p class="test">Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->click($this->find($text));

        // Need to add the sleep so that the test passes in Firefox otherwise it doesn't click AbC
        sleep(1);

        $text = 'AbC';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('class');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p class="test">Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p class="class">Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassAttributeToAParagraphUsingTheTopToolbar()


    /**
     * Test adding a class to a paragraph that was a class applied to a word.
     *
     * @return void
     */
    public function testAddingClassToParagraphWithClassAppliedToWord()
    {
        $text = 'ORSM';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p class="test">Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->click($this->find($text));
        $text = 'lABs';
        $this->selectText($text);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

    }//end testAddingClassAttributeToAParagraphUsingTheInlineToolbar()


    /**
     * Test that you can remove a class from a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromParagraphUsingInlineToolbar()
    {
        $text    = 'WoW';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon is still active in the inline toolbar.');

        //Reapply the class so that we can delete again using the Update Changes button
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testRemovingClassAttributeFromParagraphUsingInlineToolbar()


    /**
     * Test that you can remove a class from a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testRemovingClassAttributeFromParagraphUsingTopToolbar()
    {
        $text = 'WoW';
        $textLoc = $this->find($text);

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon is still active in the Top Toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon is still active in the inline toolbar.');

        //Reapply the class so that we can delete again using the Update Changes button
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testRemovingClassAttributeFromParagraphUsingTopToolbar()


    /**
     * Test that you can edit the class applied to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testEditingTheClassForAParagraphUsingInlineToolbar()
    {
        $text = 'WoW';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="testabc">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->type('def');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="testabcdef">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testEditingTheClassUsingInlineToolbar()


    /**
     * Test that you can edit the class applied to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testEditingTheClassUsingTopToolbar()
    {
        $text = 'WoW';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->clickTopToolbarButton('cssClass', 'active');
        $this->type('abc');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="testabc">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="testabcdef">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testEditingTheClassUsingTopToolbar()


    /**
     * Test that you can apply a class to a pargraph using the inline toolbar where the first word is bold.
     *
     * @return void
     */
    public function testAddingClassToAParagraphUsingInlineToolbarWithBoldFirstWord()
    {
        $text = 'OVER';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p class="test"><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassToAParagraphUsingInlineToolbarWithBoldFirstWord()


    /**
     * Test that you can apply a class to a pargraph using the top toolbar where the first word is bold.
     *
     * @return void
     */
    public function testAddingClassToAParagraphUsingTopToolbarWithBoldFirstWord()
    {
        $text = 'OVER';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p class="test"><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassToAParagraphUsingTopToolbarWithBoldFirstWord()


    /**
     * Test that you can apply a class to a pargraph using the inline toolbar where the first word is italic.
     *
     * @return void
     */
    public function testAddingClassToAParagraphUsingInlineToolbarWithItalicFirstWord()
    {
        $text = 'QUICK';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p class="test"><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassToAParagraphUsingInlineToolbarWithItalicFirstWord()


    /**
     * Test that you can apply a class to a pargraph using the top toolbar where the first word is italic.
     *
     * @return void
     */
    public function testAddingClassToAParagraphUsingTopToolbarWithItalicFirstWord()
    {
        $text = 'QUICK';

        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p class="test"><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassToAParagraphUsingTopToolbarWithItalicFirstWord()


    /**
     * Test that you can apply a class to bold word.
     *
     * @return void
     */
    public function testAddingClassToABoldWord()
    {
        $text = 'Jumps';

        $this->selectText($text);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong class="test">Jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassToAParagraphWithBoldFirstWord()


    /**
     * Test that you can apply a class to italac word.
     *
     * @return void
     */
    public function testAddingClassToAItalicWord()
    {
        $text = 'OVER';

        $this->selectText($text);
        $this->keyDown('Key.CMD + i');

        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> <em class="test">OVER</em> the lazy dogggg</p>');

    }//end testAddingClassToAItalicWord()


    /**
     * Test applying a class to one word out of two words that are bold.
     *
     * @return void
     */
    public function testAddingClassToAOneBoldWord()
    {
        $this->selectText('Jumps', 'OVER');
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps OVER </strong>the lazy dogggg</p>');

        $this->selectText('OVER');
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps <span class="test">OVER</span> </strong>the lazy dogggg</p>');

    }//end testAddingClassToAOneBoldWord()


    /**
     * Test applying a class to one word out of two words that are italics.
     *
     * @return void
     */
    public function testAddingClassToAOneItalicWord()
    {
        $this->selectText('QUICK', 'brown');
        $this->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> <em>QUICK brown</em> foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->selectText('QUICK');
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> <em><span class="test">QUICK</span> brown</em> foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

    }//end testAddingClassToAOneItalicWord()


    /**
     * Test that selection is maintained when opening and closing the class icon for a word.
     *
     * @return void
     */
    public function testSelectionIsMaintainedForWordWhenOpeningAndClosingClassFields()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals('XuT', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton('cssClass', 'selected');
        $this->assertEquals('XuT', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals('XuT', $this->getSelectedText(), 'Selected text is not highlighted.');

    }//end testSelectionIsMaintainedForWordWhenOpeningAndClosingClassFields()


    /**
     * Test that selection is maintained when opening and closing the class icon for a paragraph.
     *
     * @return void
     */
    public function testSelectionIsMaintainedForParaWhenOpeningAndClosingClassFields()
    {
        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals('Lorem XuT dolor', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton('cssClass', 'selected');
        $this->assertEquals('Lorem XuT dolor', $this->getSelectedText(), 'Selected text is not highlighted.');

        $this->clickTopToolbarButton('cssClass');
        $this->assertEquals('Lorem XuT dolor', $this->getSelectedText(), 'Selected text is not highlighted.');

    }//end testSelectionIsMaintainedForParaWhenOpeningAndClosingClassFields()


    /**
     * Test that class info is not added to the source code when you remove italics formatting.
     *
     * @return void
     */
    public function testApplyingBoldAndItalicsClickingClassRemovingBold()
    {
        $this->selectText('XuT');

        $this->clickInlineToolbarButton('bold');
        $this->clickInlineToolbarButton('italic');
        $this->clickInlineToolbarButton('cssClass');
        $this->clickInlineToolbarButton('italic', 'active');

        $viperBookmarkElements = $this->execJS('dfx.getClass("viperBookmark").length');
        $this->assertEquals(0, $viperBookmarkElements, 'There should be no viper bookmark elements');

        $this->assertHTMLMatch('<p>Lorem <strong>XuT</strong> dolor</p><p class="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span class="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>Jumps</strong> OVER the lazy dogggg</p>');

        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italics icon in VITP should not be active.');

    }//end testApplyingBoldAndItalicsClickingClassRemovingBold()


}//end class

?>
