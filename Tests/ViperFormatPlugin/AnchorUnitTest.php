<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_AnchorUnitTest extends AbstractViperUnitTest
{


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
