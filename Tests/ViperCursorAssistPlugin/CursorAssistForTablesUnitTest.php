<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperCursorAssistPlugin_CursorAssistForTablesUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Test that the cursor assit line appears above the table and that you can click it.
     *
     * @return void
     */
    public function testCursorAssistAboveTable()
    {
        $this->selectKeyword(3);

        $this->moveMouseToElement('table', 'top');

        // Check to see if the cursor assit line appears above the table
        $this->assertTrue($this->isCursorAssistLineVisible('table', 'top'));

        // Click the cursor assit line and add new content above table
        $this->clickCursorAssistLine();
        $this->type('New content above table');

        $this->assertHTMLMatchNoHeaders('<p>New content above table</p><table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testCursorAssistAboveTable()


    /**
     * Test that the cursor assit line appears below the table and that you can click it.
     *
     * @return void
     */
    public function testCursorAssistBelowTable()
    {
        $this->selectKeyword(3);

        $this->moveMouseToElement('table', 'bottom');

        // Check to see if the cursor assit line appears above the table
        $this->assertTrue($this->isCursorAssistLineVisible('table', 'bottom'));

        // Click the cursor assit line and add new content above table
        $this->clickCursorAssistLine();
        $this->type('New content below table');

        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table><p>New content below table</p>');

    }//end testCursorAssistBelowTable() 


    /**
     * Test that the cursor assit line disappears when you use the table icons.
     *
     * @return void
     */
    public function testCursorAssistWhenUsingTableTools()
    {
        // Show tools for the last row
        $this->showTools(3, 'row');

        // Check to see if the cursor assit line does not appear below the table
        $this->assertFalse($this->isCursorAssistLineVisible('table', 'bottom'));

    }//end testCursorAssistWhenUsingTableTools() 

}//end class

?>
