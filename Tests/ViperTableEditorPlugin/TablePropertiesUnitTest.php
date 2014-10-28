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
        $this->showTools(0, 'table');

        $this->sikuli->mouseMoveOffset(-100, -100);
        $this->assertTrue($this->inlineToolbarButtonExists('tableSettings', 'selected'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'));
        $this->assertTrue($this->inlineToolbarButtonExists('delete'));
        $this->assertTrue($this->fieldExists('Width'));
        $this->assertTrue($this->fieldExists('Summary'));

        $this->clickCell(7);
        $this->clickCell(7);
        $this->clickTopToolbarButton('table', 'active');
        $this->sikuli->click($this->getToolsButton('table'));
        $this->sikuli->mouseMoveOffset(-100, -100);

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
        $this->showTools(0, 'table');
        $this->clickField('Summary');
        $this->type('Summary');
        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 100%;" summary="Summary"><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

        $this->clickField('Summary');
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 100%;"><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

    }//end testAddingTableSummary()


   /**
     * Test that the top toolbar icons are available after you add a summary.
     *
     * @return void
     */
    public function testTopToolbarIconAfterAddingSummary()
    {
        $this->showTools(0, 'table');
        $this->clickField('Summary');
        $this->type('Summary');
        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->clickCell(7);
        $this->clickCell(7);
        $this->assertTrue($this->topToolbarButtonExists('table', 'active'), 'Table icon should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listOL'), 'Ordered list should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL'), 'Unordered list should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon should be available in the top toolbar');

    }//end testTopToolbarIconAfterAddingSummary()


   /**
     * Test changing the width of a table.
     *
     * @return void
     */
    public function testChangingTableWidth()
    {
        $this->showTools(0, 'table');
        $this->clearFieldValue('Width');
        $this->type('50%');
        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 50%;"><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

        $this->clearFieldValue('Width');
        $this->type('200px');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 200px;"><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

        $this->clearFieldValue('Width');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table border="1"><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

    }//end testChangingTableWidth()


   /**
     * Test changing the width of the table and clicking in another cell doesn't cause the viper toolbar to disappear.
     *
     * @return void
     */
    public function testChangingTableWidthAndClickingInCell()
    {
        $this->showTools(0, 'table');
        $this->clearFieldValue('Width');
        $this->type('50%');
        $this->clickButton('Apply Changes', NULL, TRUE);

        // Check that the top toolbar exists when you click in another cell.
        $this->clickCell(1);
        $this->assertTrue($this->topToolbarButtonExists('Bold'), 'Bold icon does not appear in top toolbar');

    }//end testChangingTableWidthAndClickingInCell()


    /**
     * Test that you can add and remove a class from a table.
     *
     * @return void
     */
    public function testAddingClassToTable()
    {
        // Apply a class to the table and press update changes
        $this->showTools(0, 'table');
        $this->clickInlineToolbarButton('cssClass');
        $this->clickField('Class');
        $this->type('test');
        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 100%;" class="test"><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

        // Remove the class from the table and click Apply Changes
        $this->clearFieldValue('Class');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 100%;"><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

        // Apply a class to the table and press enter
        $this->clickField('Class');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 100%;" class="abc"><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

        // Remove the class from the table and press enter
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 100%;"><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

    }//end testAddingClassToTable()


    /**
     * Test deleting a table and checking the position of the cursor.
     *
     * @return void
     */
    public function testDeleteingATable()
    {
        $this->showTools(0, 'table');
        $this->clickInlineToolbarButton('delete');
        $this->assertHTMLMatch('');

        $this->type('new content');
        $this->assertHTMLMatch('<p>new content</p>');

    }//end testDeleteingATable()


    /**
     * Test that you can delete a table.
     *
     * @return void
     */
    public function testDeleteingATableAndUndoandRedo()
    {
        $this->showTools(0, 'table');
        $this->clickInlineToolbarButton('delete');
        $this->assertHTMLMatch('');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 100%;"><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('');

    }//end testDeleteingATableAndUndoandRedo()


    /**
     * Test that you can add and remove a caption to a table.
     *
     * @return void
     */
    public function testCaptionsForTables()
    {
        //Apply the caption and click update changes
        $this->showTools(0, 'table');
        $this->clickField('Use Caption');
        $this->clickButton('Apply Changes', NULL, TRUE);
        usleep(50000);
        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 100%;"><caption></caption><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

        //Remove the caption and click update changes
        $this->clickField('Use Caption');
        $this->clickButton('Apply Changes', NULL, TRUE);
        usleep(50000);
        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 100%;"><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

        //Apply the caption and press enter
        $this->clickField('Use Caption');
        $this->sikuli->keyDown('Key.ENTER');
        usleep(50000);
        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 100%;"><caption></caption><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

        //Remove the caption and press enter
        sleep(1);
        $this->clickField('Use Caption');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        usleep(50000);
        $this->assertHTMLMatchNoHeaders('<table border="1" style="width: 100%;"><tbody><tr><th colspan="2" rowspan="2">Survey</th><th rowspan="2">All Genders</th><th colspan="2">By Gender</th></tr><tr><th>Males</th><th>Females</th></tr><tr><th rowspan="2">All Regions</th><th>N</th><td>3</td><td>1</td><td>2</td></tr><tr><th>S</th><td>3</td><td>1</td><td>2</td></tr></tbody></table>');

    }//end testCaptionsForTables()


}//end class

?>
