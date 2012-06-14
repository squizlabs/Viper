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
        $this->insertTable();

        $this->showTools(0, 'row');
        $this->assertTrue($this->inlineToolbarButtonExists('tableSettings', 'selected'));
        $this->assertTrue($this->inlineToolbarButtonExists('addAbove'));
        $this->assertTrue($this->inlineToolbarButtonExists('addBelow'));
        $this->assertTrue($this->inlineToolbarButtonExists('mergeUp', 'disabled'));
        $this->assertTrue($this->inlineToolbarButtonExists('mergeDown'));
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass'));
        $this->assertTrue($this->inlineToolbarButtonExists('delete'));

        $this->clickTopToolbarButton('table', 'active');
        $this->click($this->getToolsButton('row'));
        sleep(1);

        $this->assertTrue($this->inlineToolbarButtonExists('tableSettings', 'selected'));
        $this->assertTrue($this->inlineToolbarButtonExists('addAbove'));
        $this->assertTrue($this->inlineToolbarButtonExists('addBelow'));
        $this->assertTrue($this->inlineToolbarButtonExists('mergeUp', 'disabled'));
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
        $textLoc = $this->findKeyword(2);

        $this->insertTable();

        // Apply a class to the first row and click click Update Changes
        $this->showTools(0, 'row');
        sleep(1);

        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr class="test"><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Apply a class to the third row and press enter
        $this->showTools(9, 'row');
        sleep(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('abc');
        $this->keyDown('Key.ENTER');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr class="test"><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr class="abc"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Remove the class from the first row and click Update Changes
        $this->showTools(0, 'row');
        sleep(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');

        $this->clickButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr class="abc"><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Remove the class from the third row and press enter
        $this->showTools(9, 'row');
        sleep(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->keyDown('Key.ENTER');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

    }//end testAddingClassToRow()


    /**
     * Test adding a new table without headers and then changing the settings of rows.
     *
     * @return void
     */
    public function testRowsInANewTableWithoutHeaders()
    {
        $textLoc = $this->findKeyword(2);

        $this->insertTableWithNoHeaders();

        $this->clickCell(8);
        usleep(300);
        $this->type('Three');
        $this->clickCell(4);
        usleep(300);
        $this->type('Two');
        $this->clickCell(0);
        usleep(300);
        $this->type('One');

        $this->showTools(0, 'row');

        // Add a new row after the first row of the table
        $this->clickButton('addBelow');
        sleep(1);

        // Add a new row before the first row of the table
        $this->clickButton('addAbove');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;One</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Delete the third row
        $this->clickCell(0);
        $this->showTools(10, 'row');
        $this->clickButton('delete');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;One</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row up
        $this->showTools(4, 'row');
        $this->clickButton('mergeUp');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;One</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row down
        $this->showTools(6, 'row');
        $this->clickButton('mergeDown');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;One</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the first row to be a header column
        $this->showTools(0, 'row');
        $this->clickField('Heading');

        sleep(1);
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;One</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

    }//end testRowsInANewTableWithoutHeaders()


    /**
     * Test adding a new table with left headers and then adding new rows.
     *
     * @return void
     */
    public function testRowsInANewTableWithLeftHeaders()
    {
        $textLoc = $this->findKeyword(2);
        $this->insertTableWithLeftHeaders();

        $this->clickCell(8);
        usleep(300);
        $this->type('Three');
        $this->clickCell(4);
        usleep(300);
        $this->type('Two');
        $this->clickCell(0);
        usleep(300);
        $this->type('One');

        $this->showTools(0, 'row');

        // Add a new row after the first row of the table
        $this->clickButton('addBelow');
        sleep(1);

        // Add a new row before the first row of the table
        $this->clickButton('addAbove');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>One&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Delete the third row
        $this->clickCell(0);
        $this->showTools(10, 'row');
        $this->clickButton('delete');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>One&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row up
        $this->showTools(4, 'row');
        $this->clickButton('mergeUp');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row down
        $this->clickCell(0);
        $this->showTools(6, 'row');
        $this->clickButton('mergeDown');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the first row to be a header row
        $this->showTools(0, 'row');
        $this->clickField('Heading');

        sleep(1);
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

    }//end testRowsInANewTableWithLeftHeaders()


    /**
     * Test adding a new table with left headers and then adding new rows.
     *
     * @return void
     */
    public function testRowsInANewTableWithTopHeaders()
    {
        $textLoc = $this->findKeyword(2);
        $this->insertTable();

        $this->clickCell(8);
        usleep(300);
        $this->type('Three');
        $this->clickCell(4);
        usleep(300);
        $this->type('Two');
        $this->clickCell(0);
        usleep(300);
        $this->type('One');

        $this->showTools(0, 'row');

        // Add a new row after the first row of the table
        $this->clickButton('addBelow');
        sleep(1);

        // Add a new row before the third row of the table
        $this->showTools(9, 'row');
        $this->clickButton('addAbove');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Delete the second row
        $this->clickCell(0);
        $this->showTools(5, 'row');
        $this->clickButton('delete');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row up
        $this->showTools(6, 'row');
        $this->clickButton('mergeUp');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row down
        $this->clickCell(0);
        $this->showTools(5, 'row');
        $this->clickButton('mergeDown');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Change the first row to be a header row
        $this->showTools(0, 'row');
        $this->clickField('Heading');

        sleep(1);
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

         // Change the third row not to be a header row
        $this->showTools(10, 'row');
        $this->clickField('Heading');

        sleep(1);
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><td>&nbsp;Two</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>One&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;Three</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');


    }//end testRowsInANewTableWithTopHeaders()


    /**
     * Test adding a new table with both headers and then adding new rows.
     *
     * @return void
     */
    public function testRowsInANewTableWithBothHeaders()
    {
        $textLoc = $this->findKeyword(2);
        $this->insertTableWithBothHeaders();

        $this->clickCell(8);
        usleep(300);
        $this->type('Three');
        $this->clickCell(4);
        usleep(300);
        $this->type('Two');
        $this->clickCell(0);
        usleep(300);
        $this->type('One');

        $this->showTools(0, 'row');

        // Add a new row after the first row of the table
        $this->clickButton('addBelow');
        sleep(1);

        // Add a new row before the third row of the table
        $this->showTools(9, 'row');
        $this->clickButton('addAbove');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Delete the third row
        $this->clickCell(0);
        $this->showTools(9, 'row');
        $this->clickButton('delete');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row up
        $this->showTools(6, 'row');
        $this->clickButton('mergeUp');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

        // Move the second row down
        $this->clickCell(0);
        $this->showTools(5, 'row');
        $this->clickButton('mergeDown');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>One&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');

         // Change the third row not to be a header row
        //$this->showTools(10, 'row');
        $this->clickField('Heading');

        sleep(1);
        $this->clickButton('Update Changes', NULL, TRUE);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1%</p><table style="width: 100%;" border="1"><tbody><tr><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th><th>&nbsp;</th></tr><tr><th>Two&nbsp;</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>One&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><th>&nbsp;Three</th><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></tbody></table><p>dolor</p>');


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

        $this->click($this->findKeyword(2));

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1% dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td colspan="2">&nbsp;</td><td>&nbsp;</td><td colspan="2">&nbsp;</td></tr><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="3">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td colspan="2">&nbsp;</td><td colspan="2">&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

        $this->showTools(6, 'row');
        $this->clickButton('delete');
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1% dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td colspan="2">&nbsp;</td><td>&nbsp;</td><td colspan="2">&nbsp;</td></tr><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td rowspan="2">All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

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

        $this->click($this->findKeyword(2));

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1% dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>All Genders</td><td>Male</td><td>Females</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

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

        $this->click($this->findKeyword(2));

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>%2% %1% dolor</p><p>sit amet <strong>consectetur</strong></p><table style="width: 300px;" border="1" cellspacing="2" cellpadding="2"><tbody><tr><td style="width: 100px;" colspan="2">&nbsp;Survey&nbsp;</td><td>All Genders</td><td style="width: 100px;" colspan="2">By Gender&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');


    }//end testRowspanChangesWhenYouDeleteTheLastRow()


    /**
     * Test the move icons for a row.
     *
     * @return void
     */
    public function testMoveIconsInTheRowToolbar()
    {
        $this->insertTable();
        $this->showTools(0, 'row');

        $this->assertTrue($this->inlineToolbarButtonExists('mergeDown'), 'Move row down should be active');
        $this->assertTrue($this->inlineToolbarButtonExists('mergeUp', 'disabled'), 'Move row up should not be active');

        $this->showTools(10, 'row');
        $this->assertTrue($this->inlineToolbarButtonExists('mergeDown', 'disabled'), 'Move row down should not be active');
        $this->assertTrue($this->inlineToolbarButtonExists('mergeUp'), 'Move row up should be active');

        $this->showTools(5, 'row');
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
        $this->selectText('dolor');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->execJS('insTable(3,4, 2, "test")');
        sleep(2);

        $this->assertHTMLMatch('<p>%2% %1% dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4"></td></tr></tbody></table>');

        $this->showTools(0, 'row');
        $this->clickField('Heading');

        sleep(1);
        $this->clickButton('Update Changes', NULL, TRUE);


        $this->assertHTMLMatch('<p>%2% %1% dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td></td></tr></tbody></table>');

        $this->clickField('Heading');

        sleep(1);
        $this->clickButton('Update Changes', NULL, TRUE);


        $this->assertHTMLMatch('<p>%2% %1% dolor</p><p>&nbsp;</p><table style="width: 100%;" id="test" border="1"><tbody><tr><th id="testr1c1">&nbsp;</th><th id="testr1c2">&nbsp;</th><th id="testr1c3">&nbsp;</th><th id="testr1c4">&nbsp;</th></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4">&nbsp;</td></tr><tr><td headers="testr1c1">&nbsp;</td><td headers="testr1c2">&nbsp;</td><td headers="testr1c3">&nbsp;</td><td headers="testr1c4"></td></tr></tbody></table>');

    }//end testHeaderIdsRemovedWhenYouRemoveHeaderRow()


}//end class

?>
