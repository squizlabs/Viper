<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_ColumnUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Test that correct column icons appear in the inline toolbar.
     *
     * @return void
     */
    public function testColumnToolIconsCorrect()
    {
        $this->showTools(0, 'col');

        $this->assertTrue($this->exists($this->getImg('col_tools.png')));

    }//end testColumnToolIconsCorrect()


    /**
     * Test adding a new table without headers and then adding new columns.
     *
     * @return void
     */
    public function testAddingAndDeletingColumnsInANewTableWithoutHeaders()
    {
        $textLoc = $this->find('IPSUM');
        
        $this->insertTableWithNoHeaders();

        $this->showTools(2, 'col');

        //Add a new column after the first column of the table
        $this->click($this->find($this->getImg('icon_insertColAfter.png'), NULL, 0.83));
        $this->click($textLoc);

        $this->execJS('rmTableHeaders(0,true)');
        $this->execJS('rmTableHeaders(1,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');
        
        //Add a new column before the first column of the table
        $this->showTools(2, 'col');
        $this->click($this->find($this->getImg('icon_insertColBefore.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

        //Delete the column
        $this->showTools(2, 'col');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');
        
        
    }//end testAddingAndDeletingColumnsInANewTableWithoutHeaders()
    

    /**
     * Test adding a new table with left headers and then adding new columns.
     *
     * @return void
     */
    public function testAddingAndDeletingColumnsInANewTableWithLeftHeaders()
    {
        $textLoc = $this->find('IPSUM');
        
        $this->insertTableWithLeftHeaders();

        $this->showTools(1, 'col');

        //Add a new column after a column in the table
        $this->click($this->find($this->getImg('icon_insertColBefore.png'), NULL, 0.83));
        
        $this->click($textLoc);

        $this->execJS('rmTableHeaders(0,true)');
        $this->execJS('rmTableHeaders(1,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');
        
        //Add a new column before the first column of the table
        $this->showTools(0, 'col');
        $this->click($this->find($this->getImg('icon_insertColAfter.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

        //Delete the column
        $this->showTools(1, 'col');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');
        
        
    }//end testAddingAndDeletingColumnsInANewTableWithLeftHeaders()
    

    /**
     * Test adding a new table with top headers and then adding new columns.
     *
     * @return void
     */
    public function testAddingAndDeletingColumnsInANewTableWithTopHeaders()
    {
        $textLoc = $this->find('IPSUM');
        
        $this->insertTable();

        $this->showTools(2, 'col');

        //Add a new column after the first column of the table
        $this->click($this->find($this->getImg('icon_insertColAfter.png'), NULL, 0.83));
        $this->click($textLoc);

        $this->execJS('rmTableHeaders(0,true)');
        $this->execJS('rmTableHeaders(1,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');
        
        //Add a new column before the first column of the table
        $this->showTools(0, 'col');
        $this->click($this->find($this->getImg('icon_insertColBefore.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

        //Delete the column
        $this->showTools(1, 'col');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');
        
    }//end testAddingAndDeletingColumnsInANewTableWithTopHeaders()
        

    /**
     * Test adding a new table with both headers and then adding new columns.
     *
     * @return void
     */
    public function testAddingAndDeletingColumnsInANewTableWithBothHeaders()
    {
        $textLoc = $this->find('IPSUM');
        
        $this->insertTableWithBothHeaders();

        $this->showTools(1, 'col');

        //Add a new column after a column in the table
        $this->click($this->find($this->getImg('icon_insertColBefore.png'), NULL, 0.83));
        
        $this->click($textLoc);

        $this->execJS('rmTableHeaders(0,true)');
        $this->execJS('rmTableHeaders(1,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');
        
        //Add a new column before the first column of the table
        $this->showTools(0, 'col');
        $this->click($this->find($this->getImg('icon_insertColAfter.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

        //Delete the column
        $this->showTools(1, 'col');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');
        
    }//end testAddingAndDeletingColumnsInANewTableWithBothHeaders()
    
    
    /**
     * Test that the 'By Genders' colspan changes to three when you add a new column and goes back to two when you delete a new column.
     *
     * @return void
     */
    public function testColspanChangesWhenNewColumnAdded()
    {
        $this->showTools(5, 'col');

        $this->click($this->find($this->getImg('icon_insertColAfter.png'), NULL, 0.83));
        $this->click($this->find($this->getImg('icon_insertColBefore.png'), NULL, 0.83));
        
        $this->click($this->find('IPSUM'));

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td>&nbsp;</td><td style="width: 100px;" colspan="3">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>&nbsp;</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');
        
        $this->showTools(8, 'col');
        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td>&nbsp;</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');
        
    }//end testColspanChangesWhenNewColumnAdded()
    

    /**
     * Test that the 'By Gender' colspan changes when you delete the last column from the table.
     *
     * @return void
     */
    public function testColspanChangesWhenYouDeleteTheLastColumn()
    {
        $this->showTools(6, 'col');

        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->click($this->find('IPSUM'));
         
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');
        

    }//end testColspanChangesWhenYouDeleteTheLastColumn()
      

    /**
     * Test that the 'By Gender' colspan changes when you delete the first column of the merged cell.
     *
     * @return void
     */
    public function testColspanChangesWhenYouDeleteTheFirstColumnOfMergedCell()
    {
        $this->showTools(5, 'col');

        $this->click($this->find($this->getImg('icon_trash.png'), NULL, 0.83));
        $this->click($this->find('IPSUM'));
        
        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');
        

    }//end testColspanChangesWhenYouDeleteTheFirstColumnOfMergedCell()
    
    
}//end class

?>
