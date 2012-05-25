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
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('removeFormat');
        sleep(1);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<div><h1>First Heading</h1><p>Lorem XuT dolor sit amet %1%</p><h2>Second Heading</h2><p>This is SOME information for <a href="http://www.google.com" title="Google">testing</a></p><ul><li>Test removing bullet points</li><li>purus oNo luctus</li><li>vel molestie arcu</li></ul><div>&nbsp;</div><hr /><p>This is a sub script. This is a super script</p><table border="1" cellpadding="2" cellspacing="3"><caption>Table 1.2: The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WoW sapien vel aliquet</td><td>            <ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td><h3>Squiz Labs</h3></td><td colspan="2">purus neque luctus <a href="http://www.google.com">ligula</a>, vel molestie arcu</td></tr><tr><td>nec porta ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table></div>');


    }//end testRemoveFormatIcon()


    /**
     * Test that alignment is removed for a list.
     *
     * @return void
     */
    public function testRemoveAlignmentForAList()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('removeFormat');

        $this->assertHTMLMatch('<p>This is a list</p><ul><li>Test removing bullet points</li><li>purus %1% luctus</li><li>vel molestie arcu</li></ul>');

    }//end testRemoveAlignmentForAList()


    /**
     * Test that selection is maintained when you click the remove format icon.
     *
     * @return void
     */
    public function testSelectionMaintainedWhenClickingRemoveFormat()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('removeFormat');

        $this->assertHTMLMatch('<p>Lorem %1% dolor sit amet WoW</p>');
        $this->assertEquals($this->replaceKeywords('Lorem %1% dolor sit amet WoW'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectionMaintainedWhenClickingRemoveFormat()


    /**
     * Test remove format for a paragraph.
     *
     * @return void
     */
    public function testRemoveFormatForAParagraph()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('removeFormat');

        $this->assertHTMLMatch('<p>%1% government agencies must update all government websites (as specified within scope under the Website Accessibility National Transition Strategy (NTS)) to WCAG 2.0 conformance. Agencies should use the principle of progressive enhancement when building and managing websites, and test for conformance across multiple browsers and operating system configurations.</p>');

    }//end testRemoveFormatForAParagraph()


}//end class


?>



