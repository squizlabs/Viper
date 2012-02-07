<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_RemoveFormatUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that bold is emoved when you click Remove Format.
     *
     * @return void
     */
    public function testRemovingBoldFormatting()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('WoW');

        $this->clickTopToolbarButton($dir.'toolbarIcon_removeFormat.png');

        $this->assertHTMLMatch('<h1>First Heading</h1><p>Lorem XuT dolor</p><p>sit <em>amet</em> WoW</p><h2>Second Heading</h2><p>This is some <del>more</del> information for testing</p><ul>    <li>Test REMOVING bullet points</li>    <li>purus neque luctus</li>    <li>vel molestie arcu</li></ul><p>This is a <sub>sub</sub> script</p><p>This is a <sup>super</sup> script</p>');


    }//end testRemovingBoldFormatting()


    /**
     * Test that italics is removed when you click Remove Format.
     *
     * @return void
     */
    public function testRemovingItalicFormatting()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('amet');

        $this->clickTopToolbarButton($dir.'toolbarIcon_removeFormat.png');

        $this->assertHTMLMatch('<h1>First Heading</h1><p>Lorem XuT dolor</p><p>sit amet <strong>WoW</strong></p><h2>Second Heading</h2><p>This is some <del>more</del> information for testing</p><ul>    <li>Test REMOVING bullet points</li>    <li>purus neque luctus</li>    <li>vel molestie arcu</li></ul><p>This is a <sub>sub</sub> script</p><p>This is a <sup>super</sup> script</p>');

    }//end testRemovingItalicFormatting()


    /**
     * Test that strike through is removed when you click Remove Format.
     *
     * @return void
     */
    public function testRemovingStrikethroughFormatting()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('more');

        $this->clickTopToolbarButton($dir.'toolbarIcon_removeFormat.png');

        $this->assertHTMLMatch('<h1>First Heading</h1><p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p><h2>Second Heading</h2><p>This is some more information for testing</p><ul>    <li>Test REMOVING bullet points</li>    <li>purus neque luctus</li>    <li>vel molestie arcu</li></ul><p>This is a <sub>sub</sub> script</p><p>This is a <sup>super</sup> script</p>');

    }//end testRemovingStrikethroughFormatting()


    /**
     * Test that Subscript is removed when you click Remove Format.
     *
     * @return void
     */
    public function testRemovingSubscriptFormatting()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('sub');

        $this->clickTopToolbarButton($dir.'toolbarIcon_removeFormat.png');

        $this->assertHTMLMatch('<h1>First Heading</h1><p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p><h2>Second Heading</h2><p>This is some <del>more</del> information for testing</p><ul>    <li>Test REMOVING bullet points</li>    <li>purus neque luctus</li>    <li>vel molestie arcu</li></ul><p>This is a sub script</p><p>This is a <sup>super</sup> script</p>');

    }//end testRemovingSubscriptFormatting()


    /**
     * Test that Superscript is removed when you click Remove Format.
     *
     * @return void
     */
    public function testRemovingSuperscriptFormatting()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('super');

        $this->clickTopToolbarButton($dir.'toolbarIcon_removeFormat.png');

        $this->assertHTMLMatch('<h1>First Heading</h1><p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p><h2>Second Heading</h2><p>This is some <del>more</del> information for testing</p><ul>    <li>Test REMOVING bullet points</li>    <li>purus neque luctus</li>    <li>vel molestie arcu</li></ul><p>This is a <sub>sub</sub> script</p><p>This is a super script</p>');

    }//end testRemovingSuperscriptFormatting()


    /**
     * Test that unordered lists are removed when you click Remove Format.
     *
     * @return void
     */
    public function testRemovingUnorderedLists()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('super');

        $this->clickTopToolbarButton($dir.'toolbarIcon_removeFormat.png');

        $this->assertHTMLMatch('<h1>First Heading</h1><p>Lorem XuT dolor</p><p>sit <em>amet</em> <strong>WoW</strong></p><h2>Second Heading</h2><p>This is some <del>more</del> information for testing</p><p>Test REMOVING bullet points</p><p>purus neque luctus</p><p>vel molestie arcu</p><p>This is a <sub>sub</sub> script</p><p>This is a <sup>super</sup> script</p>');

    }//end testRemovingUnorderedLists()

}//end class

?>
