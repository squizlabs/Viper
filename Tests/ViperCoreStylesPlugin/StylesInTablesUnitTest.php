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
        $this->selectKeyword(3);

        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <strong>%3%</strong> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'));
        $this->assertTrue($this->topToolbarButtonExists('bold'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testBoldInTableMouseSelect()


    /**
     * Test that italics can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testItalicInTableMouseSelect()
    {
        $this->selectKeyword(3);

        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <em>%3%</em> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testItalicInTableMouseSelect()


    /**
     * Test that strike through can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testStrikethroughInTableMouseSelect()
    {
        $this->selectKeyword(3);

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <del>%3%</del> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testStrikethroughInTableMouseSelect()


    /**
     * Test that sub script can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testSubScriptInTableMouseSelect()
    {
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <sub>%3%</sub> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testSubScriptInTableMouseSelect()


    /**
     * Test that sub script can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testSuperScriptInTableMouseSelect()
    {
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <sup>%3%</sup> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testSuperScriptInTableMouseSelect()


    /**
     * Test that bold can be applied to a word in a table cell using shortcuts.
     *
     * @return void
     */
    public function testBoldInTableShortcut()
    {
        $this->selectKeyword(3);

        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <strong>%3%</strong> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'));
        $this->assertTrue($this->topToolbarButtonExists('bold'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testBoldInTableShortcut()


    /**
     * Test that italics can be applied to a word in a table cell using shortcuts.
     *
     * @return void
     */
    public function testItalicsInTableShortcut()
    {
        $this->selectKeyword(3);

        $this->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <em>%3%</em> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testItalicsInTableShortcut()


    /**
     * Test that bold can be applied to multiple words in a table cell.
     *
     * @return void
     */
    public function testBoldInTableMultiWord()
    {
        $this->selectKeyword(3, 4);

        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <strong>%3% %4%</strong> Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(4);
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'));

        $this->click($this->findKeyword(4));
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(4);
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'));

        $this->click($this->findKeyword(4));
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'));
        $this->assertTrue($this->topToolbarButtonExists('bold'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3%<strong> %4%</strong> Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testBoldInTableMultiWord()


    /**
     * Test that italics can be applied to multiple words in a table cell.
     *
     * @return void
     */
    public function testItalicInTableMultiWord()
    {
        $this->selectKeyword(3, 4);

        $this->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <em>%3% %4%</em> Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(4);
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));

        $this->click($this->findKeyword(4));
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(4);
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));

        $this->click($this->findKeyword(4));
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3%<em> %4%</em> Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testItalicInTableMultiWord()


    /**
     * Test that bold can be applied to whole cell.
     *
     * @return void
     */
    public function testBoldForWholeCell()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        sleep(1);

        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><strong>UnaU %3% %4% Mnu</strong></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);

        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'));
        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'));
        $this->assertTrue($this->topToolbarButtonExists('bold'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testBoldForWholeCell()


    /**
     * Test that italics can be applied to whole cell.
     *
     * @return void
     */
    public function testItalicForWholeCell()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        sleep(1);

        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><em>UnaU %3% %4% Mnu</em></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);

        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));
        $this->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testItalicForWholeCell()


    /**
     * Test that styles can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testStylingInTableMultipleStyles()
    {
        $this->selectKeyword(4);

        $this->clickInlineToolbarButton('bold');
        $this->clickInlineToolbarButton('italic');
        $this->mouseMove($this->createLocation(0, 0));
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));

        $this->click($this->findKeyword(3));
        $this->selectKeyword(4);
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));

        $this->clickInlineToolbarButton('bold', 'active');
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testStylingInTableMultipleStyles()


    /**
     * Test applying bold formatting to the caption.
     *
     * @return void
     */
    public function testBoldFormattingToCaption()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2: %1% The table %2% text goes here la</strong></caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->click($this->findKeyword(5));
        $this->selectKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'));

        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption>Table 1.2: %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testBoldFormattingToCaption()


    /**
     * Test undo and redo bold in a table.
     *
     * @return void
     */
    public function testUndoAndRedoBoldInTable()
    {
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <strong>%3%</strong> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <strong>%3%</strong> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testUndoAndRedoBoldInTable()


    /**
     * Test undo and redo italic in a table.
     *
     * @return void
     */
    public function testUndoAndRedoItalicInTable()
    {
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <em>%3%</em> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <em>%3%</em> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testUndoAndRedoItalicInTable()


    /**
     * Test undo and redo strikethrough in a table.
     *
     * @return void
     */
    public function testUndoAndRedoStrikethroughInTable()
    {
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <del>%3%</del> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <del>%3%</del> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testUndoAndRedoStrikethroughInTable()


    /**
     * Test undo and redo subscript in a table.
     *
     * @return void
     */
    public function testUndoAndRedoSubscriptInTable()
    {
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <sub>%3%</sub> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <sub>%3%</sub> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testUndoAndRedoSubscriptInTable()


    /**
     * Test undo and redo superscript in a table.
     *
     * @return void
     */
    public function testUndoAndRedoSuperscriptInTable()
    {
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <sup>%3%</sup> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <sup>%3%</sup> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testUndoAndRedoSuperscriptInTable()


    /**
     * Test undo and redo strikethrough in a caption.
     *
     * @return void
     */
    public function testUndoAndRedoStrikethroughInCaption()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table <del>%2%</del> text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table <del>%2%</del> text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testUndoAndRedoStrikethroughInCaption()


    /**
     * Test undo and redo subscript in a caption.
     *
     * @return void
     */
    public function testUndoAndRedoSubscriptInCaption()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table <sub>%2%</sub> text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table <sub>%2%</sub> text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testUndoAndRedoSubscriptInCaption()


    /**
     * Test undo and redo superscript in a caption.
     *
     * @return void
     */
    public function testUndoAndRedoSuperscriptInCaption()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table <sup>%2%</sup> text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table <sup>%2%</sup> text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testUndoAndRedoSuperscriptInCaption()


    /**
     * Test applying italics formatting to the caption.
     *
     * @return void
     */
    public function testItalicFormattingToCaption()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><em><strong>Table 1.2:</strong> %1% The table %2% text goes here la</em></caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->click($this->findKeyword(5));
        $this->selectKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));

        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testItalicFormattingToCaption()

}//end class

?>
