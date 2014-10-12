<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_HeadingsInTablesUnitTest extends AbstractViperUnitTest
{


    /**
     * Test availability of the heading icon in the table format icons in the caption of a table.
     *
     * @return void
     */
    public function testAvailabilityOfHeadingIconInTable()
    {
        // Check icon in caption
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

        // Check icon in table header row
        $this->moveToKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled');
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be enabled in the inline toolbar');
        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');

        // Check icon in table body
        $this->moveToKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled');
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');
        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');

        // Check icon in the table footer
        $this->moveToKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled');
        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');
        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');

    }//end testAvailabilityOfHeadingIconInTable()


    /**
     * Test applying heading styles in the heading of a table.
     *
     * @return void
     */
    public function testApplyingAndRemovingHeadingStylesInTableHeader()
    {
        // Test clicking in a word and applying a heading
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><h2>Col2 %2%</h2></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('H2', 'active', TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><p>Col2 %2%</p></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test adding heading to all content in the P section
        $this->sikuli->click($this->findKeyword(4));
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H3', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><h3>Col2 %2%</h3></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('H3', 'active', TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><p>Col2 %2%</p></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test adding heading to all content in the header section
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><h2>Col2 %2%</h2></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('H2', 'active', TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><p>Col2 %2%</p></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingHeadingStylesInTableHeader()


    /**
     * Test applying heading styles in the body of a table.
     *
     * @return void
     */
    public function testApplyingAndRemovingHeadingStylesInTableBody()
    {
        // Test clicking in a word and applying a heading
        $this->sikuli->click($this->findKeyword(4));
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><h2>sapien vel %4%</h2></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('H2', 'active', TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><p>sapien vel %4%</p></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test adding heading to all content in the P section
        $this->sikuli->click($this->findKeyword(3));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H3', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><h3>sapien vel %4%</h3></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('H3', 'active', TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><p>sapien vel %4%</p></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test adding heading to all content in the cell section
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H4', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><h4>sapien vel %4%</h4></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('H4', 'active', TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><p>sapien vel %4%</p></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingHeadingStylesInTableBody()


    /**
     * Test applying heading styles in the footer of a table.
     *
     * @return void
     */
    public function testApplyingAndRemovingHeadingStylesInTableFooter()
    {
        // Test clicking in a word and applying a heading
        $this->sikuli->click($this->findKeyword(3));
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><h2>Note: this is the table footer %3%</h2></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('H2', 'active', TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><p>Note: this is the table footer %3%</p></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test adding heading to all content in the P section
        $this->sikuli->click($this->findKeyword(4));
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H3', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><h3>Note: this is the table footer %3%</h3></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('H3', 'active', TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><p>Note: this is the table footer %3%</p></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test adding heading to all content in the cell section
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H4', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><h4>Note: this is the table footer %3%</h4></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('H4', 'active', TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><p>Note: this is the table footer %3%</p></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingHeadingStylesInTableFooter()

}//end class

?>
