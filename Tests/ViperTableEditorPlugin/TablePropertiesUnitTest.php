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
        $this->click($this->find('WoW'));

        $this->showTools(0, 'table');
        $this->assertTrue($this->exists($this->getImg('table_tools.png')));

        $this->click($this->find('IPSUM'));
        $this->click($this->find('IPSUM'));
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_createTable_active.png');
        sleep(1);
        $tableIcon = $this->find($this->getImg('icon_tools_table.png'));
        $this->click($tableIcon);
        sleep(1);

        $this->assertTrue($this->exists($this->getImg('table_tools.png')));

    }//end testTableToolIconsCorrect()


   /**
     * Test adding a summary to a table.
     *
     * @return void
     */
    public function testAddingTableSummary()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->click($this->find('WoW'));
        $this->showTools(0, 'table');

        $summaryField = $this->find($this->getImg('input_summary.png'));
        $this->click($summaryField);
        $this->type('Summary');
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" summary="Summary"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $this->click($this->find('WoW'));
        $this->showTools(0, 'table');

        $deleteIcon = $this->find($this->getImg('icon_deleteValue.png'));
        $this->click($deleteIcon);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);

        $this->click($this->find('IPSUM'));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testAddingTableSummary()


   /**
     * Test that the top toolbar icons are available after you add a summary.
     *
     * @return void
     */
    public function testTopToolbarIconAfterAddingSummary()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->click($this->find('WoW'));
        $this->showTools(0, 'table');

        $summaryField = $this->find($this->getImg('input_summary.png'));
        $this->click($summaryField);
        $this->type('Summary');
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);

        $this->click($this->find('IPSUM'));
        $this->click($this->find('IPSUM'));

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_createTable_active.png'), 'Table icon should be active in the top toolbar');
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
        $dir = dirname(__FILE__).'/Images/';

        $this->click($this->find('WoW'));
        $this->showTools(0, 'table');

        $widthField = $this->find($this->getImg('input_width.png'));
        $this->click($widthField);
        $this->type('50%');

        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" style="width: 50%;"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $deleteIcon = $this->find($this->getImg('icon_deleteValue.png'));
        $this->click($deleteIcon);

        $this->click($widthField);
        $this->type('200px');
        $this->keyDown('Key.ENTER');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" style="width: 200px;"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        $deleteIcon = $this->find($this->getImg('icon_deleteValue.png'));
        $this->click($deleteIcon);
        $this->keyDown('Key.ENTER');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testChangingTableWidth()


    /**
     * Test that you can add and remove a class from a table.
     *
     * @return void
     */
    public function testAddingClassToTable()
    {
        $this->click($this->find('WoW'));

        // Apply a class to the table and press update changes
        $this->showTools(0, 'table');
        sleep(1);
        $classField = $this->find(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class.png');
        $this->click($classField);
        $this->type('test');
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" class="test"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Remove the class from the first row and click Update Changes
        $this->showTools(0, 'table');
        sleep(1);
        $classField = $this->find(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class_active.png');
        $this->click($classField);
        sleep(1);
        $deleteIcon = $this->find(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_delete_icon.png');
        $this->click($deleteIcon);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');


        // Apply a class to the table and press update changes
        $this->showTools(0, 'table');
        sleep(1);
        $classField = $this->find(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class.png');
        $this->click($classField);
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" class="abc"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Remove the class from the table and press enter
        $this->showTools(0, 'table');
        sleep(1);
        $classField = $this->find(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class_active.png');
        $this->click($classField);
        $deleteIcon = $this->find(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_delete_icon.png');
        $this->click($deleteIcon);
        $this->keyDown('Key.ENTER');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testAddingClassToTable()


    /**
     * Test that you can delete a table.
     *
     * @return void
     */
    public function testDeleteingATable()
    {
        $this->click($this->find('WoW'));

        $this->showTools(0, 'table');
        sleep(1);
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->assertHTMLMatch('');

        $this->click(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');
        sleep(1);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testDeleteingATable()


    /**
     * Test that you can add and remove a caption to a table.
     *
     * @return void
     */
    public function testCaptionsForTables()
    {
        $this->click($this->find('WoW'));

        //Remove the caption and click update changes
        $this->showTools(0, 'table');
        sleep(1);
        $isCaptionField = $this->find($this->getImg('icon_isCaption_active.png'));
        $this->click($isCaptionField);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        //Apply the caption and click update changes
        $this->click($this->find('IPSUM'));
        $this->click($this->find('WoW'));
        $this->showTools(0, 'table');
        sleep(1);
        $isCaptionField = $this->find($this->getImg('icon_isCaption.png'));
        $this->click($isCaptionField);
        $updateChanges = $this->find($this->getImg('icon_updateChanges.png'));
        $this->click($updateChanges);
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption>&nbsp;</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        //Remove the caption and press enter
        $this->click($this->find('IPSUM'));
        $this->click($this->find('WoW'));
        $this->showTools(0, 'table');
        sleep(1);
        $isCaptionField = $this->find($this->getImg('icon_isCaption_active.png'));
        $this->click($isCaptionField);
        $this->keyDown('Key.ENTER');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        //Apply the caption and press enter
        $this->click($this->find('IPSUM'));
        $this->click($this->find('WoW'));
        $this->showTools(0, 'table');
        sleep(1);
        $isCaptionField = $this->find($this->getImg('icon_isCaption.png'));
        $this->click($isCaptionField);
        $this->keyDown('Key.ENTER');
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption>&nbsp;</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testCaptionsForTables()


}//end class

?>
