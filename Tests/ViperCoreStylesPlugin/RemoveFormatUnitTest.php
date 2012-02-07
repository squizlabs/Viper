<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_RemoveFormatUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that bold, italics, strike through, sub script, super script and classes are removed when you click the Remove Format icon.
     *
     * @return void
     */
    public function testRemoveFormatIcon()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('WoW');
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton($dir.'toolbarIcon_removeFormat.png');

        $this->assertHTMLMatch('<div><h1>First Heading</h1><p>Lorem XuT dolor sit amet WoW</p><h2>Second Heading</h2><p>This is SOME information for <a href="http://www.google.com" title="Google">testing</a></p><ul>    <li>Test removing bullet points</li>    <li>purus neque luctus</li>    <li>vel molestie arcu</li></ul><div>&nbsp;</div><hr><p>This is a sub script<p>This is a super script</p></p></div>');

    }//end testRemoveFormatIcon()


}//end class

?>
