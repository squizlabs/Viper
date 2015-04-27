<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_RowUnitTest extends AbstractViperTableEditorPluginUnitTest
{


    /**
     * Test that correct row icons appear in the toolbar.
     *
     * @return void
     */
    public function testRowToolIconsCorrect()
    {
        $this->insertTable(1);

        $this->showTools(4, 'row');
        $this->assertTrue($this->inlineToolbarButtonExists('tableSettings', 'selected'));
        $this->assertTrue($this->inlineToolbarButtonExists('addAbove'));
        $this->assertTrue($this->inlineToolbarButtonExists('addBelow'));
        $this->assertTrue($this->inlineToolbarButtonExists('mergeUp'));
        $this->assertTrue($this->inlineToolbarButtonExists('mergeDown'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'));
        $this->assertTrue($this->inlineToolbarButtonExists('delete'));

        $this->clickTopToolbarButton('table', 'active');
        $this->sikuli->click($this->getToolsButton('row'));
        sleep(1);

        $this->assertTrue($this->inlineToolbarButtonExists('tableSettings', 'selected'));
        $this->assertTrue($this->inlineToolbarButtonExists('addAbove'));
        $this->assertTrue($this->inlineToolbarButtonExists('addBelow'));
        $this->assertTrue($this->inlineToolbarButtonExists('mergeUp'));
        $this->assertTrue($this->inlineToolbarButtonExists('mergeDown'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'));
        $this->assertTrue($this->inlineToolbarButtonExists('delete'));

    }//end testRowToolIconsCorrect()


    /**
     * Test that you can add and remove a class from a row.
     *
     * @return void
     */
    public function testAddingClassToRow()
    {
        $this->insertTable(1);

        // Apply a class to the first row and click click Apply Changes
        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr class="test"><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Apply a class to the third row and press enter
        $this->showTools(9, 'row');
        $this->clickInlineToolbarButton('cssClass');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><thead><tr class="test"><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr class="abc"><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Remove the class from the first row and click Apply Changes
        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr class="abc"><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Remove the class from the third row and press enter
        $this->showTools(9, 'row');
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testAddingClassToRow()


    /**
     * Test adding a new table without headers and then changing the settings of rows.
     *
     * @return void
     */
    public function testRowsInANewTableWithoutHeaders()
    {

        $this->insertTable(1, 0);

        $this->clickCell(8);
        $this->type('Three');
        $this->clickCell(4);
        $this->type('Two');
        $this->clickCell(0);
        $this->type('One');

        $this->showTools(0, 'row');

        // Add a new row after the first row of the table
        $this->clickButton('addBelow');
        // Add a new row before the first row of the table
        $this->clickButton('addAbove');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td>One</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td>Two</td><td></td><td></td><td></td></tr><tr><td>Three</td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Delete the third row
        $this->clickCell(0);
        sleep(1);
        $this->showTools(10, 'row');
        $this->clickButton('delete');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td>One</td><td></td><td></td><td></td></tr><tr><td>Two</td><td></td><td></td><td></td></tr><tr><td>Three</td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Move the second row up
        $this->showTools(4, 'row');
        $this->clickButton('mergeUp');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><td>One</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td>Two</td><td></td><td></td><td></td></tr><tr><td>Three</td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Move the second row down
        $this->showTools(6, 'row');
        $this->clickButton('mergeDown');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><td>One</td><td></td><td></td><td></td></tr><tr><td>Two</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td>Three</td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Change the first row to be a header column
        $this->showTools(0, 'row');
        $this->clickField('Heading');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th>One</th><th></th><th></th><th></th></tr></thead><tbody><tr><td>Two</td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td>Three</td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testRowsInANewTableWithoutHeaders()


    /**
     * Test adding a new table with left headers and then adding new rows.
     *
     * @return void
     */
    public function testRowsInANewTableWithLeftHeaders()
    {
        $this->insertTable(1, 1);

        $this->clickCell(8);
        $this->type('Three');
        $this->clickCell(4);
        $this->type('Two');
        $this->clickCell(0);
        $this->type('One');

        $this->showTools(0, 'row');

        // Add a new row after the first row of the table
        $this->clickButton('addBelow');
        // Add a new row before the first row of the table
        $this->clickButton('addAbove');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th>One</th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th>Two</th><td></td><td></td><td></td></tr><tr><th>Three</th><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Delete the third row
        $this->clickCell(0);
        sleep(1);
        $this->showTools(10, 'row');
        $this->clickButton('delete');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th>One</th><td></td><td></td><td></td></tr><tr><th>Two</th><td></td><td></td><td></td></tr><tr><th>Three</th><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Move the second row up
        $this->showTools(4, 'row');
        $this->clickButton('mergeUp');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>One</th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th>Two</th><td></td><td></td><td></td></tr><tr><th>Three</th><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Move the second row down
        $this->clickCell(0);
        sleep(1);
        $this->showTools(6, 'row');
        $this->clickButton('mergeDown');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>One</th><td></td><td></td><td></td></tr><tr><th>Two</th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th>Three</th><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Change the first row to be a header row
        $this->showTools(0, 'row');
        $this->clickField('Heading');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th>One</th><th></th><th></th><th></th></tr></thead><tbody><tr><th>Two</th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th>Three</th><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testRowsInANewTableWithLeftHeaders()


    /**
     * Test adding a new table with left headers and then adding new rows.
     *
     * @return void
     */
    public function testRowsInANewTableWithTopHeaders()
    {
        $this->insertTable(1);

        $this->clickCell(8);
        $this->type('Three');
        $this->clickCell(4);
        $this->type('Two');
        $this->clickCell(0);
        $this->type('One');

        $this->showTools(0, 'row');

        // Add a new row after the first row of the table
        $this->clickButton('addBelow');
        // Add a new row before the third row of the table
        $this->showTools(9, 'row');
        $this->clickButton('addAbove');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><thead><tr><th>One</th><th></th><th></th><th></th></tr><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td>Two</td><td></td><td></td><td></td></tr><tr><td>Three</td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Delete the second row
        $this->clickCell(0);
        sleep(1);
        $this->showTools(5, 'row');
        $this->clickButton('delete');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><thead><tr><th>One</th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td>Two</td><td></td><td></td><td></td></tr><tr><td>Three</td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Move the second row up
        $this->showTools(6, 'row');
        $this->clickButton('mergeUp');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><td></td><td></td><td></td><td></td></tr><tr><th>One</th><th></th><th></th><th></th></tr></thead><tbody><tr><td>Two</td><td></td><td></td><td></td></tr><tr><td>Three</td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Move the second row down
        $this->clickCell(0);
        sleep(1);
        $this->showTools(5, 'row');
        $this->clickButton('mergeDown');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><td></td><td></td><td></td><td></td></tr></thead><tbody><tr><td>Two</td><td></td><td></td><td></td></tr><tr><th>One</th><th></th><th></th><th></th></tr><tr><td>Three</td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Change the first row to be a header row
        $this->showTools(0, 'row');
        $this->clickField('Heading');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td>Two</td><td></td><td></td><td></td></tr><tr><th>One</th><th></th><th></th><th></th></tr><tr><td>Three</td><td></td><td></td><td></td></tr></tbody></table><p></p>');

         // Change the third row not to be a header row
        $this->showTools(10, 'row');
        $this->clickField('Heading');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td>Two</td><td></td><td></td><td></td></tr><tr><td>One</td><td></td><td></td><td></td></tr><tr><td>Three</td><td></td><td></td><td></td></tr></tbody></table><p></p>');


    }//end testRowsInANewTableWithTopHeaders()


    /**
     * Test adding a new table with both headers and then adding new rows.
     *
     * @return void
     */
    public function testRowsInANewTableWithBothHeaders()
    {
        $this->insertTable(1, 3);

        $this->clickCell(8);
        $this->type('Three');
        $this->clickCell(4);
        $this->type('Two');
        $this->clickCell(0);
        $this->type('One');

        $this->showTools(0, 'row');

        // Add a new row after the first row of the table
        $this->clickButton('addBelow');
        // Add a new row before the third row of the table
        $this->showTools(9, 'row');
        $this->clickButton('addAbove');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th>One</th><th></th><th></th><th></th></tr><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th>Two</th><td></td><td></td><td></td></tr><tr><th>Three</th><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Delete the third row
        $this->clickCell(0);
        sleep(1);
        $this->showTools(9, 'row');
        $this->clickButton('delete');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th>One</th><th></th><th></th><th></th></tr><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><th>Two</th><td></td><td></td><td></td></tr><tr><th>Three</th><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Move the second row up
        $this->showTools(6, 'row');
        $this->clickButton('mergeUp');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr><tr><th>One</th><th></th><th></th><th></th></tr></thead><tbody><tr><th>Two</th><td></td><td></td><td></td></tr><tr><th>Three</th><td></td><td></td><td></td></tr></tbody></table><p></p>');

        // Move the second row down
        $this->clickCell(0);
        sleep(1);
        $this->showTools(5, 'row');
        $this->clickButton('mergeDown');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><th>Two</th><td></td><td></td><td></td></tr><tr><th>One</th><th></th><th></th><th></th></tr><tr><th>Three</th><td></td><td></td><td></td></tr></tbody></table><p></p>');

         // Change the third row not to be a header row
        //$this->showTools(10, 'row');
        $this->clickField('Heading');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><th>Two</th><td></td><td></td><td></td></tr><tr><td>One</td><td></td><td></td><td></td></tr><tr><th>Three</th><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testRowsInANewTableWithBothHeaders()


    /**
     * Test that the 'All Genders' rowspan changes to three when you add a new row and goes back to two when you delete a new row.
     *
     * @return void
     */
    public function testRowspanChangesWhenNewRowAdded()
    {
        $this->showTools(0, 'row');
        $this->clickButton('addBelow');
        $this->clickButton('addAbove');

        $this->assertHTMLMatchNoHeaders('<table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td colspan="2"></td><td></td><td colspan="2"></td></tr><tr><td style="width: 100px;" colspan="2">Survey</td><td rowspan="3">All Genders</td><td style="width: 100px;" colspan="2">By Gender</td></tr><tr><td colspan="2"></td><td colspan="2"></td></tr><tr><td></td><td></td><td>Male</td><td>Females</td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr></tbody></table>');

        $this->clickCell(1);
        sleep(1);
        $this->showTools(6, 'row');
        $this->clickButton('delete');
        $this->assertHTMLMatchNoHeaders('<table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td colspan="2"></td><td></td><td colspan="2"></td></tr><tr><td style="width: 100px;" colspan="2">Survey</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender</td></tr><tr><td></td><td></td><td>Male</td><td>Females</td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr></tbody></table>');

    }//end testRowspanChangesWhenNewRowAdded()


    /**
     * Test that the 'All Genders' rowspan changes when you delete the first row from it.
     *
     * @return void
     */
    public function testRowspanChangesWhenYouDeleteTheFirstRow()
    {
        $this->showTools(2, 'row');
        $this->clickButton('delete');
        $this->assertHTMLMatchNoHeaders('<table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td></td><td></td><td>All Genders</td><td>Male</td><td>Females</td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr></tbody></table>');

    }//end testRowspanChangesWhenYouDeleteTheLastRow()


    /**
     * Test that the 'All Genders' rowspan changes when you delete the last row from it.
     *
     * @return void
     */
    public function testRowspanChangesWhenYouDeleteTheLastRow()
    {
        $this->showTools(5, 'row');
        $this->clickButton('delete');
        $this->assertHTMLMatchNoHeaders('<table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">Survey</td><td>All Genders</td><td style="width: 100px;" colspan="2">By Gender</td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr></tbody></table>');

    }//end testRowspanChangesWhenYouDeleteTheLastRow()


    /**
     * Test the move icons for a row.
     *
     * @return void
     */
    public function testMoveIconsInTheRowToolbar()
    {
        $this->insertTable(1);
        sleep(1);
        $this->showTools(0, 'row');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('mergeDown'), 'Move row down should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('mergeUp', 'disabled'), 'Move row up should not be active');

        $this->showTools(10, 'row');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('mergeDown', 'disabled'), 'Move row down should not be active');
        $this->assertTrue($this->inlineToolbarButtonExists('mergeUp'), 'Move row up should be active');

        $this->showTools(5, 'row');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('mergeDown'), 'Move row down should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('mergeUp'), 'Move row up should be active');

    }//end testMoveIconsInTheRowToolbar()


    /**
     * Test that header ids are removed from the table when you remove a header row.
     *
     * @return void
     */
    public function testHeaderIdsRemovedWhenYouRemoveHeaderRow()
    {
        $this->insertTableWithSpecificId('test', 3, 4, 2, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr></thead><tbody><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table><p></p>');

        $this->showTools(0, 'row');
        $this->clickField('Heading');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(0, 'row');
        $this->clickField('Heading');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr></thead><tbody><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table><p></p>');

    }//end testHeaderIdsRemovedWhenYouRemoveHeaderRow()


        /**
     * Test that undo/redo is only one event for converting header cell to a normal cell.
     *
     * @return void
     */
    public function testUndoRedoForHeaderRowToNormalRowConversion()
    {
        $this->insertTableWithSpecificId('test', 3, 4, 2, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr></thead><tbody><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table><p></p>');

        $this->showTools(0, 'row');
        $this->clickField('Heading');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->clickTopToolbarButton('historyUndo');

        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr></thead><tbody><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table><p></p>');

        $this->clickTopToolbarButton('historyRedo');

        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testUndoRedoForHeaderRowToNormalRowConversion()


    /**
     * Tests that inline toolbar stays open after you move a row.
     *
     * @return void
     */
    public function testInlineToolbarStaysOpenAfterMovingRow()
    {
        $this->insertTable(1);

        // Test moving a row up
        $this->showTools(7, 'row');
        $this->clickInlineToolbarButton('mergeUp');
        $this->assertTrue($this->inlineToolbarButtonExists('addAbove'));

        // Test moving a row down
        $this->showTools(5, 'row');
        $this->clickInlineToolbarButton('mergeDown');
        $this->assertTrue($this->inlineToolbarButtonExists('addAbove'));

    }//end testInlineToolbarStaysOpenAfterMovingRow()

}//end class

?>
