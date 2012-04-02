<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_AnchorUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that creating anchor works.
     *
     * @return void
     */
    public function testCreateAnchor()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_anchor.png');
        $this->clickInlineToolbarButton($dir.'input_anchor.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span id="test">Lorem</span> XuT dolor</p><p id="test">sit amet <strong>WoW</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">lABs</span> is ORSM</p><p><em>The</em> QUICK brown foxxx</p><p><strong>jumps</strong> OVER the lazy dogggg</p>');

        $this->click($this->find('dolor'));
        sleep(1);
        $this->selectText('Lorem');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_anchor_active.png'), 'Anchor icon in Top Toolbar should be active.');
        $this->assertTrue(
            $this->inlineToolbarButtonExists($dir.'toolbarIcon_anchor_active.png') || $this->inlineToolbarButtonExists($dir.'toolbarIcon_anchor_subActive.png'),
            'Anchor icon in VITP should be active'
        );

    }//end testCreateAnchor()


    /**
     * Test that the anchor icon appears in the inline toolbar for the last word in a paragraph.
     *
     * @return void
     */
    public function testAnchorIconAppearsInTheInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('ORSM');
        $this->type('Key.RIGHT');
        $this->type('Key.ENTER');
        $this->type('This is a new line of ConTenT');

        $this->selectText('ConTenT');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_anchor.png'), 'Anchor icon should appear in the inline toolbar.');

    }//end testAnchorIconAppearsInTheInlineToolbar()


}//end class

?>
