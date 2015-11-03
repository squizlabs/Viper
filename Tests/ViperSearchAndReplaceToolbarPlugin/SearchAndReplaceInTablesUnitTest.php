<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperSearchAndReplaceToolbarPlugin_SearchAndReplaceInTablesUnitTest extends AbstractViperUnitTest
{


    /**
     * Test icon search icon states in a table caption.
     *
     * @return void
     */
    public function testSearchIconStatesInCaption()
    {
        $this->clickKeyword(1);

        $this->assertTrue($this->topToolbarButtonExists('searchReplace'), 'Search and replace icon should be enabled');

        $this->clickTopToolbarButton('searchReplace');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', 'disabled', TRUE), 'Find Next Icon should be disabled.');

        $this->type('caption');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', NULL, TRUE), 'Replace Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', NULL, TRUE), 'Replace All Icon should be enabled.');

    }//end testSearchIconStatesInCaption()


    /**
     * Test icon search icon states in a table header.
     *
     * @return void
     */
    public function testSearchIconStatesInTableHeader()
    {
        $this->clickKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('searchReplace'), 'Search and replace icon should be enabled');

        $this->clickTopToolbarButton('searchReplace');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', 'disabled', TRUE), 'Find Next Icon should be disabled.');

        $this->type('Col2');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', NULL, TRUE), 'Replace Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', NULL, TRUE), 'Replace All Icon should be enabled.');

    }//end testSearchIconStatesInTableHeader()


    /**
     * Test icon search icon states in a table footer.
     *
     * @return void
     */
    public function testSearchIconStatesInTableFooter()
    {
        $this->clickKeyword(3);

        $this->assertTrue($this->topToolbarButtonExists('searchReplace'), 'Search and replace icon should be enabled');

        $this->clickTopToolbarButton('searchReplace');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', 'disabled', TRUE), 'Find Next Icon should be disabled.');

        $this->type('footer');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', NULL, TRUE), 'Replace Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', NULL, TRUE), 'Replace All Icon should be enabled.');

    }//end testSearchIconStatesInTableFooter()


    /**
     * Test icon search icon states in a table body.
     *
     * @return void
     */
    public function testSearchIconStatesInTableBody()
    {
        $this->clickKeyword(4);

        $this->assertTrue($this->topToolbarButtonExists('searchReplace'), 'Search and replace icon should be enabled');

        $this->clickTopToolbarButton('searchReplace');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', 'disabled', TRUE), 'Find Next Icon should be disabled.');

        $this->type('porta');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', NULL, TRUE), 'Replace Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', NULL, TRUE), 'Replace All Icon should be enabled.');

    }//end testSearchIconStatesInTableBody()


    /**
     * Test replace buttons are not active when it can't find the text.
     *
     * @return void
     */
    public function testReplaceButtonsNotActive()
    {
        $this->clickKeyword(1);


        $this->clickTopToolbarButton('searchReplace');
        $this->type('blah');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

    }//end testReplaceButtonsNotActive()


    /**
     * Test that you can perform a search in a table wihtout replacing content.
     *
     * @return void
     */
    public function testSearchForContentAndEditingSearch()
    {
        $this->clickKeyword(1);

        $this->clickTopToolbarButton('searchReplace');
        $this->type('caption');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertEquals('caption', $this->getSelectedText(), 'caption was not found in the content');

        $this->clearFieldValue('Search');
        $this->type('Col3');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertEquals('Col3', $this->getSelectedText(), 'Col3 was not found in the content');

        $this->clearFieldValue('Search');
        $this->type('footer');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertEquals('footer', $this->getSelectedText(), 'footer was not found in the content');

        $this->clearFieldValue('Search');
        $this->type('porta');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->assertEquals('porta', $this->getSelectedText(), 'porta was not found in the content');

    }//end testSearchForContentAndEditingSearch()


    /**
     * Test search and replace.
     *
     * @return void
     */
    public function testSearchAndReplace()
    {
        $this->clickKeyword(1);

        $this->clickTopToolbarButton('searchReplace');
        $this->type('porta');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace', NULL, TRUE, TRUE);

        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% replace</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3% porta</td></tr></tfoot><tbody><tr><td>%4% nec porta ante</td><td>sapien vel</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace', NULL, TRUE, TRUE);

        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% replace</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3% replace</td></tr></tfoot><tbody><tr><td>%4% nec porta ante</td><td>sapien vel</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testSearchAndReplace()


    /**
     * Test that you can find content and then replace it.
     *
     * @return void
     */
    public function testFindAndThenReplace()
    {
        $this->clickKeyword(1);

        $this->clickTopToolbarButton('searchReplace');
        $this->type('porta');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);

        $this->clickField('Replace');
        $this->type('replace');
        $this->clickTopToolbarButton('Replace', NULL, TRUE, TRUE);

        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% replace</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3% porta</td></tr></tfoot><tbody><tr><td>%4% nec porta ante</td><td>sapien vel</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace', NULL, TRUE, TRUE);

        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% replace</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3% replace</td></tr></tfoot><tbody><tr><td>%4% nec porta ante</td><td>sapien vel</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testFindAndThenReplace()


    /**
     * Test search and replace all.
     *
     * @return void
     */
    public function testSearchAndReplaceAll()
    {
        $this->clickKeyword(1);

        $this->clickTopToolbarButton('searchReplace');
        $this->type('porta');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace All', NULL, TRUE);

        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% replace</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3% replace</td></tr></tfoot><tbody><tr><td>%4% nec replace ante</td><td>sapien vel</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec replace ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testSearchAndReplaceAll()


    /**
     * Test undo after you perform a replace.
     *
     * @return void
     */
    public function testUndoAfterReplace()
    {
        $this->clickKeyword(1);

        $this->clickTopToolbarButton('searchReplace');
        $this->type('porta');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace', NULL, TRUE, TRUE);

        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% replace</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3% porta</td></tr></tfoot><tbody><tr><td>%4% nec porta ante</td><td>sapien vel</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% porta</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3% porta</td></tr></tfoot><tbody><tr><td>%4% nec porta ante</td><td>sapien vel</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% replace</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3% porta</td></tr></tfoot><tbody><tr><td>%4% nec porta ante</td><td>sapien vel</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testUndoAfterReplace()


    /**
     * Test that you can undo after you perform a replace all.
     *
     * @return void
     */
    public function testUndoAfterReplaceAll()
    {
        $this->clickKeyword(1);

        $this->clickTopToolbarButton('searchReplace');
        $this->type('porta');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace All', NULL, TRUE);

        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% replace</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3% replace</td></tr></tfoot><tbody><tr><td>%4% nec replace ante</td><td>sapien vel</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec replace ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% porta</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3% porta</td></tr></tfoot><tbody><tr><td>%4% nec porta ante</td><td>sapien vel</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% replace</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3% replace</td></tr></tfoot><tbody><tr><td>%4% nec replace ante</td><td>sapien vel</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec replace ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testSearchAndReplaceAll()



    /**
     * Test performing a search and replace, closing the fields and opening them again.
     *
     * @return void
     */
    public function testSearchAndReplaceAfterClosingFields()
    {
        $this->clickKeyword(1);

        $this->clickTopToolbarButton('searchReplace');
        $this->type('porta');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('replace');
        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace', NULL, TRUE);

        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% replace</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3% porta</td></tr></tfoot><tbody><tr><td>%4% nec porta ante</td><td>sapien vel</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Close the search fields
        $this->clickTopToolbarButton('searchReplace', 'selected');
        $this->clickKeyword(1);

        // Open the search fields again and make sure only the Find Next button is enabled
        $this->clickTopToolbarButton('searchReplace');
        $this->assertTrue($this->topToolbarButtonExists('Find Next', NULL, TRUE), 'Find Next Icon should be enabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace', 'disabled', TRUE), 'Replace Icon should be disabled.');
        $this->assertTrue($this->topToolbarButtonExists('Replace All', 'disabled', TRUE), 'Replace All Icon should be disabled.');

        $this->clickTopToolbarButton('Find Next', NULL, TRUE);
        $this->clickTopToolbarButton('Replace', NULL, TRUE);

        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1% replace</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3% replace</td></tr></tfoot><tbody><tr><td>%4% nec porta ante</td><td>sapien vel</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testSearchAndReplaceAfterClosingFields()

}//end class

?>
