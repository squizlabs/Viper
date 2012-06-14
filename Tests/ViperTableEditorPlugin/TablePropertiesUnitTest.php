<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_TablePropertiesUnitTest extends AbstractViperTableEditorPluginUnitTest
{


   /**
     * Test that correct table icons appear in the toolbar.
     *
     * @return void
     */
    public function testTableToolIconsCorrect()
    {
        $this->click($this->findKeyword(1));

        $this->showTools(0, 'table');

        $this->assertTrue($this->inlineToolbarButtonExists('tableSettings', 'selected'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'));
        $this->assertTrue($this->inlineToolbarButtonExists('delete'));

        $this->assertTrue($this->fieldExists('Width'));
        $this->assertTrue($this->fieldExists('Summary'));

        $this->click($this->findKeyword(2));
        $this->clickTopToolbarButton('table', 'active');
        sleep(1);
        $tableIcon = $this->findButton('table');
        $this->click($tableIcon);
        sleep(1);

        $this->assertTrue($this->inlineToolbarButtonExists('tableSettings', 'selected'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'));
        $this->assertTrue($this->inlineToolbarButtonExists('delete'));

        $this->assertTrue($this->fieldExists('Width'));
        $this->assertTrue($this->fieldExists('Summary'));

    }//end testTableToolIconsCorrect()


   /**
     * Test adding a summary to a table.
     *
     * @return void
     */
    public function testAddingTableSummary()
    {
        $this->click($this->findKeyword(1));
        $this->showTools(0, 'table');

        $this->clickField('Summary');
        $this->type('Summary');
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" summary="Summary"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clearFieldValue('Summary');
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->click($this->findKeyword(2));

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testAddingTableSummary()


   /**
     * Test that the top toolbar icons are available after you add a summary.
     *
     * @return void
     */
    public function testTopToolbarIconAfterAddingSummary()
    {
        $this->click($this->findKeyword(1));
        $this->showTools(0, 'table');

        $this->clickField('Summary');
        $this->type('Summary');
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(2));

        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Table icon should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listOL'), 'Ordered list should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'active'), 'Unordered list should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should be available in the top toolbar');

    }//end testTopToolbarIconAfterAddingSummary()


   /**
     * Test changing the width of a table.
     *
     * @return void
     */
    public function testChangingTableWidth()
    {
        $this->click($this->findKeyword(1));
        $this->showTools(0, 'table');

        $this->clickField('Width');
        $this->type('50%');

        $this->clickButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" style="width: 50%;"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clearFieldValue('Width');

        $this->type('200px');
        $this->keyDown('Key.ENTER');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" style="width: 200px;"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->clearFieldValue('Width');
        $this->keyDown('Key.ENTER');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testChangingTableWidth()


    /**
     * Test that you can add and remove a class from a table.
     *
     * @return void
     */
    public function testAddingClassToTable()
    {
        $this->click($this->findKeyword(1));

        // Apply a class to the table and press update changes
        $this->showTools(0, 'table');
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->clickField('Class');
        $this->type('test');
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" class="test"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Remove the class from the first row and click Update Changes
        $this->showTools(0, 'table');
        sleep(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        sleep(1);
        $this->clearFieldValue('Class');
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Apply a class to the table and press update changes
        $this->showTools(0, 'table');
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->clickField('Class');
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" class="abc"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Remove the class from the table and press enter
        $this->showTools(0, 'table');
        sleep(1);
        $this->clickInlineToolbarButton('cssClass', TRUE);
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testAddingClassToTable()


    /**
     * Test that you can delete a table.
     *
     * @return void
     */
    public function testDeleteingATable()
    {
        $this->click($this->findKeyword(1));

        $this->showTools(0, 'table');
        sleep(1);
        $this->clickInlineToolbarButton('delete');
        $this->assertHTMLMatch('');

        $this->clickTopToolbarButton('historyUndo');
        sleep(1);
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testDeleteingATable()


    /**
     * Test that you can add and remove a caption to a table.
     *
     * @return void
     */
    public function testCaptionsForTables()
    {
        $this->click($this->findKeyword(1));

        //Remove the caption and click update changes
        $this->showTools(0, 'table');
        sleep(1);
        $this->clickField('Use Caption');
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        //Apply the caption and click update changes
        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(1));
        $this->showTools(0, 'table');
        sleep(1);
        $this->clickField('Use Caption');
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption>&nbsp;</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        //Remove the caption and press enter
        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(1));
        $this->showTools(0, 'table');
        sleep(1);
        $this->clickField('Use Caption');
        $this->keyDown('Key.ENTER');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        //Apply the caption and press enter
        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(1));
        $this->showTools(0, 'table');
        sleep(1);
        $this->clickField('Use Caption');
        $this->keyDown('Key.ENTER');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption>&nbsp;</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>%1%</td><td>            <ul><li>purus %2% luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testCaptionsForTables()


}//end class

?>
