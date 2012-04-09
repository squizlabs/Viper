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
        
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_createTable_active.png');
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
        
        $this->click($this->find('IPSUM'));
        
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3" summary="Summary"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU TiuT XabcX Mnu</td><td>WOW</td><td>            <ul><li>purus IPSUM luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec PORTA ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

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
        
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_createTable_active.png'), 'Table icon should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists(dirname(dirname(__FILE__)).'/ViperListPlugin/Images/toolbarIcon_orderedList_active.png'), 'Ordered list should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists(dirname(dirname(__FILE__)).'/ViperCoreStylesPlugin/Images/toolbarIcon_bold.png'), 'Bold icon should be available in the top toolbar');

    }//end testTopToolbarIconAfterAddingSummary()
    
    
}//end class

?>
