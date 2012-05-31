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

        $text = 'XuT';
        $textLoc = $this->find('WoW');

        $this->click($this->find($text));
        $this->clickTopToolbarButton($dir.'toolbarIcon_heading.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_h3.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_heading_subHighlighted.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><h3>aa XuT kk</h3></td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_heading_subHighlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_h2.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><h2>aa XuT kk</h2></td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($textLoc);
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton($dir.'toolbarIcon_heading_subHighlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_h1.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><h1>aa XuT kk</h1></td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->find($text));
        $this->clickTopToolbarButton($dir.'toolbarIcon_heading_subHighlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_h1_active.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>aa XuT kk</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');


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
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>aa XuT kk</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec <span class="abc">PORTA</span> ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->find('WoW'));
        $this->selectText('XuT');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_updateChanges_disabled.png'), 'Update Changes button should not be active.');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>aa <span class="test">XuT</span> kk</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec <span class="abc">PORTA</span> ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testClassesOnWordInTable()


    /**
     * Test that classes can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testClassesOnContentInACellOfATable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(3);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td class="test">aa XuT kk</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testClassesOnContentInACellOfATable()


    /**
     * Test that left alignment can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testLeftAlignmentInATable()
    {
        $text = 'XuT';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyLeft');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon is not acitve in the top toolbar');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td style="text-align: left;">aa XuT kk</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLeftAlignmentInATable()


    /**
     * Test that right alignment can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testRightAlignmentInATable()
    {
        $text = 'XuT';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyRight');

        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon is not acitve in the top toolbar');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td style="text-align: right;">aa XuT kk</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');


    }//end testRightAlignmentInATable()


    /**
     * Test that centre alignment can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testCentreAlignmentInATable()
    {
        $text = 'XuT';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyCenter');

        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Centre align icon is not acitve in the top toolbar');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td style="text-align: center;">aa XuT kk</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');


    }//end testCentreAlignmentInATable()


    /**
     * Test that justify alignment can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testJustifyAlignmentInATable()
    {
        $text = 'XuT';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyBlock');

        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Justify align icon is not acitve in the top toolbar');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td style="text-align: justify;">aa XuT kk</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testJustifyAlignmentInATable()


    /**
     * Test that the P tag can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testPInATable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XuT';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_p.png');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><p>aa XuT kk</p></td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_p_active.png');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>aa XuT kk</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testPInATable()


    /**
     * Test that the PRE tag can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testPreInATable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XuT';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_pre.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><pre>aa XuT kk</pre></td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_pre_active.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>aa XuT kk</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testPreInATable()


    /**
     * Test that the DIV tag can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testDivInATable()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $text = 'XuT';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_div.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><div>aa XuT kk</div></td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_div_active.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>aa XuT kk</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testDivInATable()


    /**
     * Test that the Quote tag can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testQuoteInATable()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'XuT';
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_blockquote.png');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><blockquote>aa XuT kk</blockquote></td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats_highlighted.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_blockquote_active.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>aa XuT kk</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testQuoteInATable()


    /**
     * Test applying the Pre tag to a cell that has a single word in it.
     *
     * @return void
     */
    public function testPreInATableWithOneWord()
    {
        $dir     = dirname(__FILE__).'/Images/';

        $this->click($this->find('WoW'));

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_pre.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><tbody><tr><th>Col1 Header</th><th>Col2 Header</th></tr><tr><td>XuT is in a table</td><td><pre>WoW</pre></td></tr></tbody></table>');

        $this->clickTopToolbarButton($dir.'toolbarIcon_pre_active.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><tbody><tr><th>Col1 Header</th><th>Col2 Header</th></tr><tr><td>XuT is in a table</td><td>WoW</td></tr></tbody></table>');

    }//end testPreInATableWithOneWord()


    /**
     * Test heading and format is disabled in a table caption.
     *
     * @return void
     */
    public function testHeadingAndFormatsIsDisabledInCaption()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text      = 'caption';
        $textLoc = $this->find($text);

        $this->click($textLoc);
        $this->assertTrue($this->exists($dir.'toolbarIcon_heading_disabled.png'));
        $this->assertTrue($this->exists($dir.'toolbarIcon_toggle_formats_disabled.png'));

        $this->selectText($text);
        $this->assertTrue($this->exists($dir.'toolbarIcon_heading_disabled.png'));
        $this->assertTrue($this->exists($dir.'toolbarIcon_toggle_formats_disabled.png'));

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->exists($dir.'toolbarIcon_heading_disabled.png'));
        $this->assertTrue($this->exists($dir.'toolbarIcon_toggle_formats_disabled.png'));

    }//end testHeadingAndFormatsIsDisabled()


}//end class

?>
