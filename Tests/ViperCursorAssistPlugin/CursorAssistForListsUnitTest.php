<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperCursorAssistPlugin_CursorAssistForListsUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Test that the cursor assit line appears above the list and that you can click it.
     *
     * @return void
     */
    public function testCursorAssistAboveList()
    {
        // Check cursor assist line above an unordered list
        $this->useTest(1);
        $this->clickKeyword(1);
        $this->moveMouseToElement('ul', 'top');
        sleep(2);

        // Check to see if the cursor assit line appears above the list
        $this->assertTrue($this->isCursorAssistLineVisible('ul', 'top'));

        // Click the cursor assit line and add new content above list
        $this->clickCursorAssistLine();
        $this->type('New content above the list');
        $this->assertHTMLMatch('<p>New content above the list</p><ul><li>%1% item 1</li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');

        // Check cursor assist line above an ordered list
        $this->useTest(2);
        $this->clickKeyword(1);
        $this->moveMouseToElement('ol', 'top');
        sleep(2);

        // Check to see if the cursor assit line appears above the list
        $this->assertTrue($this->isCursorAssistLineVisible('ol', 'top'));

        // Click the cursor assit line and add new content above list
        $this->clickCursorAssistLine();
        $this->type('New content above the list');
        $this->assertHTMLMatch('<p>New content above the list</p><ol><li>%1% item 1</li><li>item 2</li><li>item 3</li><li>item 4</li></ol>');

    }//end testCursorAssistAboveList()


    /**
     * Test that the cursor assit line appears below the list and that you can click it.
     *
     * @return void
     */
    public function testCursorAssistBelowList()
    {
        // Check cursor assist line below an unordered list
        $this->useTest(1);
        $this->clickKeyword(1);
        $this->moveMouseToElement('ul', 'bottom');

        // Check to see if the cursor assit line appears below the list
        $this->assertTrue($this->isCursorAssistLineVisible('ul', 'bottom'));

        // Click the cursor assit line and add new content below list
        $this->clickCursorAssistLine();
        $this->type('New content below the list');
        $this->assertHTMLMatch('<ul><li>%1% item 1</li><li>item 2</li><li>item 3</li><li>item 4</li></ul><p>New content below the list</p>');

        // Check cursor assist line below an ordered list
        $this->useTest(2);
        $this->clickKeyword(1);
        $this->moveMouseToElement('ol', 'bottom');

        // Check to see if the cursor assit line appears below the list
        $this->assertTrue($this->isCursorAssistLineVisible('ol', 'bottom'));

        // Click the cursor assit line and add new content below list
        $this->clickCursorAssistLine();
        $this->type('New content below the list');
        $this->assertHTMLMatch('<ol><li>%1% item 1</li><li>item 2</li><li>item 3</li><li>item 4</li></ol><p>New content below the list</p>');

    }//end testCursorAssistBelowList()


    /**
     * Test that the cursor assit line for a list in a table.
     *
     * @return void
     */
    public function testCursorAssistForListInTable()
    {
        // Check cursor assist line below the list
        $this->useTest(3);
        $this->clickKeyword(1);
        $this->moveMouseToElement('ul', 'bottom');

        // Check to see if the cursor assit line appears below the list
        $this->assertTrue($this->isCursorAssistLineVisible('ul', 'bottom'));

        // Click the cursor assit line and add new content below list
        $this->clickCursorAssistLine();
        $this->type('New content below the list');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul><p>New content below the list</p></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        // Check cursor assist line above the list
        $this->useTest(3);
        $this->clickKeyword(1);
        $this->moveMouseToElement('ul', 'top');

        // Check to see if the cursor assit line appears above the list
        $this->assertTrue($this->isCursorAssistLineVisible('ul', 'top'));

        // Click the cursor assit line and add new content above list
        $this->clickCursorAssistLine();
        $this->type('New content above the list');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text %1%</caption><thead><tr><th>Col1 Header</th><th>Col2 %2%</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">Note: this is the table footer %3%</td></tr></tfoot><tbody><tr><td>nec porta ante</td><td>sapien vel %4%</td><td><p>New content above the list</p><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testCursorAssistForListInTable()

}//end class

?>
