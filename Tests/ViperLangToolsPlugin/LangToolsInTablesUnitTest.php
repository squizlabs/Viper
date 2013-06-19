<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLangToolsPlugin_LangToolsInTablesUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that the language tools are available for a table.
     *
     * @return void
     */
    public function testLanguageToolsAvailableInTable()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

    }//end testLanguageToolsAvailableInTable()


    /**
     * Test applying, editing, deleting and undo/redo for an language for a table.
     *
     * @return void
     */
    public function testLanguageInTable()
    {
        // Test adding a language
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3" lang="abc"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the language
        $this->click($this->findKeyword(3));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3" lang="abcdef"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the language
        $this->click($this->findKeyword(3));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3" lang="abcdef"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLanguageInTable()


    /**
     * Test that the language tools are available for a caption.
     *
     * @return void
     */
    public function testLanguageToolsAvailableInTableCaption()
    {
        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'disabled'), 'Language icon in Top Toolbar should not be active.');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should be active.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should be active.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

    }//end testLanguageToolsAvailableInTableCaption()


    /**
     * Test applying, editing, deleting and undo/redo for an acronym in a caption.
     *
     * @return void
     */
    public function testAcronymInCaption()
    {
        // Test adding an acronym
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <acronym title="abc">%1%</acronym></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the acronym
        $this->click($this->findKeyword(3));
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <acronym title="abcdef">%1%</acronym></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the acronym
        $this->click($this->findKeyword(3));
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->clearFieldValue('Acronym');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <acronym title="abcdef">%1%</acronym></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAcronymInCaption()


    /**
     * Test applying, editing, deleting and undo/redo for an abbreviation in a caption.
     *
     * @return void
     */
    public function testAbbreviationInCaption()
    {
        // Test adding an abbreviation
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <abbr title="abc">%1%</abbr></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the abbreviation
        $this->click($this->findKeyword(3));
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <abbr title="abcdef">%1%</abbr></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the abbreviation
        $this->click($this->findKeyword(3));
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <abbr title="abcdef">%1%</abbr></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testAbbreviationInCaption()


    /**
     * Test applying, editing, deleting and undo/redo for an language in a caption.
     *
     * @return void
     */
    public function testLanguageInCaption()
    {
        // Test adding a language
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <span lang="abc">%1%</span></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the language
        $this->click($this->findKeyword(3));
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <span lang="abcdef">%1%</span></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the language
        $this->click($this->findKeyword(3));
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying language to the full caption
        $this->click($this->findKeyword(3));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption lang="test"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption lang="test"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLanguageInCaption()


    /**
     * Test that the language tools are available for a header section of a table.
     *
     * @return void
     */
    public function testLanguageToolsAvailableInTableHeader()
    {
        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'disabled'), 'Language icon in Top Toolbar should not be active.');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should be active.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should be active.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

    }//end testLanguageToolsAvailableInTableHeader()


    /**
     * Test applying, editing, deleting and undo/redo for an acronym in a table header.
     *
     * @return void
     */
    public function testAcronymInTableHeader()
    {
        // Test adding an acronym
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <acronym title="abc">%2%</acronym></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the acronym.
        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <acronym title="abcdef">%2%</acronym></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the acronym.
        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->clearFieldValue('Acronym');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <acronym title="abcdef">%2%</acronym></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testAcronymInTableHeader()


    /**
     * Test applying, editing, deleting and undo/redo for an abbreviation in a header section.
     *
     * @return void
     */
    public function testAbbreviationInTableHeader()
    {
        // Test adding an abbreviation
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <abbr title="abc">%2%</abbr></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the abbreviation
        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <abbr title="abcdef">%2%</abbr></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the abbreviation
        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <abbr title="abcdef">%2%</abbr></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testAbbreviationInTableHeader()


    /**
     * Test applying, editing, deleting and undo/redo for an language in a table header.
     *
     * @return void
     */
    public function testLanguageInTableHeader()
    {
        // Test adding a language
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <span lang="abc">%2%</span></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the language
        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <span lang="abcdef">%2%</span></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the language
        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <span lang="abcdef">%2%</span></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying language to the header cell
        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th lang="test">Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying language to the row cell
        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr lang="test"><th>Col1 Header</th><th>Col2 Header</th><th lang="test">Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying language to the thead cell
        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead lang="test"><tr lang="test"><th>Col1 Header</th><th>Col2 Header</th><th lang="test">Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLanguageInTableHeader()


    /**
     * Test that the language tools are available for a footer section of a table.
     *
     * @return void
     */
    public function testLanguageToolsAvailableInTableFooter()
    {
        $this->click($this->findKeyword(3));
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'disabled'), 'Language icon in Top Toolbar should not be active.');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should be active.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should be active.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

    }//end testLanguageToolsAvailableInTableFooter()


    /**
     * Test applying, editing, deleting and undo/redo for an acronym in a table footer.
     *
     * @return void
     */
    public function testAcronymInTableFooter()
    {
        // Test adding an acronym
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <acronym title="abc">%3%</acronym></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the acronym
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <acronym title="abcdef">%3%</acronym></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the acronym
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->clearFieldValue('Acronym');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <acronym title="abcdef">%3%</acronym></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testAcronymInTableFooter()


    /**
     * Test applying, editing, deleting and undo/redo for an abbreviation in a footer section.
     *
     * @return void
     */
    public function testAbbreviationInTableFooter()
    {
        // Test adding an footer
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <abbr title="abc">%3%</abbr></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the abbreviation
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <abbr title="abcdef">%3%</abbr></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the abbreviation
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <abbr title="abcdef">%3%</abbr></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testAbbreviationInTableHeader()


    /**
     * Test applying, editing, deleting and undo/redo for an language in a table footer.
     *
     * @return void
     */
    public function testLanguageInTableFooter()
    {
        // Test adding a language
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <span lang="abc">%3%</span></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the language
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <span lang="abcdef">%3%</span></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the language
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <span lang="abcdef">%3%</span></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying language to the footer cell
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3" lang="test">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying language to the row cell
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr lang="test"><td colspan="3" lang="test">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying language to the thead cell
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot lang="test"><tr lang="test"><td colspan="3" lang="test">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLanguageInTableFooter()


    /**
     * Test that the language tools are available for a body section of a table.
     *
     * @return void
     */
    public function testLanguageToolsAvailableInTableBody()
    {
        $this->click($this->findKeyword(4));
        $this->assertTrue($this->topToolbarButtonExists('langTools', 'disabled'), 'Language icon in Top Toolbar should not be active.');

        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', NULL, TRUE), 'Acronym button should be active.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', NULL, TRUE), 'Abbreviation button should be active.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('langTools');
        $this->assertTrue($this->topToolbarButtonExists('Acronym', 'disabled', TRUE), 'Acronym button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Abbreviation', 'disabled', TRUE), 'Abbreviation button should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Language', NULL, TRUE), 'Language button should be active.');

    }//end testLanguageToolsAvailableInTableBody()


    /**
     * Test applying, editing, deleting and undo/redo for an acronym in a table body.
     *
     * @return void
     */
    public function testAcronymInTableBody()
    {
        // Test adding an acronym
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Acronym', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <acronym title="abc">%4%</acronym></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the acronym
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <acronym title="abcdef">%4%</acronym></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the acronym
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Acronym', 'active', TRUE);
        $this->clearFieldValue('Acronym');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <acronym title="abcdef">%4%</acronym></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testAcronymInTableBody()


    /**
     * Test applying, editing, deleting and undo/redo for an abbreviation in a body section.
     *
     * @return void
     */
    public function testAbbreviationInTableBody()
    {
        // Test adding an footer
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Abbreviation', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <abbr title="abc">%4%</abbr></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the abbreviation
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <abbr title="abcdef">%4%</abbr></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the abbreviation
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Abbreviation', 'active', TRUE);
        $this->clearFieldValue('Abbreviation');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <abbr title="abcdef">%4%</abbr></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testAbbreviationInTableBody()


    /**
     * Test applying, editing, deleting and undo/redo for an language in a table body.
     *
     * @return void
     */
    public function testLanguageInTableBody()
    {
        // Test adding a language
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <span lang="abc">%4%</span></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the language
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->type('def');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <span lang="abcdef">%4%</span></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the language
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('langTools', 'active');
        $this->clickTopToolbarButton('Language', 'active', TRUE);
        $this->clearFieldValue('Language');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <span lang="abcdef">%4%</span></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying language to the body cell
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td lang="test">sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying language to the row cell
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr lang="test"><td lang="test">sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying language to the tbdoy cell
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('langTools');
        $this->clickTopToolbarButton('Language', NULL, TRUE);
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody lang="test"><tr lang="test"><td lang="test">sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLanguageInTableBody()


}//end class

?>
