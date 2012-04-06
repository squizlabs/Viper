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
        
        $this->click($this->find($text));
        $this->clickTopToolbarButton($dir.'toolbarIcon_heading.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_h3.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><h3>UnaU TiuT XabcX Mnu</h3></td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        
        $this->click($this->find('Mnu'));
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_heading_subHighlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_h2.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><h2>UnaU TiuT XabcX Mnu</h2></td><td>WOW</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton($dir.'toolbarIcon_heading_subHighlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_h1.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><h1>UnaU TiuT XabcX Mnu</h1></td><td>WOW</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        
        $this->click($this->find($text));
        $this->clickTopToolbarButton($dir.'toolbarIcon_heading_subHighlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_h1_active.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        

    }//end testHeadingStylesInTableMouseSelect()


    /**
     * Test that classes can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testClassesOnWordInTable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'PORTA';
        $this->selectText($text);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('abc');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_updateChanges_disabled.png'), 'Update Changes button should not be active.');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec <span class="abc">PORTA</span> ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->click($this->find('WoW'));

        $text = 'XabcX';
        $this->selectText($text);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_updateChanges.png'), 'Update Changes button should not be active.');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT <span class="test">XabcX</span> Mnu</td><td>WOW</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec <span class="abc">PORTA</span> ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

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

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td class="test">UnaU TiuT XabcX Mnu</td><td>WOW</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

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

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td style="text-align: left;">UnaU TiuT XabcX Mnu</td><td>WOW</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        
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

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td style="text-align: right;">UnaU TiuT XabcX Mnu</td><td>WOW</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        

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

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td style="text-align: center;">UnaU TiuT XabcX Mnu</td><td>WOW</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        
        
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

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td style="text-align: justify;">UnaU TiuT XabcX Mnu</td><td>WOW</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        
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

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><p>UnaU TiuT XabcX Mnu</p></td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_p_active.png');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

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
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><pre>UnaU TiuT XabcX Mnu</pre></td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_pre_active.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

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
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><div>UnaU TiuT XabcX Mnu</div></td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_div_active.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testDivInATable()


    /**
     * Test that the Quote tag can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testQuoteInATable()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XabcX';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_blockquote.png');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><blockquote>UnaU TiuT XabcX Mnu</blockquote></td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        
        $text = 'XabcX';
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_blockquote_active.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

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

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_pre.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td><pre>WOW</pre></td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_pre_active.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testPreInATableWithOneWord()

}//end class

?>
