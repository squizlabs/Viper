<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_AnchorUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that creating anchor works.
     *
     * @return void
     */
    public function testCreateAnchorUsingTheInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span id="test">Lorem</span> XuT dolor</p><p id="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">lABs</span> is ORSM</p>');

        $this->click($this->find('dolor'));
        sleep(1);
        $this->selectText('Lorem');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon in the inline toolbar should be active');

        $this->selectText('ORSM');
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $updateChanges = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChanges);

        $this->assertHTMLMatch('<p><span id="test">Lorem</span> XuT dolor</p><p id="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">lABs</span> is <span id="test">ORSM</span></p>');

        $this->click($this->find('dolor'));
        sleep(1);
        $this->selectText('ORSM');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon in the inline toolbar should be active');

    }//end testCreateAnchorUsingTheInlineToolbar()


    /**
     * Test that creating anchor works.
     *
     * @return void
     */
    public function testCreateAnchorUsingTheTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span id="test">Lorem</span> XuT dolor</p><p id="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">lABs</span> is ORSM</p>');

        $this->click($this->find('dolor'));
        sleep(1);
        $this->selectText('Lorem');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon in the inline toolbar should be active');

        $this->selectText('ORSM');
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $updateChanges = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChanges);

        $this->assertHTMLMatch('<p><span id="test">Lorem</span> XuT dolor</p><p id="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">lABs</span> is <span id="test">ORSM</span></p>');

        $this->click($this->find('dolor'));
        sleep(1);
        $this->selectText('ORSM');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon in the inline toolbar should be active');

    }//end testCreateAnchorUsingTheTopToolbar()


    /**
     * Test that the anchor icon appears in the inline toolbar for the last word in a paragraph.
     *
     * @return void
     */
    public function testAnchorIconAppearsInTheInlineToolbar()
    {
        $this->selectText('ORSM');
        $this->type('Key.RIGHT');
        $this->type('Key.ENTER');
        $this->type('This is a new line of CONTENT');

        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');

        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should appear in the inline toolbar.');

    }//end testAnchorIconAppearsInTheInlineToolbar()


    /**
     * Test selecting anchors.
     *
     * @return void
     */
    public function testSelectingAnchors()
    {
        $this->selectText('WoW');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should appear in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be available in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Active anchor icon should appear in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Active anchor icon should be available in the top toolbar');

        $this->click($this->find('XuT'));

        $this->selectText('lABs');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Active anchor icon should appear in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Active anchor icon should be available in the top toolbar');

    }//end testSelectingAnchors()


    /**
     * Test deleting anchors using the inline toolbar.
     *
     * @return void
     */
    public function testDeletingAnchorsUsingTheInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('WoW');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_icon.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">lABs</span> is ORSM</p>');

        $this->selectText('lABs');
        sleep(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_icon.png');
        $updateChanges = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChanges);

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz lABs is ORSM</p>');

    }//end testDeletingAnchorsUsingTheInlineToolbar()


    /**
     * Test deleting anchors using the top toolbar.
     *
     * @return void
     */
    public function testDeletingAnchorsUsingTheTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('WoW');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clickTopToolbarButton($dir.'toolbarIcon_delete_icon.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">lABs</span> is ORSM</p>');

        $this->selectText('lABs');
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clickTopToolbarButton($dir.'toolbarIcon_delete_icon.png');
        $updateChanges = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChanges);

        $this->assertHTMLMatch('<p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz lABs is ORSM</p>');

    }//end testDeletingAnchorsUsingTheInlineToolbar()


}//end class

?>
