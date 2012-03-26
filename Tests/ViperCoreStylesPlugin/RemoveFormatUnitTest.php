<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_RemoveFormatUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that bold, italics, strike through, sub script, super script, alignment and classes are removed when you click the Remove Format icon.
     *
     * @return void
     */
    public function testRemoveFormatIcon()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('WoW');
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton($dir.'toolbarIcon_removeFormat.png');

        $this->assertHTMLMatch('<div><h1>First Heading</h1><p>Lorem XuT dolor sit amet WoW</p><h2>Second Heading</h2><p>This is SOME information for <a href="http://www.google.com" title="Google">testing</a></p><ul><li>Test removing bullet points</li><li>purus oNo luctus</li><li>vel molestie arcu</li></ul><div>&nbsp;</div><hr><p>This is a sub script. This is a super script</p><table border="1" cellpadding="2" cellspacing="3"><caption>Table 1.2: The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WoW sapien vel aliquet</td><td>            <ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td><h3>Squiz Labs</h3></td><td id="x" colspan="2">purus neque luctus <a href="http://www.google.com">ligula</a>, vel molestie arcu</td></tr><tr><td>nec porta ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table></div>');

    }//end testRemoveFormatIcon()


    /**
     * Test that alignment is removed for a list.
     *
     * @return void
     */
    public function testRemoveAlignmentForAList()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('oNo');
        $this->selectInlineToolbarLineageItem(1);

        $this->clickTopToolbarButton($dir.'toolbarIcon_removeFormat.png');

        $this->assertHTMLMatch('<div><h1>First Heading</h1><p style="text-align: center;">Lorem XuT dolor sit <em>amet</em> <strong>WoW</strong></p><h2>Second Heading</h2><p  style="text-align: right;">This is <del>SOME</del> <span class="myclass">information</span> for <a href="http://www.google.com" title="Google">testing</a></p><ul><li>Test removing bullet points</li><li>purus <u>oNo</u> luctus</li><li>vel molestie arcu</li></ul><div>&nbsp;</div><hr><p>This is a <sub>sub</sub> script. This is a <sup>super</sup> script</p><table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td class="">UnaU <sub>TiuT</sub> XabcX Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td>            <ul><li><span class="myclass">vel</span> molestie arcu</li><li>purus <del>neque</del> luctus</li><li>vel <sup>molestie</sup> arcu</li></ul>        </td></tr><tr><td><h3>Squiz Labs</h3></td><td id="x" colspan="2">purus <span class="">neque</span> luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table></div>');

    }//end testRemoveAlignmentForAList()

}//end class


?>



