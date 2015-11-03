<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_ItalicInTableUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that italics can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testItalicInTable()
    {
        // Apply and remove italic using inline toolbar
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <em>%3%</em> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Apply and remove italic using top toolbar
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <em>%3%</em> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Apply and remove italic using keyboard shortcuts
        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <em>%3%</em> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testItalicInTable()


    /**
     * Test that italics can be applied to multiple words in a table cell.
     *
     * @return void
     */
    public function testItalicInTableMultiWord()
    {
        // Apply italics to multiple words
        $this->selectKeyword(3, 4);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <em>%3% %4%</em> Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->selectKeyword(4);
        sleep(1);
        $this->selectInlineToolbarLineageItem(4);
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));

        $this->selectKeyword(3);
        sleep(1);
        $this->selectInlineToolbarLineageItem(4);
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));

        // Remove italics from one word
        $this->selectKeyword(3);
        sleep(1);
        $this->clickInlineToolbarButton('italic', 'active');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3%<em> %4%</em> Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Remove italics from other word
        $this->selectKeyword(4);
        sleep(1);
        $this->clickInlineToolbarButton('italic', 'active');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testItalicInTableMultiWord()
 

    /**
     * Test that italics can be applied to whole cell.
     *
     * @return void
     */
    public function testItalicForWholeCell()
    {
        // Apply and remove italics using inline toolbar
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        sleep(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><em>UnaU %3% %4% Mnu</em></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Apply and remove italics using top toolbar
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        sleep(1);
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><em>UnaU %3% %4% Mnu</em></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Apply and remove italics using keyboard shortcut
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><em>UnaU %3% %4% Mnu</em></td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(4);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('italic'));
        $this->assertTrue($this->topToolbarButtonExists('italic'));
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testItalicForWholeCell()

    
    /**
     * Test applying italics formatting to the caption.
     *
     * @return void
     */
    public function testItalicFormattingToCaption()
    {
        // Apply italics to the caption
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><em><strong>Table 1.2:</strong> %1% The table %2% text goes here la</em></caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickKeyword(5);
        $this->selectKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'));
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><em><strong>Table 1.2:</strong> %1% The table %2% text goes here la</em></caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testItalicFormattingToCaption()


    /**
     * Test undo and redo italic in a table.
     *
     * @return void
     */
    public function testUndoAndRedoItalicInTable()
    {
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <em>%3%</em> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU <em>%3%</em> %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testUndoAndRedoItalicInTable()


    /**
     * Test applying and removing italic for a link in the content of a table.
     *
     * @return void
     */
    public function testAddAndRemoveItalicForLinkInTable()
    {
        
        // Using inline toolbar
        $this->moveToKeyword(6);
        $this->selectInlineToolbarLineageItem(5);
        $this->assertTrue($this->inLineToolbarButtonExists('italic', 'active'), 'italic icon should be active');
        $this->selectInlineToolbarLineageItem(4);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <a href="http://www.google.com">%6%</a>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic'), 'italic icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'italic icon should not be active');

        $this->moveToKeyword(6);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickInlineToolbarButton('italic');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic', 'active'), 'italic icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon should be active');

        // Using top toolbar
        $this->moveToKeyword(6);
        // Check to see if italic icon is in the inline toolbar
        $this->selectInlineToolbarLineageItem(5);
        $this->assertTrue($this->inLineToolbarButtonExists('italic', 'active'), 'italic icon should be active');
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <a href="http://www.google.com">%6%</a>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic'), 'italic icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'italic icon should not be active');

        $this->moveToKeyword(6);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic', 'active'), 'italic icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon should be active');

        // Using keyboard shortcuts
        $this->moveToKeyword(6);
        // Check to see if italic icon is in the inline toolbar
        $this->selectInlineToolbarLineageItem(5);
        $this->assertTrue($this->inLineToolbarButtonExists('italic', 'active'), 'Bold icon should be active');
        $this->selectInlineToolbarLineageItem(4);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <a href="http://www.google.com">%6%</a>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic'), 'italic icon should not be active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'italic icon should not be active');

        $this->moveToKeyword(6);
        $this->selectInlineToolbarLineageItem(4);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> %1% The table %2% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %3% %4% Mnu</td><td><strong><em>WoW</em></strong> sapien vel aliquet</td><td><ul><li>vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><h3>%5%</h3></td><td colspan="2">purus neque luctus <em><a href="http://www.google.com">%6%</a></em>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');
        $this->assertTrue($this->inLineToolbarButtonExists('italic', 'active'), 'italic icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'italic icon should be active');

    }//end testAddAndRemoveItalicForLink()

}//end class

?>
