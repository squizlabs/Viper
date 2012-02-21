<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_FormatInTablesUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that heading styles can be applied to the text in a cell.
     *
     * @return void
     */
    public function testHeadingStylesInTable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XabcX';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_heading.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_h3.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_heading_subHighlighted.png'), 'The toggle headings icon is not highlighted');

        $html = $this->getHtml('td', 0);
        $this->assertEquals('<h3>UnaU TiuT XabcX Mnu</h3>', $html);


    }//end testHeadingStylesInTableMouseSelect()


    /**
     * Test that classes can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testClassesOnWordInTable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XabcX';
        $this->selectText($text);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->clickInlineToolbarButton($dir.'input_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $html = $this->getHtml('td', 0);
        $this->assertEquals('UnaU TiuT <span class="test">XabcX</span> Mnu', $html);

    }//end testClassesOnWordInTable()


    /**
     * Test that classes can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testClassesOnContentInACellOfATable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XabcX';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->clickInlineToolbarButton($dir.'input_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

        $html = $this->getHtml('tr', 1);
        $this->assertEquals('<td class="test">UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td>', $html);


    }//end testClassesOnContentInACellOfATable()


    /**
     * Test that left alignment can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testLeftAlignmentInATable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XabcX';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignLeft_active.png'), 'Left align icon is not acitve in the top toolbar');

        $html = $this->getHtml('tr', 1);
        $this->assertEquals('<td style="text-align: left;">UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>\n        </td>', $html);

    }//end testLeftAlignmentInATable()


    /**
     * Test that right alignment can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testRightAlignmentInATable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XabcX';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignRight_active.png'), 'Right align icon is not acitve in the top toolbar');

        $html = $this->getHtml('tr', 1);
        $this->assertEquals('<td style="text-align: right;">UnaU TiuT XabcX Mnu</td><td>WOW</td> <td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td>', $html);

    }//end testRightAlignmentInATable()


    /**
     * Test that centre alignment can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testCentreAlignmentInATable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XabcX';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignCenter_active.png'), 'Centre align icon is not acitve in the top toolbar');

        $html = $this->getHtml('tr', 1);
        $this->assertEquals('<td style="text-align: center;">UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td>', $html);

    }//end testCentreAlignmentInATable()


    /**
     * Test that justify alignment can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testJustifyAlignmentInATable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XabcX';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignJustify.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignJustify_active.png'), 'Justify align icon is not acitve in the top toolbar');

        $html = $this->getHtml('tr', 1);
        $this->assertEquals('<td style="text-align: justify;">UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td>', $html);

    }//end testJustifyAlignmentInATable()


    /**
     * Test that the P tag can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testPInATable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XabcX';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_p.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Formats icon is not highlighted in the top toolbar');

        $html = $this->getHtml('td', 0);
        $this->assertEquals('<p>UnaU TiuT XabcX Mnu</p>', $html);

    }//end testPInATable()


    /**
     * Test that the PRE tag can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testPreInATable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XabcX';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_pre.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Formats icon is not highlighted in the top toolbar');

        $html = $this->getHtml('td', 0);
        $this->assertEquals('<pre>UnaU TiuT XabcX Mnu</pre>', $html);

    }//end testPreInATable()


    /**
     * Test that the DIV tag can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testDivInATable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XabcX';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_div.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Formats icon is not highlighted in the top toolbar');

        $html = $this->getHtml('td', 0);
        $this->assertEquals('<div>UnaU TiuT XabcX Mnu</div>', $html);

    }//end testDivInATable()


    /**
     * Test that the Quote tag can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testQuoteInATable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XabcX';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_quote.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Formats icon is not highlighted in the top toolbar');

        $html = $this->getHtml('td', 0);
        $this->assertEquals('<quote>UnaU TiuT XabcX Mnu</quote>', $html);

    }//end testQuoteInATable()


    /**
     * Test applying the Pre tag to a cell that has a single word in it.
     *
     * @return void
     */
    public function testPreInATableWithOneWord()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'WOW';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_quote.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Formats icon is not highlighted in the top toolbar');

        $html = $this->getHtml('td', 0);
        $this->assertEquals('<quote>WOW</quote>', $html);
        $this->assertEquals('WOW', $this->getSelectedText(), 'Original selection is not selected');

    }//end testPreInATableWithOneWord()

}//end class

?>
