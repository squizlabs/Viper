<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_FormatInTablesUnitTest extends AbstractViperUnitTest
{


    /**
     * Test availability of the format icons in the caption of a table.
     *
     * @return void
     */
    public function testAvailabilityOfFormatIconsInTableCaption()
    {
        // Check icons when clicking in a word in the caption
        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Justify icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'), 'Class icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should be disabled');

        // Check icons when selecting a word  in the caption
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Justify icon should be active');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyLeft'), 'Justify icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');

        // Check icons when selecting all content in a caption
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Justify icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyLeft'), 'Justify icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');

    }//end testAvailabilityOfFormatIconsInTableCaption()


    /**
     * Test availability of the format icons for a table.
     *
     * @return void
     */
    public function testAvailabilityOfFormatIconsForTable()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Justify icon should be active');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyCenter', 'active'), 'Justify icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Headings icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the inline toolbar');

    }//end testAvailabilityOfFormatIconsForTable()


    /**
     * Test availability of the format icons in the header row of a table.
     *
     * @return void
     */
    public function testAvailabilityOfFormatIconsInTableHeader()
    {
        // Check icons when clicking in a word
        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center alignment icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('formats'), 'Formats icon should be enabled');
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'), 'Class icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should be disabled');

        // Check icons when selecting a word in the header row
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center alignment icon should be active');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyCenter', 'active'), 'Center alignment icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats'), 'Formats icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should be available in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');

        // Check icons when you select all content in the header cell
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center alignment icon should be active');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyCenter', 'active'), 'Center alignment icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats'), 'Formats icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('formats'), 'Formats icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the inline toolbar');

        // Check icons when you select all content in the header row
        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Alignment icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyLeft'), 'Alignment icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');

        // Check icons when selecting Thead
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Alignment icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyLeft'), 'Alignment icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');

    }//end testAvailabilityOfFormatIconsInTableHeader()


    /**
     * Test availability of the format icons in the body section of a table.
     *
     * @return void
     */
    public function testAvailabilityOfFormatIconsInTableBody()
    {
        // Check icons when click in a word
        $this->click($this->findKeyword(4));
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left alignment icon should be enabled');
        $this->assertTrue($this->topToolbarButtonExists('formats'), 'Formats icon should be enabled');
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'), 'Class icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should be disabled');

        // Check icons when selecting a word
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left alignment icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyLeft'), 'Left alignment icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats'), 'Formats icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');

        // Check icons when selecting all content in the cell
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left alignment icon should be active');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyLeft'), 'Left alignment icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats'), 'Formats icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('formats'), 'Formats icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled');

        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');

        // Check icons when selecting all content in the row
        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Alignment icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyLeft'), 'Alignment icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');

        // Check icons when selecting the Tbody
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Alignment icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyLeft'), 'Alignment icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled');

        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');

    }//end testAvailabilityOfFormatIconsInTableBody()


    /**
     * Test availability of the format icons in the footer of a table.
     *
     * @return void
     */
    public function testAvailabilityOfFormatIconsInTableFooter()
    {
        // Check icons when clicking in a word
        $this->click($this->findKeyword(3));
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left alignment icon should be enabled');
        $this->assertTrue($this->topToolbarButtonExists('formats'), 'Formats icon should be enabled');
        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'), 'Class icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should be disabled');

        // Check icons when select a word
        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left alignment icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyLeft'), 'Left alignment icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats'), 'Formats icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');

        // Check icons when selecting all content in the cell
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Left alignment icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyLeft'), 'Left alignment icon should not be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats'), 'Formats icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('formats'), 'Formats icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Heading icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled');

        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');

        // Check icons when selecting the row
        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Alignment icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyLeft'), 'Alignment icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');

        // Check icons when selecting the Tfoot
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft'), 'Alignment icon should be enabled');
        $this->assertFalse($this->inlineToolbarButtonExists('justifyLeft'), 'Alignment icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('formats', 'disabled'), 'Formats icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertFalse($this->inlineToolbarButtonExists('headings', 'disabled'), 'Heading icon should not appear in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('cssClass'), 'Class icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'), 'Class icon should be enabled in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');

    }//end testAvailabilityOfFormatIconsInTableBody()


    /**
     * Test applying heading styles in the heading of a table.
     *
     * @return void
     */
    public function testApplyingAndRemovingHeadingStylesInTableHeader()
    {
        // Test clicking in a word and applying a heading
        $this->click($this->findKeyword(2));
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><h2>Col2 %2%</h2></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('H2', 'active', TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><p>Col2 %2%</p></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test adding heading to all content in the P section
        $this->click($this->findKeyword(4));
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
        $this->click($this->findKeyword(4));
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><h2>sapien vel %4%</h2></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('H2', 'active', TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><p>sapien vel %4%</p></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test adding heading to all content in the P section
        $this->click($this->findKeyword(3));
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
        $this->click($this->findKeyword(3));
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><h2>Note: this is the table footer %3%</h2></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('H2', 'active', TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><p>Note: this is the table footer %3%</p></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test adding heading to all content in the P section
        $this->click($this->findKeyword(4));
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


    /**
     * Test applying and removing classes in table caption using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingClassInTableCaptionUsingInlineToolbar()
    {
        $originalHTML = '<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>';

        // Test applying and removing from a word
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <span class="test">%1%</span></caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in cell
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption class="test"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

    }//end testApplyingAndRemovingClassInTableCaptionUsingInlineToolbar()


    /**
     * Test applying and removing classes in table caption using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingClassInTableCaptionUsingTopToolbar()
    {
        $originalHTML = '<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>';

        // Test applying and removing from a word
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <span class="test">%1%</span></caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(4));
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from all content in caption
        $this->click($this->findKeyword(4));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption class="test"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(4));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('cssClass');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

    }//end testApplyingAndRemovingClassInTableCaptionUsingTopToolbar()


    /**
     * Test applying and removing classes in table header using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingClassInTableHeaderUsingInlineToolbar()
    {
        $originalHTML = '<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>';

        // Test applying and removing from a word
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 <span class="test">%2%</span></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in cell
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th class="test">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in header row
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr class="test"><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in the Thead
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead class="test"><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

    }//end testApplyingAndRemovingClassInTableBodyUsingInlineToolbar()


    /**
     * Test applying and removing classes in table header using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingClassInTableHeaderUsingTopToolbar()
    {
        $originalHTML = '<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>';

        // Test applying and removing from a word
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 <span class="test">%2%</span></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in cell
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th class="test">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('cssClass');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in header row
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr class="test"><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('cssClass');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in the Thead
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead class="test"><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

    }//end testApplyingAndRemovingClassInTableBodyUsingTopToolbar()


    /**
     * Test applying and removing classes in table body using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingClassInTableBodyUsingInlineToolbar()
    {
        $originalHTML = '<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>';

        // Test applying and removing from a word
        $this->selectKeyword(4);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel <span class="test">%4%</span></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(4);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in cell
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td class="test">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in row
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr class="test"><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in the body
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody class="test"><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

    }//end testApplyingAndRemovingClassInTableBodyUsingInlineToolbar()


    /**
     * Test applying and removing classes in table body using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingClassInTableBodyUsingTopToolbar()
    {
        $originalHTML = '<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>';

        // Test applying and removing from a word
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel <span class="test">%4%</span></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in cell
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td class="test">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in row
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr class="test"><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in the body
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody class="test"><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

    }//end testApplyingAndRemovingClassInTableBodyUsingTopToolbar()


    /**
     * Test applying and removing classes in table footer using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingClassInTableFooterUsingInlineToolbar()
    {
        $originalHTML = '<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>';

        // Test applying and removing from a word
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <span class="test">%3%</span></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(4));
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in cell
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td class="test" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in row
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr class="test"><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in the Tfoot
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot class="test"><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

    }//end testApplyingAndRemovingClassInTableFooterUsingInlineToolbar()


    /**
     * Test applying and removing classes in table footer using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingClassInTableFooterUsingTopToolbar()
    {
        $originalHTML = '<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>';

        // Test applying and removing from a word
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <span class="test">%3%</span></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in cell
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td class="test" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in row
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr class="test"><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

        // Test applying and removing from content in the Tfoot
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead class="test"><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders($originalHTML);

    }//end testApplyingAndRemovingClassInTableFooterUsingTopToolbar()


    /**
     * Test applying and removing a class to a table using inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingClassForTableUsingInlineToolbar()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table class="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingClassForTableUsingInlineToolbar()


    /**
     * Test applying and removing a class to a table using top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingClassForTableUsingTopToolbar()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table class="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');;
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingClassForTable()


    /**
     * Test different alignments for a table.
     *
     * @return void
     */
    public function testAlignmentForTable()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3" style="align: left;"><caption style="align: left;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody style="align: left;"><tr style="align: left;"><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr style="align: left;"><td style="align: left;">nec porta ante</td><td colspan="2" style="align: left;">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3" style="align: center;"><caption style="align: center;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody style="align: center;"><tr style="align: center;"><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr style="align: center;"><td style="align: center;">nec porta ante</td><td colspan="2" style="align: center;">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3" style="align: right;"><caption style="align: right;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody style="align: right;"><tr style="align: right;"><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr style="align: right;"><td style="align: right;">nec porta ante</td><td colspan="2" style="align: right;">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3" style="align: justify;"><caption style="align: justify;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody style="align: justify;"><tr style="align: justify;"><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr style="align: justify;"><td style="align: justify;">nec porta ante</td><td colspan="2" style="align: justify;">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testAlignmentForTable()


    /**
     * Test different alignments in a caption.
     *
     * @return void
     */
    public function testAlignmentInTableCaption()
    {
        // Test clicking in word
        $this->click($this->findKeyword(1));
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption style="text-align: left;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption style="text-align: center;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption style="text-align: right;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption style="text-align: justify;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test select a word
        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption style="text-align: left;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption style="text-align: center;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption style="text-align: right;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption style="text-align: justify;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test selecting a caption
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption style="text-align: left;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption style="text-align: center;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption style="text-align: right;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption style="text-align: justify;"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testAlignmentInTableCaption()


    /**
     * Test different alignments in a header row.
     *
     * @return void
     */
    public function testAlignmentInTableHeaderRow()
    {
        // Test clicking in word
        $this->click($this->findKeyword(2));
        $this->clickTopToolbarButton('justifyCenter', 'active');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th style="text-align: left;">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th style="text-align: center;">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th style="text-align: right;">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th style="text-align: justify;">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test select a word
        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th style="text-align: left;">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th style="text-align: center;">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th style="text-align: right;">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th style="text-align: justify;">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test selecting the Header
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th style="text-align: left;">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th style="text-align: center;">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th style="text-align: right;">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th style="text-align: justify;">Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove justification for further testiing
        $this->clickTopToolbarButton('justifyBlock', 'active');

        // Test selecting the Row
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr style="text-align: left;"><th style="text-align: left;">Col1 Header</th><th style="text-align: left;">Col2 %2%</th><th style="text-align: left;">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr style="text-align: center;"><th style="text-align: center;">Col1 Header</th><th style="text-align: center;">Col2 %2%</th><th style="text-align: center;">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr style="text-align: right;"><th style="text-align: right;">Col1 Header</th><th style="text-align: right;">Col2 %2%</th><th style="text-align: right;">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr style="text-align: justify;"><th style="text-align: justify;">Col1 Header</th><th style="text-align: justify;">Col2 %2%</th><th style="text-align: justify;">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove justification for further testiing
        $this->clickTopToolbarButton('justifyBlock', 'active');

        // Test selecting the Thead
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr style="text-align: left;"><th style="text-align: left;">Col1 Header</th><th style="text-align: left;">Col2 %2%</th><th style="text-align: left;">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr style="text-align: center;"><th style="text-align: center;">Col1 Header</th><th style="text-align: center;">Col2 %2%</th><th style="text-align: center;">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr style="text-align: right;"><th style="text-align: right;">Col1 Header</th><th style="text-align: right;">Col2 %2%</th><th style="text-align: right;">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr style="text-align: justify;"><th style="text-align: justify;">Col1 Header</th><th style="text-align: justify;">Col2 %2%</th><th style="text-align: justify;">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testAlignmentInTableHeaderRow()


    /**
     * Test different alignments in table body.
     *
     * @return void
     */
    public function testAlignmentInTableBody()
    {
        // Test clicking in word
        $this->click($this->findKeyword(4));
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td style="text-align: left;">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td style="text-align: center;">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td style="text-align: right;">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td style="text-align: justify;">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test select a word
        $this->click($this->findKeyword(3));
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td style="text-align: left;">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td style="text-align: center;">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td style="text-align: right;">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td style="text-align: justify;">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test selecting the cell.
        $this->click($this->findKeyword(3));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td style="text-align: left;">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td style="text-align: center;">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td style="text-align: right;">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td style="text-align: justify;">sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove justification styling for further testing
        $this->clickTopToolbarButton('justifyBlock', 'active');

        // Test selecting the Row.
        $this->click($this->findKeyword(3));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr style="align: left;"><td style="align: left;">nec porta ante</td><td style="align: left;">sapien vel %4%</td><td style="align: left;"><ul style="align: left;"><li style="align: left;">purus neque luctus ligula, vel molestie arcu</li><li style="align: left;">purus neque luctus</li><li style="align: left;">vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr style="align: center;"><td style="align: center;">nec porta ante</td><td style="align: center;">sapien vel %4%</td><td style="align: center;"><ul style="align: center;"><li style="align: center;">purus neque luctus ligula, vel molestie arcu</li><li style="align: center;">purus neque luctus</li><li style="align: center;">vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr style="align: right;"><td style="align: right;">nec porta ante</td><td style="align: right;">sapien vel %4%</td><td style="align: right;"><ul style="align: right;"><li style="align: right;">purus neque luctus ligula, vel molestie arcu</li><li style="align: right;">purus neque luctus</li><li style="align: right;">vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr style="align: justify;"><td style="align: justify;">nec porta ante</td><td style="align: justify;">sapien vel %4%</td><td style="align: justify;"><ul style="align: justify;"><li style="align: justify;">purus neque luctus ligula, vel molestie arcu</li><li style="align: justify;">purus neque luctus</li><li style="align: justify;">vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove justification styling for further testing
        $this->clickTopToolbarButton('justifyBlock', 'active');

        // Test selecting the Tbody.
        $this->click($this->findKeyword(3));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody style="align: left;"><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody style="align: center;"><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody style="align: right;"><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody style="align: justify;"><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testAlignmentInTableBody()


    /**
     * Test different alignments in table footer.
     *
     * @return void
     */
    public function testAlignmentInTableFooter()
    {
        // Test clicking in word
        $this->click($this->findKeyword(3));
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td  style="text-align: left;" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td style="text-align: center;" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td style="text-align: right;" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td style="text-align: justify;" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test select a word
        $this->click($this->findKeyword(4));
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td style="text-align: left;" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td style="text-align: center;" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td style="text-align: right;" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td style="text-align: justify;" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test selecting the cell.
        $this->click($this->findKeyword(4));
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('justifyBlock', 'active');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td style="text-align: left;" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td style="text-align: center;" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td style="text-align: right;" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td style="text-align: justify;" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove the justification for further testing
        $this->clickTopToolbarButton('justifyBlock', 'active');

        // Test selecting the Row.
        $this->click($this->findKeyword(4));
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td style="text-align: left;" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3" style="text-align: center;">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3" style="text-align: right;">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3" style="text-align: justify;">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove the justification for further testing
        $this->clickTopToolbarButton('justifyBlock', 'active');

        // Test selecting the Tfoot.
        $this->click($this->findKeyword(4));
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('justifyLeft');
        $this->clickTopToolbarButton('justifyLeft');
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3" style="text-align: left;">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyCenter');
        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Center align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3" style="text-align: center;">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyRight');
        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3" style="text-align: right;">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('justifyBlock');
        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Block align icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3" style="text-align: justify;">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testAlignmentInTableFooter()


    /**
     * Test different formats in a header row.
     *
     * @return void
     */
    public function testFormatsInHeaderRow()
    {
        // Test clicking in word
        $this->click($this->findKeyword(2));
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'active', TRUE), 'P icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><p>Col2 %2%</p></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><div>Col2 %2%</div></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><blockquote><p>Col2 %2%</p></blockquote></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'active', TRUE), 'Pre icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><pre>Col2 %2%</pre></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove the Pre section for further testing
        $this->clickTopToolbarButton('PRE', 'active', TRUE);
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'Pre icon should not be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test select a word - you should only be able to select div
        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('formats');
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'disabled', TRUE), 'Pre icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'disabled', TRUE), 'Quote icon should be disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 <div>%2%</div></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove the Div section for further testing
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should not be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test selecting the Header and using top toolbar
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><p>Col2 %2%</p></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo the changes and apply Div
        $this->clickTopToolbarButton('historyUndo');
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><div>Col2 %2%</div></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo the changes and apply Quote
        $this->clickTopToolbarButton('historyUndo');
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><blockquote><p>Col2 %2%</p></blockquote></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo the changes and apply Pre
        $this->clickTopToolbarButton('historyUndo');
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><pre>Col2 %2%</pre></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove the Pre section for further testing
        $this->clickTopToolbarButton('historyUndo');

        // Test selecting the Header and using inline toolbar
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('formats');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><p>Col2 %2%</p></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply div
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('formats');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><div>Col2 %2%</div></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply quote
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('formats');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><blockquote><p>Col2 %2%</p></blockquote></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply pre
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('formats');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th><pre>Col2 %2%</pre></th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testFormatsInHeaderRow()


    /**
     * Test different formats in a table body.
     *
     * @return void
     */
    public function testFormatsInTableBody()
    {
        // Test clicking in word
        $this->click($this->findKeyword(4));
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'active', TRUE), 'P icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><p>sapien vel %4%</p></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><div>sapien vel %4%</div></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><blockquote><p>sapien vel %4%</p></blockquote></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'active', TRUE), 'Pre icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><pre>sapien vel %4%</pre></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove the Pre section for further testing
        $this->clickTopToolbarButton('PRE', 'active', TRUE);
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'Pre icon should not be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test select a word - you should only be able to select div
        $this->click($this->findKeyword(3));
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('formats');
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'disabled', TRUE), 'Pre icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'disabled', TRUE), 'Quote icon should be disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel <div>%4%</div></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove the Div section for further testing
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertTrue($this->topToolbarButtonExists('DIV', NULL, TRUE), 'Div icon should not be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test selecting the Cell and using top toolbar.
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><p>sapien vel %4%</p></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply div
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><div>sapien vel %4%</div></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply quote
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><blockquote><p>sapien vel %4%</p></blockquote></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply pre
        $this->clickTopToolbarButton('historyUndo');
        sleep(1);
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><pre>sapien vel %4%</pre></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove the Pre section for further testing
        $this->keyDown('Key.CMD + z');
        sleep(1);

        // Test selecting the Cell and using inline toolbar
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('formats');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><p>sapien vel %4%</p></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply div
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('formats');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><div>sapien vel %4%</div></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply quote
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('formats');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><blockquote><p>sapien vel %4%</p></blockquote></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply pre
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('formats');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td><pre>sapien vel %4%</pre></td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testFormatsInTableBody()


    /**
     * Test different formats in a table footer.
     *
     * @return void
     */
    public function testFormatsInTableFooter()
    {
        // Test clicking in word
        $this->click($this->findKeyword(3));
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('P', 'active', TRUE), 'P icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><p>Note: this is the table footer %3%</p></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('DIV', 'active', TRUE), 'Div icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><div>Note: this is the table footer %3%</div></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'active', TRUE), 'Quote icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><blockquote><p>Note: this is the table footer %3%</p></blockquote></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'active', TRUE), 'Pre icon should be active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><pre>Note: this is the table footer %3%</pre></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove the Pre section for further testing
        $this->clickTopToolbarButton('PRE', 'active', TRUE);

        // Test select a word - you should only be able to select div
        $this->click($this->findKeyword(4));
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('formats');
        $this->assertTrue($this->topToolbarButtonExists('P', 'disabled', TRUE), 'P icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('PRE', 'disabled', TRUE), 'Pre icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('Quote', 'disabled', TRUE), 'Quote icon should be disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer <div>%3%</div></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove the Div section for further testing
        $this->clickTopToolbarButton('DIV', 'active', TRUE);

        // Test selecting the Cell and using top toolbar
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><p>Note: this is the table footer %3%</p></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply div
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><div>Note: this is the table footer %3%</div></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply quote
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><blockquote><p>Note: this is the table footer %3%</p></blockquote></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply pre
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><pre>Note: this is the table footer %3%</pre></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Remove the Pre section for further testing
        $this->keyDown('Key.CMD + z');
        sleep(1);

        // Test selecting the Cell and using inline toolbar
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('formats');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><p>Note: this is the table footer %3%</p></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply div
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('formats');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><div>Note: this is the table footer %3%</div></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply quote
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('formats');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><blockquote><p>Note: this is the table footer %3%</p></blockquote></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Undo and apply pre
        $this->keyDown('Key.CMD + z');
        sleep(1);
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('formats');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3"><pre>Note: this is the table footer %3%</pre></td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testFormatsInTableFooter()


    /**
     * Test applying and removing anchors in a caption in a table using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingAnchorsInCaptionUsingInlineToolbar()
    {
        // Test applying to a word
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <span id="test">%1%</span></caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the whole caption
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption id="test"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingAnchorsInCaptionUsingInlineToolbar()


    /**
     * Test applying and removing anchors in a caption in a table using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingAnchorsInCaptionUsingTopToolbar()
    {
        // Test applying to a word
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <span id="test">%1%</span></caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the whole caption
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption id="test"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingAnchorsInCaptionUsingTopToolbar()


    /**
     * Test applying and editing anchors and ids in a header section in a table using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndEditingAnchorsAndIdsInHeaderSectionUsingInlineToolbar()
    {
        // Test applying an anchor to a word
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 <span id="test">%2%</span></th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test removing an anchor from a word
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying anchor to the row
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr id="test"><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test removing anchor from the row
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying anchor to the thead
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead id="test"><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test removing the anchor from the thead
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the id of the header cell
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->type('test123');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" id="test"><caption><strong>Table 1.2:</strong> The table caption text XAX</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="test123">Col2 XBX</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3" headers="test123 testr1c1 testr1c3">Note: this is the table footer XCX</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="test123">sapien vel XDX</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td colspan="2" headers="test123 testr1c3">purus neque luctus<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test clearing the id for a header cell so it reverts back to the table id
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndEditingAnchorsAndIdsInHeaderSectionUsingInlineToolbar()


    /**
     * Test applying and editing anchors and ids in a header section in a table using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndEditingAnchorsAndIdsInHeaderSectionUsingTopToolbar()
    {
        // Test applying an anchor to a word
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 <span id="test">%2%</span></th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test removing an anchor from a word
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying anchor to the row
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr id="test"><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test removing anchor from the row
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying anchor to the thead
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead id="test"><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test removing the anchor from the thead
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the id of the header cell
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->type('test123');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" id="test"><caption><strong>Table 1.2:</strong> The table caption text XAX</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="test123">Col2 XBX</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3" headers="test123 testr1c1 testr1c3">Note: this is the table footer XCX</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="test123">sapien vel XDX</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td colspan="2" headers="test123 testr1c3">purus neque luctus<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test clearing the id for a header cell so it reverts back to the table id
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndEditingAnchorsAndIdsInHeaderSectionUsingTopToolbar()


    /**
     * Test applying and removing anchors in the body section of a table using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingAnchorsInBodySectionUsingInlineToolbar()
    {
        // Test applying to a word
        $this->selectKeyword(4);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel <span id="test">%4%</span></td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the cell
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2" id="test">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the row
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr id="test"><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the tbody
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody id="test"><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(2));
        sleep(1);
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingAnchorsInBodySectionUsingInlineToolbar()


    /**
     * Test applying and removing anchors in the body section of a table using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingAnchorsInBodySectionUsingTopToolbar()
    {
        // Test applying to a word
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel <span id="test">%4%</span></td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the cell
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2" id="test">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the row
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr id="test"><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the tbody
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody id="test"><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(2));
        sleep(1);
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingAnchorsInBodySectionUsingTopToolbar()


    /**
     * Test applying and editing anchors in a footer of a table using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingAnchorsInFooterUsingInlineToolbar()
    {
        // Test applying an anchor to a word
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer <span id="test">%3%</span></td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the cell
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3" id="test">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the row
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr id="test"><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the tfoot
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot id="test"><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingAnchorsInFooterUsingInlineToolbar()


    /**
     * Test applying and removing anchors in a footer of a table using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingAnchorsInFooterUsingTopToolbar()
    {
        // Test applying to a word
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer <span id="test">%3%</span></td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the cell
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3" id="test">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the row
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr id="test"><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the tfoot
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot id="test"><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingAnchorsInFooterUsingTopToolbar()


    /**
     * Test editing the table id using the inline toolbar.
     *
     * @return void
     */
    public function testEditingTheTableIdUsingInlineToolbar()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->type('test123');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" id="test123"><caption><strong>Table 1.2:</strong> The table caption text XAX</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 XBX</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3" headers="testr1c1 testr1c2 testr1c3">Note: this is the table footer XCX</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel XDX</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td colspan="2" headers="testr1c2 testr1c3">purus neque luctus<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testEditingTheTableIdUsingInlineToolbar()


     /**
     * Test editing the table id using the top toolbar.
     *
     * @return void
     */
    public function testEditingTheTableIdUsingTopToolbar()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->type('test123');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" id="test123"><caption><strong>Table 1.2:</strong> The table caption text XAX</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 XBX</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3" headers="testr1c1 testr1c2 testr1c3">Note: this is the table footer XCX</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel XDX</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td colspan="2" headers="testr1c2 testr1c3">purus neque luctus<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testEditingTheTableIdUsingTopToolbar()


}//end class

?>
