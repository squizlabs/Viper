<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_StylesInTablesUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that bold can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testBoldInTableMouseSelect()
    {
        $text = 'LAbS';
        $this->selectText($text);

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertEquals('UnaU <strong>LAbS</strong> FoX Mnu', $this->getHtml('td,th', 3));

        $this->selectText($text);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));

        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td,th', 3));

    }//end testBoldInTableMouseSelect()


    /**
     * Test that italics can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testItalicInTableMouseSelect()
    {
        $text = 'LAbS';
        $this->selectText($text);

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertEquals('UnaU <em>LAbS</em> FoX Mnu', $this->getHtml('td,th', 3));

        $this->selectText($text);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));

        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td,th', 3));

    }//end testItalicInTableMouseSelect()


    /**
     * Test that strike through can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testStrikethroughInTableMouseSelect()
    {
        $text = 'LAbS';
        $this->selectText($text);

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_strike.png');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_strike_active.png'));
        $this->assertEquals('UnaU <del>LAbS</del> FoX Mnu', $this->getHtml('td,th', 3));

        // Stop here as we need a way to select text that has a strikethrough.
        $this->markTestIncomplete('Need a way to select text that has a strikethrough.');

        $this->selectText($text);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_strike_active.png');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_strike.png'));

        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td,th', 3));

    }//end testStrikethroughInTableMouseSelect()


    /**
     * Test that sub script can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testSubScriptInTableMouseSelect()
    {
        $text = 'LAbS';
        $this->selectText($text);

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_sub.png');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_sub_active.png'));
        $this->assertEquals('UnaU <sub>LAbS</sub> FoX Mnu', $this->getHtml('td,th', 3));

        // Stop here as we need a way to select subscript text.
        $this->markTestIncomplete('Need a way to select subscript text.');

        $this->selectText($text);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_sub_active.png');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_sub.png'));

        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td,th', 3));

    }//end testSubScriptInTableMouseSelect()


    /**
     * Test that sub script can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testSuperScriptInTableMouseSelect()
    {
        $text = 'LAbS';
        $this->selectText($text);

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_sup.png');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_sup_active.png'));
        $this->assertEquals('UnaU <sup>LAbS</sup> FoX Mnu', $this->getHtml('td,th', 3));

        // Stop here as we need a way to select super script text.
        $this->markTestIncomplete('Need a way to select super script text.');

        $this->selectText($text);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_sup_active.png');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_sup.png'));

        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td,th', 3));

    }//end testSuperScriptInTableMouseSelect()


    /**
     * Test that bold can be applied to a word in a table cell using shortcuts.
     *
     * @return void
     */
    public function testBoldInTableShortcut()
    {
        $text = 'LAbS';
        $this->selectText($text);

        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertEquals('UnaU <strong>LAbS</strong> FoX Mnu', $this->getHtml('td,th', 3));

        $this->selectText($text);
        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));

        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td,th', 3));

    }//end testBoldInTableShortcut()


    /**
     * Test that italics can be applied to a word in a table cell using shortcuts.
     *
     * @return void
     */
    public function testItalicsInTableShortcut()
    {
        $text = 'LAbS';
        $this->selectText($text);

        $this->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertEquals('UnaU <em>LAbS</em> FoX Mnu', $this->getHtml('td,th', 3));

        $this->selectText($text);
        $this->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));

        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td,th', 3));

    }//end testItalicsInTableShortcut()


    /**
     * Test that bold can be applied to multiple words in a table cell.
     *
     * @return void
     */
    public function testBoldInTableMultiWord()
    {
        $this->selectText('LAbS', 'FoX');

        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertEquals('UnaU <strong>LAbS FoX</strong> Mnu', $this->getHtml('td,th', 3));

        $this->click($this->find('LAbS'));
        $this->selectText('FoX');
        $this->selectInlineToolbarLineageItem(4);
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

        $this->click($this->find('FoX'));
        $this->selectText('LAbS');
        $this->selectInlineToolbarLineageItem(4);
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

        $this->click($this->find('FoX'));
        $this->selectText('LAbS');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertEquals('UnaU LAbS<strong> FoX</strong> Mnu', $this->getHtml('td,th', 3));

    }//end testBoldInTableMultiWord()


    /**
     * Test that italics can be applied to multiple words in a table cell.
     *
     * @return void
     */
    public function testItalicInTableMultiWord()
    {
        $this->selectText('LAbS', 'FoX');

        $this->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertEquals('UnaU <em>LAbS FoX</em> Mnu', $this->getHtml('td,th', 3));

        $this->click($this->find('LAbS'));
        $this->selectText('FoX');
        $this->selectInlineToolbarLineageItem(4);
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->click($this->find('FoX'));
        $this->selectText('LAbS');
        $this->selectInlineToolbarLineageItem(4);
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->click($this->find('FoX'));
        $this->selectText('LAbS');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertEquals('UnaU LAbS<em> FoX</em> Mnu', $this->getHtml('td,th', 3));

    }//end testItalicInTableMultiWord()


    /**
     * Test that bold can be applied to whole cell.
     *
     * @return void
     */
    public function testBoldForWholeCell()
    {
        $first  = $this->find('UnaU');
        $second = $this->find('Mnu');

        $this->selectText('FoX');
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertEquals('<strong>UnaU LAbS FoX Mnu</strong>', $this->getHtml('td,th', 3));

        $this->selectText('LAbS');
        $this->selectInlineToolbarLineageItem(3);

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold.png'));
        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td,th', 3));

    }//end testBoldForWholeCell()


    /**
     * Test that italics can be applied to whole cell.
     *
     * @return void
     */
    public function testItalicForWholeCell()
    {
        $text    = 'FoX';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertEquals('<em>UnaU LAbS FoX Mnu</em>', $this->getHtml('td,th', 3));

        $this->click($textLoc);
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(3);

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic.png'));
        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td,th', 3));

    }//end testItalicForWholeCell()


    /**
     * Test that styles can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testStylingInTableMultipleStyles()
    {
        $text    = 'FoX';
        $textLoc = $this->find($text);
        $this->selectText($text);

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->mouseMove($this->createLocation(0, 0));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->click($textLoc);
        $this->dragDrop($this->getTopLeft($textLoc), $this->getBottomRight($textLoc));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->doubleClick($textLoc);
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png');
        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td,th', 3));

    }//end testStylingInTableMultipleStyles()


    /**
     * Test applying bold formatting to the caption.
     *
     * @return void
     */
    public function testBoldFormattingToCaption()
    {
        $text    = 'caption';
        $textLoc = $this->find($text);
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(1);

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2: The table caption text goes here la</strong></caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->click($this->find('blah'));
        $this->selectText('Table');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png'));

        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold_active.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption>Table 1.2: The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testBoldFormattingToCaption()
    

    /**
     * Test undo after formating a caption.
     *
     * @return void
     */
    public function testUndoAfterFormatingCaption()
    {
        $text    = 'caption';
        $textLoc = $this->find($text);
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(1);

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_bold.png');
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong><em>Table 1.2: The table caption text goes here la</em></strong></caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->assertTrue($this->topToolbarButtonExists(dirname(dirname(__FILE__)).'/Core/Images/tundoIcon_active.png'));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2: The table caption text goes here la</strong></caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        
        $this->assertTrue($this->topToolbarButtonExists(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png'));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testUndoAfterFormatingCaption()
    
    
    /**
     * Test applying italics formatting to the caption.
     *
     * @return void
     */
    public function testItalicFormattingToCaption()
    {
        $text    = 'caption';
        $textLoc = $this->find($text);
        $this->selectText($text);
        $this->selectInlineToolbarLineageItem(1);

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><em><strong>Table 1.2:</strong> The table caption text goes here la</em></caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->click($this->find('blah'));
        $this->selectText('Table');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png'));

        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_italic_active.png');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td id="x" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testItalicFormattingToCaption()
    
  
    

}//end class

?>
