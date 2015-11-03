<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLinkPlugin_LinkInTableUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that the link tool is not available for a table.
     *
     * @return void
     */
    public function testLinksNotAvailableInTable()
    {
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled', TRUE), 'Link icon should be disabled.');

    }//end testLinksNotAvailableInTable()


    /**
     * Test removing links from the content in a table.
     *
     * @return void
     */
    public function testRemovingLinksInTable()
    {
        $this->useTest(1);

        // Test remove link in inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong>ligula</strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo so we can test the top toolbar
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test remove link in top toolbar
         $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong>ligula</strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testRemovingLinksInTable()


    /**
     * Test that the link tools are available for a caption.
     *
     * @return void
     */
    public function testLinkToolsAvailableInTableCaption()
    {
        $this->useTest(1);

        $this->clickKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'), 'Link icon should not be active.');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('link'), 'Link icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon should be active.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('link'), 'Link icon should be active.');

    }//end testLinkToolsAvailableInTableCaption()


    /**
     * Test applying, editing, deleting and undo/redo for a links in a caption using the inline toolbar.
     *
     * @return void
     */
    public function testLinksInCaptionUsingInlineToolbar()
    {
        $this->useTest(1);

        // Test adding a link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the link
        $this->clickKeyword(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <a href="http://www.google.com" title="Squiz Labs" target="_blank">%1%</a></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the link
        $this->clickKeyword(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <a href="http://www.google.com" title="Squiz Labs" target="_blank">%1%</a></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLinksInCaptionUsingInlineToolbar()


    /**
     * Test applying, editing, deleting and undo/redo for a links in a caption using the top toolbar.
     *
     * @return void
     */
    public function testLinksInCaptionUsingTopToolbar()
    {
        $this->useTest(1);

        // Test adding a link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the link
        $this->clickKeyword(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <a href="http://www.google.com" title="Squiz Labs" target="_blank">%1%</a></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the link
        $this->clickKeyword(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying link to the full caption
        $this->clickKeyword(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank"><strong>Table 1.2:</strong> The table caption text %1%</a></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank"><strong>Table 1.2:</strong> The table caption text %1%</a></caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLinksInCaptionUsingTopToolbar()


    /**
     * Test that the link tools are available for a header section.
     *
     * @return void
     */
    public function testLinkToolsAvailableInTableHeader()
    {
        $this->useTest(1);

        $this->clickKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'), 'Link icon should not be active.');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('link'), 'Link icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon should be active.');

        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('link'), 'Link icon should be active.');

        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'), 'Link icon should be disabled.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'), 'Link icon should be disabled.');

    }//end testLinkToolsAvailableInTableHeader()


    /**
     * Test applying, editing, deleting and undo/redo for a links in a header using the inline toolbar.
     *
     * @return void
     */
    public function testLinksInHeaderUsingInlineToolbar()
    {
        $this->useTest(1);

        // Test adding a link
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%2%</a></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the link
        $this->clickKeyword(1);
        $this->clickKeyword(3);
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <a href="http://www.google.com" title="Squiz Labs" target="_blank">%2%</a></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the link.
        $this->clickKeyword(1);
        $this->clickKeyword(3);
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <a href="http://www.google.com" title="Squiz Labs" target="_blank">%2%</a></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLinksInHeaderUsingInlineToolbar()


    /**
     * Test applying, editing, deleting and undo/redo for a links in a header using the top toolbar.
     *
     * @return void
     */
    public function testLinksInHeaderUsingTopToolbar()
    {
        $this->useTest(1);

        // Test adding a link
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%2%</a></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the link
        $this->clickKeyword(3);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 <a href="http://www.google.com" title="Squiz Labs" target="_blank">%2%</a></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the link
        $this->clickKeyword(3);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying link to the full header
        $this->clickKeyword(3);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">Col3 %2%</a></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">Col3 %2%</a></th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLinksInHeaderUsingTopToolbar()


    /**
     * Test that the link tools are available for a footer section.
     *
     * @return void
     */
    public function testLinkToolsAvailableInTableFooter()
    {
        $this->useTest(1);

        $this->clickKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'), 'Link icon should not be active.');

        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('link'), 'Link icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon should be active.');

        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('link'), 'Link icon should be active.');

        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'), 'Link icon should be disabled.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'), 'Link icon should be disabled.');

    }//end testLinkToolsAvailableInTableFooter()


    /**
     * Test applying, editing, deleting and undo/redo for a links in a footer using the inline toolbar.
     *
     * @return void
     */
    public function testLinksInFooterUsingInlineToolbar()
    {
        $this->useTest(1);

        // Test adding a link
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%3%</a></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the link
        $this->clickKeyword(2);
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <a href="http://www.google.com" title="Squiz Labs" target="_blank">%3%</a></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the link
        $this->clickKeyword(2);
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <a href="http://www.google.com" title="Squiz Labs" target="_blank">%3%</a></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLinksInFooterUsingInlineToolbar()


    /**
     * Test applying, editing, deleting and undo/redo for a links in a footer using the top toolbar.
     *
     * @return void
     */
    public function testLinksInFooterUsingTopToolbar()
    {
        $this->useTest(1);

        // Test adding a link
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%3%</a></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the link
        $this->clickKeyword(2);
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <a href="http://www.google.com" title="Squiz Labs" target="_blank">%3%</a></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the link
        $this->clickKeyword(2);
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying link to the full cell
        $this->clickKeyword(2);
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3"><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">Note: this is the table footer %3%</a></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3"><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">Note: this is the table footer %3%</a></td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLinksInFooterUsingTopToolbar()


    /**
     * Test that the link tools are available for a body section.
     *
     * @return void
     */
    public function testLinkToolsAvailableInTableBody()
    {
        $this->useTest(1);

        $this->clickKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'), 'Link icon should not be active.');

        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('link'), 'Link icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon should be active.');

        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('link'), 'Link icon should be active.');

        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'), 'Link icon should be disabled.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'), 'Link icon should be disabled.');

    }//end testLinkToolsAvailableInTableBody()


    /**
     * Test applying, editing, deleting and undo/redo for a link in a body using the inline toolbar.
     *
     * @return void
     */
    public function testLinksInBodyUsingInlineToolbar()
    {
        $this->useTest(1);

        // Test adding a link
        $this->selectKeyword(4);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%4%</a></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the link
        $this->clickKeyword(2);
        $this->selectKeyword(4);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <a href="http://www.google.com" title="Squiz Labs" target="_blank">%4%</a></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the link
        $this->clickKeyword(2);
        $this->selectKeyword(4);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <a href="http://www.google.com" title="Squiz Labs" target="_blank">%4%</a></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLinksInBodyUsingInlineToolbar()


    /**
     * Test applying, editing, deleting and undo/redo for a links in a body using the top toolbar.
     *
     * @return void
     */
    public function testLinksInBodyUsingTopToolbar()
    {
        $this->useTest(1);

        // Test adding a link
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%4%</a></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the link
        $this->clickKeyword(2);
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel <a href="http://www.google.com" title="Squiz Labs" target="_blank">%4%</a></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deleting the link
        $this->clickKeyword(2);
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying link to the full cell
        $this->clickKeyword(2);
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">sapien vel %4%</a></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test undo and redo
        $this->clickTopToolbarButton('historyUndo');
         $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">sapien vel %4%</a></td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLinksInBodyUsingTopToolbar()


    /**
     * Test deleting an existing link and adding new content into the cell.
     *
     * @return void
     */
    public function testDeleteLinkAndAddNewContent()
    {
        // Highlight all of the content in the cell, deleting it and adding new content
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');

        for ($i = 1; $i <= 28; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }
        sleep(1);
        $this->type('new content');
        $this->assertHTMLMatchNoHeaders('<table><tbody><tr><th>Gate</th><th>Standard</th><th>Imp</th><th>Reviewer</th></tr><tr><td>Q1/Q2</td><td>new content</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table>');

        // Highlight all of the content in the cell, deleting it and adding new content
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');

        for ($i = 1; $i <= 27; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->type('new content');
        $this->assertHTMLMatchNoHeaders('<table><tbody><tr><th>Gate</th><th>Standard</th><th>Imp</th><th>Reviewer</th></tr><tr><td>Q1/Q2</td><td>new content</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table>');

    }//end testDeleteLinkAndAddNewContent()


    /**
     * Test removing links from the content in a table and clicking back into a table.
     *
     * @return void
     */
    public function testRemovingLinksAndClickIntoTable()
    {
        
        // Test remove link using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong>ligula</strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deselecting content
        $this->moveToKeyword(2);
        $this->assertEquals('', $this->getSelectedText(), 'Nothing should be selected');

        // Test remove link in top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatchNoHeaders('<table cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 %2%</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>sapien vel %4%</td><td>nec porta ante</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong>ligula</strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test deselecting content
        $this->moveToKeyword(2);
        $this->assertEquals('', $this->getSelectedText(), 'Nothing should be selected');

    }//end testRemovingLinksAndClickIntoTable()

}//end class

?>
