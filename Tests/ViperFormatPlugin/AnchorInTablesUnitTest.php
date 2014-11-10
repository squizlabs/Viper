<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperFormatPlugin_AnchorInTablesUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Test availability of the anchor icon in the table.
     *
     * @return void
     */
    public function testAvailabilityOfAnchorIconInTable()
    {
        $this->useTest(1);

        // Check icon in a table caption
        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should be disabled');
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');

        // Check icon in table header
        $this->moveToKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should be disabled');
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the inline toolbar');
        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');

        // Check icon in table body
        $this->moveToKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should be disabled');
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');

        // Check icon in table footer
        $this->moveToKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should be disabled');
        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be enabled');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be enabled in the inline toolbar');

    }//end testAvailabilityOfFormatIconsInTableCaption()


    /**
     * Test applying and removing anchors in a caption.
     *
     * @return void
     */
    public function testApplyingAndRemovingAnchorsInCaption()
    {
        // Using the inline toolbar 
        $this->useTest(1);

        // Test applying to a word
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <span id="test">%1%</span></caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->sikuli->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the whole caption
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption id="test"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->moveToKeyword(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Using the top toolbar
        $this->useTest(1);

        // Test applying to a word
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text <span id="test">%1%</span></caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->moveToKeyword(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the whole caption
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption id="test"><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->sikuli->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingAnchorsInCaption()


    /**
     * Test applying and editing anchors and ids in a header section.
     *
     * @return void
     */
    public function testApplyingAndEditingAnchorsAndIdsInHeaderSection()
    {
        // Using inline toolbar
        $this->useTest(1);

        // Test applying an anchor to a word
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 <span id="test">%2%</span></th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test removing an anchor from a word
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying anchor to the row
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr id="test"><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test removing anchor from the row
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying anchor to the thead
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead id="test"><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test removing the anchor from the thead
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the id of the header cell
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->type('test123');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" id="test"><caption><strong>Table 1.2:</strong> The table caption text XAX</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="test123">Col2 XBX</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3" headers="test123 testr1c1 testr1c3">Note: this is the table footer XCX</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="test123">sapien vel XDX</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td colspan="2" headers="test123 testr1c3">purus neque luctus<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test clearing the id for a header cell so it reverts back to the table id
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Using top toolbar
        $this->useTest(1);

        // Test applying an anchor to a word
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 <span id="test">%2%</span></th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test removing an anchor from a word
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying anchor to the row
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr id="test"><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test removing anchor from the row
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying anchor to the thead
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead id="test"><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test removing the anchor from the thead
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test editing the id of the header cell
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->type('test123');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" id="test"><caption><strong>Table 1.2:</strong> The table caption text XAX</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="test123">Col2 XBX</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td colspan="3" headers="test123 testr1c1 testr1c3">Note: this is the table footer XCX</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="test123">sapien vel XDX</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td colspan="2" headers="test123 testr1c3">purus neque luctus<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test clearing the id for a header cell so it reverts back to the table id
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndEditingAnchorsAndIdsInHeaderSection()


    /**
     * Test applying and removing anchors in the body section of a table.
     *
     * @return void
     */
    public function testApplyingAndRemovingAnchorsInBodySection()
    {
        // Using inline toolbar
        $this->useTest(1);

        // Test applying to a word
        $this->selectKeyword(4);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel <span id="test">%4%</span></td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the cell
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2" id="test">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the row
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr id="test"><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the tbody
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody id="test"><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->sikuli->click($this->findKeyword(2));
        sleep(1);
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Using top toolbar
        $this->useTest(1);

        // Test applying to a word
        $this->selectKeyword(4);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel <span id="test">%4%</span></td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the cell
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2" id="test">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the row
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr id="test"><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the tbody
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody id="test"><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->sikuli->click($this->findKeyword(2));
        sleep(1);
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingAnchorsInBodySection()


    /**
     * Test applying and editing anchors in a footer of a table.
     *
     * @return void
     */
    public function testApplyingAndRemovingAnchorsInFooter()
    {
        // Using inline toolbar
        $this->useTest(1);

        // Test applying an anchor to a word
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer <span id="test">%3%</span></td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the cell
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3" id="test">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the row
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr id="test"><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the tfoot
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot id="test"><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Using top toolbar
        $this->useTest(1);

        // Test applying to a word
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer <span id="test">%3%</span></td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the cell
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3" id="test">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the row
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr id="test"><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Test applying to the tfoot
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot id="test"><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th id="testr1c1">Col1 Header</th><th id="testr1c2">Col2 %2%</th><th id="testr1c3">Col3 Header</th></tr></thead><tfoot><tr><td headers="testr1c1 testr1c2 testr1c3" colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2">sapien vel %4%</td><td headers="testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="testr1c1">nec porta ante</td><td headers="testr1c2 testr1c3" colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testApplyingAndRemovingAnchorsInFooter()


    /**
     * Test editing the table id.
     *
     * @return void
     */
    public function testEditingTheTableId()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('anchorID', 'active');
        sleep(1);
        $this->clearFieldValue('ID');
        sleep(1);
        $this->type('123');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="123" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% </caption><thead><tr><th id="123r1c1">Col1 Header </th><th id="123r1c2">Col2 %2% </th><th id="123r1c3">Col3 Header </th></tr></thead><tfoot><tr><td colspan="3" headers="123r1c1 123r1c2 123r1c3">Note: this is the table footer %3% </td></tr></tfoot><tbody><tr><td headers="123r1c1">nec porta ante </td><td headers="123r1c2">sapien vel %4% </td><td headers="123r1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="123r1c1">nec porta ante </td><td colspan="2" headers="123r1c2 123r1c3">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Edit id again to make sure the field was not cleared
        sleep(1);
        $this->clickField('ID');
        sleep(1);
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="123test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% </caption><thead><tr><th id="123testr1c1">Col1 Header </th><th id="123testr1c2">Col2 %2% </th><th id="123testr1c3">Col3 Header </th></tr></thead><tfoot><tr><td colspan="3" headers="123testr1c1 123testr1c2 123testr1c3">Note: this is the table footer %3% </td></tr></tfoot><tbody><tr><td headers="123testr1c1">nec porta ante </td><td headers="123testr1c2">sapien vel %4% </td><td headers="123testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="123testr1c1">nec porta ante </td><td colspan="2" headers="123testr1c2 123testr1c3">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('anchorID', 'active');
        sleep(1);
        $this->clearFieldValue('ID');
        sleep(1);
        $this->type('123');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="123" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% </caption><thead><tr><th id="123r1c1">Col1 Header </th><th id="123r1c2">Col2 %2% </th><th id="123r1c3">Col3 Header </th></tr></thead><tfoot><tr><td colspan="3" headers="123r1c1 123r1c2 123r1c3">Note: this is the table footer %3% </td></tr></tfoot><tbody><tr><td headers="123r1c1">nec porta ante </td><td headers="123r1c2">sapien vel %4% </td><td headers="123r1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="123r1c1">nec porta ante </td><td colspan="2" headers="123r1c2 123r1c3">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Edit id again to make sure the field was not cleared
        sleep(1);
        $this->clickField('ID');
        sleep(1);
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<table id="123test" border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% </caption><thead><tr><th id="123testr1c1">Col1 Header </th><th id="123testr1c2">Col2 %2% </th><th id="123testr1c3">Col3 Header </th></tr></thead><tfoot><tr><td colspan="3" headers="123testr1c1 123testr1c2 123testr1c3">Note: this is the table footer %3% </td></tr></tfoot><tbody><tr><td headers="123testr1c1">nec porta ante </td><td headers="123testr1c2">sapien vel %4% </td><td headers="123testr1c3"><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td headers="123testr1c1">nec porta ante </td><td colspan="2" headers="123testr1c2 123testr1c3">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testEditingTheTableId()


    /**
     * Test anchor icon when creating a new table.
     *
     * @return void
     */
    public function testAnchorIconInNewTable()
    {
        // Check icon when inserting a table with no header row
        $this->useTest(2);
        $this->insertTable(1, 0, 2, 2);
        $this->assertHTMLMatchNoHeaders('<p>A paragraph on the page to test tables %1%</p><table border="1" style="width:100%;"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p></p>');

        // Check the anchor icon in each cell
        $this->clickCell(0);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->clickCell(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->clickCell(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->clickCell(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));

        // Check icon when inserting a table with side header row
        $this->useTest(2);
        $this->insertTableWithSpecificId('test', 2, 2, 1, 1);
        $this->assertHTMLMatch('<p>A paragraph on the page to test tables %1%</p><table border="1" id="test" style="width:100%;"><tbody><tr><th id="testr1c1"></th><td headers="testr1c1"></td></tr><tr><th id="testr2c1"></th><td headers="testr2c1"></td></tr></tbody></table><p></p>');

        // Check the anchor icon in each cell
        $this->clickCell(0);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'));
        $this->clickCell(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->clickCell(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'));
        $this->clickCell(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));

        // Check icon when inserting a table with top header row
        $this->useTest(2);
        $this->insertTableWithSpecificId('test', 2, 2, 2, 1);
        $this->assertHTMLMatch('<p>A paragraph on the page to test tables %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th></tr></thead><tbody><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td></tr></tbody></table><p></p>');

        // Check the anchor icon in each cell
        $this->clickCell(0);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'));
        $this->clickCell(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'));
        $this->clickCell(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->clickCell(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));

        // Check icon when inserting a table with side and top header row
        $this->useTest(2);
        $this->insertTableWithSpecificId('test', 2, 2, 3, 1);
        $this->assertHTMLMatch('<p>A paragraph on the page to test tables %1%</p><table border="1" id="test" style="width:100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th></tr></thead><tbody><tr><th id="testr2c1"></th><td headers="testr1c2 testr2c1"></td></tr></tbody></table><p></p>');

        // Check the anchor icon in each cell
        $this->clickCell(0);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'));
        $this->clickCell(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'));
        $this->clickCell(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'));
        $this->clickCell(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));

    }//end testAnchorIconInNewTable()


    /**
     * Test anchor icon in header cells exisitng tables.
     *
     * @return void
     */
    public function testAnchorIconInHeaderCells()
    {
        // Check icon in table with side header
        $this->useTest(3);
        
        // Check the anchor icon in teach cell
        $this->clickCell(0);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'));
        $this->clickCell(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->clickCell(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'));
        $this->clickCell(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));

        // Check icon in table with top header
        $this->useTest(4);
        
        // Check the anchor icon in teach cell
        $this->clickCell(0);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'));
        $this->clickCell(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'));
        $this->clickCell(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->clickCell(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));

        // Check icon in table with top header
        $this->useTest(5);
        
        // Check the anchor icon in teach cell
        $this->clickCell(0);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'));
        $this->clickCell(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'));
        $this->clickCell(2);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->clickCell(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));
        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('anchorID'));

    }//end testAnchorIconInHeaderCells()

}//end class

?>
