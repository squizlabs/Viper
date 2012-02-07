<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_FormatInTablesUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that heading styles can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testHeadingStylesInTableMouseSelect()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XabcX';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_heading.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_h3.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_h3_active.png'), 'H3 icon not found in inline toolbar');

        $this->assertHTMLMatch('<h3>UnaU TiuT XabcX Mnu</h3>');

    }//end testHeadingStylesInTableMouseSelect()


}//end class

?>
