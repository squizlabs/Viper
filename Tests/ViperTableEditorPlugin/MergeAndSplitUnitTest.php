<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperTableEditorPlugin_MergeAndSplitUnitTest extends AbstractViperTableEditorPluginUnitTest
{


   /**
     * Test merge and split icons in a table without headers.
     *
     * @return void
     */
    public function testMergeAndSplitIconsInTableWithoutHeaders()
    {
        $this->insertTable(1, 0);
        $this->assertMergeAndSplitIconStatuses(11, FALSE, FALSE, TRUE, FALSE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(10, FALSE, FALSE, TRUE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(9, FALSE, FALSE, TRUE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(8, FALSE, FALSE, TRUE, FALSE, FALSE, TRUE);
        $this->assertMergeAndSplitIconStatuses(7, FALSE, FALSE, TRUE, TRUE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(6, FALSE, FALSE, TRUE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(5, FALSE, FALSE, TRUE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(4, FALSE, FALSE, TRUE, TRUE, FALSE, TRUE);
        $this->assertMergeAndSplitIconStatuses(3, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(2, FALSE, FALSE, FALSE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(1, FALSE, FALSE, FALSE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(0, FALSE, FALSE, FALSE, TRUE, FALSE, TRUE);

    }//end testMergeAndSplitIconsInTableWithoutHeaders()


   /**
     * Test merge and split icons in a table with left headers.
     *
     * @return void
     */
    public function testMergeAndSplitIconsInTableWithLeftHeaders()
    {
        $this->insertTable(1, 1);
        $this->assertMergeAndSplitIconStatuses(11, FALSE, FALSE, TRUE, FALSE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(10, FALSE, FALSE, TRUE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(9, FALSE, FALSE, TRUE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(8, FALSE, FALSE, TRUE, FALSE, FALSE, TRUE);
        $this->assertMergeAndSplitIconStatuses(7, FALSE, FALSE, TRUE, TRUE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(6, FALSE, FALSE, TRUE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(5, FALSE, FALSE, TRUE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(4, FALSE, FALSE, TRUE, TRUE, FALSE, TRUE);
        $this->assertMergeAndSplitIconStatuses(3, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(2, FALSE, FALSE, FALSE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(1, FALSE, FALSE, FALSE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(0, FALSE, FALSE, FALSE, TRUE, FALSE, TRUE);

    }//end testMergeAndSplitIconsInTableWithLeftHeaders()


   /**
     * Test merge and split icons in a table with top headers.
     *
     * @return void
     */
    public function testMergeAndSplitIconsInTableWithTopHeaders()
    {
        $this->insertTable(1);
        $this->assertMergeAndSplitIconStatuses(11, FALSE, FALSE, TRUE, FALSE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(10, FALSE, FALSE, TRUE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(9, FALSE, FALSE, TRUE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(8, FALSE, FALSE, TRUE, FALSE, FALSE, TRUE);
        $this->assertMergeAndSplitIconStatuses(7, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(6, FALSE, FALSE, FALSE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(5, FALSE, FALSE, FALSE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(4, FALSE, FALSE, FALSE, TRUE, FALSE, TRUE);
        $this->assertMergeAndSplitIconStatuses(3, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(2, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(1, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(0, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE);

    }//end testMergeAndSplitIconsInTableWithTopHeaders()


   /**
     * Test merge and split icons in a table with both headers.
     *
     * @return void
     */
    public function testMergeAndSplitIconsInTableWithBothHeaders()
    {
        $this->insertTable(1, 3);
        $this->assertMergeAndSplitIconStatuses(11, FALSE, FALSE, TRUE, FALSE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(10, FALSE, FALSE, TRUE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(9, FALSE, FALSE, TRUE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(8, FALSE, FALSE, TRUE, FALSE, FALSE, TRUE);
        $this->assertMergeAndSplitIconStatuses(7, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(6, FALSE, FALSE, FALSE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(5, FALSE, FALSE, FALSE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(4, FALSE, FALSE, FALSE, TRUE, FALSE, TRUE);
        $this->assertMergeAndSplitIconStatuses(3, FALSE, FALSE, FALSE, FALSE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(2, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(1, FALSE, FALSE, FALSE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(0, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE);

    }//end testMergeAndSplitIconsInTableWithBothHeaders()


    /**
     * Test that the states of the merge and split icons are correct in a complex table.
     *
     * @return void
     */
    public function testMergeAndSplitIconStatesInComplexTable()
    {
        $this->assertMergeAndSplitIconStatuses(13, FALSE, FALSE, TRUE, FALSE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(12, FALSE, FALSE, TRUE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(11, FALSE, FALSE, TRUE, FALSE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(10, FALSE, FALSE, TRUE, FALSE, FALSE, TRUE);
        $this->assertMergeAndSplitIconStatuses(9, FALSE, FALSE, TRUE, TRUE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(8, FALSE, FALSE, TRUE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(7, FALSE, FALSE, TRUE, TRUE, TRUE, TRUE);
        $this->assertMergeAndSplitIconStatuses(6, FALSE, FALSE, FALSE, TRUE, FALSE, TRUE);
        $this->assertMergeAndSplitIconStatuses(5, FALSE, TRUE, FALSE, FALSE, FALSE, TRUE);
        $this->assertMergeAndSplitIconStatuses(4, FALSE, FALSE, FALSE, TRUE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(3, FALSE, FALSE, FALSE, TRUE, FALSE, TRUE);
        $this->assertMergeAndSplitIconStatuses(2, TRUE, FALSE, FALSE, TRUE, FALSE, FALSE);
        $this->assertMergeAndSplitIconStatuses(1, FALSE, TRUE, FALSE, TRUE, TRUE, FALSE);
        $this->assertMergeAndSplitIconStatuses(0, TRUE, TRUE, FALSE, FALSE, FALSE, TRUE);

    }//end testMergeAndSplitIconStatesInComplexTable()


    /**
     * Test that table ids are correct after merging, splitting and deleting cells.
     *
     * @return void
     */
    public function testTableIdWhenMergingSplitingAndDeletingCellsInASingleRow()
    {

        $this->insertTableWithSpecificId('test', 3, 6, 3, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th><th id="testr1c5"></th><th id="testr1c6"></th></tr></thead><tbody><tr><th id="testr2c1"></th><td headers="testr1c2 testr2c1"></td><td headers="testr1c3 testr2c1"></td><td headers="testr1c4 testr2c1"></td><td headers="testr1c5 testr2c1"></td><td headers="testr1c6 testr2c1"></td></tr><tr><th id="testr3c1"></th><td headers="testr1c2 testr3c1"></td><td headers="testr1c3 testr3c1"></td><td headers="testr1c4 testr3c1"></td><td headers="testr1c5 testr3c1"></td><td headers="testr1c6 testr3c1"></td></tr></tbody></table><p></p>');

        $this->showTools(8, 'cell');
        $this->clickMergeSplitIcon('mergeRight');
        $this->clickMergeSplitIcon('mergeRight');
        $this->clickMergeSplitIcon('mergeRight');

        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th><th id="testr1c5"></th><th id="testr1c6"></th></tr></thead><tbody><tr><th id="testr2c1"></th><td headers="testr1c2 testr2c1"></td><td colspan="4" headers="testr1c3 testr1c4 testr1c5 testr1c6 testr2c1"></td></tr><tr><th id="testr3c1"></th><td headers="testr1c2 testr3c1"></td><td headers="testr1c3 testr3c1"></td><td headers="testr1c4 testr3c1"></td><td headers="testr1c5 testr3c1"></td><td headers="testr1c6 testr3c1"></td></tr></tbody></table><p></p>');

        $this->clickMergeSplitIcon('splitVert');
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th><th id="testr1c5"></th><th id="testr1c6"></th></tr></thead><tbody><tr><th id="testr2c1"></th><td headers="testr1c2 testr2c1"></td><td colspan="3" headers="testr1c3 testr1c4 testr1c5 testr2c1"></td><td headers="testr1c6 testr2c1"></td></tr><tr><th id="testr3c1"></th><td headers="testr1c2 testr3c1"></td><td headers="testr1c3 testr3c1"></td><td headers="testr1c4 testr3c1"></td><td headers="testr1c5 testr3c1"></td><td headers="testr1c6 testr3c1"></td></tr></tbody></table><p></p>');

        $this->showTools(4, 'col');
        $this->clickButton('delete');
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th><th id="testr1c5"></th></tr></thead><tbody><tr><th id="testr2c1"></th><td headers="testr1c2 testr2c1"></td><td colspan="2" headers="testr1c3 testr1c4 testr2c1"></td><td headers="testr1c5 testr2c1"></td></tr><tr><th id="testr3c1"></th><td headers="testr1c2 testr3c1"></td><td headers="testr1c3 testr3c1"></td><td headers="testr1c4 testr3c1"></td><td headers="testr1c5 testr3c1"></td></tr></tbody></table><p></p>');

    }//end testTableIdWhenMergingSplitingAndDeletingCellsInASingleRow()


    /**
     * Test that table ids are correct after merging and splitting cells across multiple rows.
     *
     * @return void
     */
    public function testTableIdWhenMergingCellsThenSplittingVertThenHorz()
    {

        $this->insertTableWithSpecificId('test', 4, 4, 2, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr></thead><tbody><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table><p></p>');

        $this->showTools(4, 'cell');
        $this->clickMergeSplitIcon('mergeRight');
        $this->clickMergeSplitIcon('mergeDown');
        $this->clickMergeSplitIcon('mergeDown');
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr></thead><tbody><tr><td colspan="2" headers="testr1c1 testr1c2" rowspan="3"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table><p></p>');

        $this->clickMergeSplitIcon('splitVert');
        $this->clickMergeSplitIcon('splitHoriz');
        $this->clickMergeSplitIcon('splitHoriz');
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr></thead><tbody><tr><td headers="testr1c1"></td><td headers="testr1c2" rowspan="3"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table><p></p>');

    }//end testTableIdWhenMergingCellsThenSplittingVertThenHorz()


    /**
     * Test that table ids are correct after merging and splitting cells across multiple rows.
     *
     * @return void
     */
    public function testTableIdWhenMergingCellsThenSplittingHorzThenVert()
    {

        $this->insertTableWithSpecificId('test', 4, 4, 2, 1);
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr></thead><tbody><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table><p></p>');

        $this->showTools(4, 'cell');
        $this->clickMergeSplitIcon('mergeRight');
        $this->clickMergeSplitIcon('mergeDown');
        $this->clickMergeSplitIcon('mergeDown');
        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr></thead><tbody><tr><td colspan="2" headers="testr1c1 testr1c2" rowspan="3"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table><p></p>');

        $this->clickMergeSplitIcon('splitHoriz');
        $this->clickMergeSplitIcon('splitHoriz');
        $this->clickMergeSplitIcon('splitVert');

        $this->assertHTMLMatch('<p>Test %1%</p><table border="1" id="test" style="width: 100%;"><thead><tr><th id="testr1c1"></th><th id="testr1c2"></th><th id="testr1c3"></th><th id="testr1c4"></th></tr></thead><tbody><tr><td headers="testr1c1"></td><td headers="testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td colspan="2" headers="testr1c1 testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr><tr><td colspan="2" headers="testr1c1 testr1c2"></td><td headers="testr1c3"></td><td headers="testr1c4"></td></tr></tbody></table><p></p>');

    }//end testTableIdWhenMergingAndSplitingCellsAcrossMultipleRowsAndColumns()


    /**
     * Test that you can merge all columns and rows into one.
     *
     * @return void
     */
    public function testMergingAllColumnsAndRows()
    {
        $this->insertTable(1, 0);
        $this->showTools(0, 'cell');
        $this->clickMergeSplitIcon('mergeRight');
        $this->clickMergeSplitIcon('mergeRight');
        $this->clickMergeSplitIcon('mergeRight');
        $this->clickMergeSplitIcon('mergeDown');
        $this->clickMergeSplitIcon('mergeDown');

        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><td></td></tr></tbody></table><p></p>');

    }//end testMergingAllColumnsAndRows()


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplit1()
    {
        $this->insertTable(1, 0, 4, 5);

        // Check that only the merge up, merge down and merge right icons are enabled
        $this->assertMergeAndSplitIconStatuses(10, FALSE, FALSE, TRUE, TRUE, FALSE, TRUE);

        $this->clickMergeSplitIcon('mergeRight');

        // Check that the split column, merge up, merge down and merge right icons are enabled.
        $this->assertMergeAndSplitIconStatuses(10, TRUE, FALSE, TRUE, TRUE, FALSE, TRUE);

        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td colspan="2"></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(5, 'col');
        $this->clickInlineToolbarButton('addRight');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td colspan="3"></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(7, 'col');
        $this->clickInlineToolbarButton('delete');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td colspan="2"></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(14, 'col');
        $this->clickInlineToolbarButton('addRight');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%;" border="1"><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td colspan="3"></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(12, 'cell');
        $this->clickMergeSplitIcon('splitVert');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td colspan="2"></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(12, 'cell');
        $this->clickMergeSplitIcon('splitVert');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testMergeSplit1()


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplit2()
    {
        $this->insertTable(1, 0, 4, 5);

        $this->assertMergeAndSplitIconStatuses(6, FALSE, FALSE, TRUE, TRUE, TRUE, TRUE);
        $this->clickButton('mergeDown');
        $this->assertMergeAndSplitIconStatuses(6, FALSE, TRUE, TRUE, TRUE, TRUE, TRUE);

        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%; " border="1"><tbody><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td rowspan="2"></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(5, 'row');
        $this->clickInlineToolbarButton('addBelow');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%; " border="1"><tbody><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td rowspan="3"></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(5, 'row');
        $this->clickInlineToolbarButton('delete');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%; " border="1"><tbody><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td rowspan="2"></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(11, 'row');
        $this->clickInlineToolbarButton('addAbove');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%; " border="1"><tbody><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td rowspan="3"></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(6, 'cell');
        $this->clickMergeSplitIcon('splitHoriz');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td rowspan="2"></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->clickMergeSplitIcon('splitHoriz');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testMergeSplit2()


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplit3()
    {
        $this->insertTable(1, 2, 2, 3);

        // Check to see that only the merge down and merge right icons are enabled.
        $this->assertMergeAndSplitIconStatuses(0, FALSE, FALSE, FALSE, FALSE, FALSE, TRUE);

        $this->clickButton('mergeRight');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%; " border="1"><thead><tr><th colspan="2"></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->clickButton('mergeRight');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%; " border="1"><thead><tr><th colspan="3"></th></tr></thead><tbody><tr><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->clickCell(1);
        sleep(1);
        $this->showTools(0, 'col');
        $this->clickInlineToolbarButton('addRight');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%; " border="1"><thead><tr><th colspan="3"></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('addBelow');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th colspan="3"></th><th></th></tr><tr><th colspan="3"></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->clickCell(1);
        sleep(1);
        $this->showTools(2, 'cell');
        $this->clickMergeSplitIcon('splitVert');
        $this->clickMergeSplitIcon('splitVert');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th colspan="3"></th><th></th></tr><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(0, 'row');
        $this->clickInlineToolbarButton('addAbove');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th colspan="3"></th><th></th></tr><tr><th colspan="3"></th><th></th></tr><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->assertMergeAndSplitIconStatuses(2, TRUE, FALSE, TRUE, TRUE, FALSE, TRUE);

        $this->clickButton('mergeUp');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th colspan="3" rowspan="2"></th><th></th></tr><tr><th></th></tr><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(1, 'cell');
        $this->clickMergeSplitIcon('mergeDown');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th colspan="3"></th><th></th></tr><tr><th></th><th></th><th></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(0, 'cell');
        $this->clickMergeSplitIcon('mergeDown');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th colspan="3" rowspan="2"></th><th></th></tr><tr><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->showTools(0, 'cell');
        $this->clickMergeSplitIcon('splitHoriz');
        $this->clickMergeSplitIcon('splitVert');
        $this->clickMergeSplitIcon('splitVert');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><thead><tr><th></th><th></th><th></th><th></th></tr><tr><th colspan="3"></th><th></th></tr></thead><tbody><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testMergeSplit3()


    /**
     * Test that merging and splitting cells work.
     *
     * @return void
     */
    public function testMergeSplit4()
    {
        $this->insertTable(1, 0, 2, 3);

        $this->showTools(0, 'cell');
        $this->clickMergeSplitIcon('mergeRight');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><td colspan="2"></td><td></td></tr><tr><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->clickMergeSplitIcon('splitVert');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table style="width: 100%; " border="1"><tbody><tr><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->clickMergeSplitIcon('mergeDown');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><td rowspan="2"></td><td></td><td></td></tr><tr><td></td><td></td></tr></tbody></table><p></p>');

        $this->clickMergeSplitIcon('splitHoriz');
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td></tr></tbody></table><p></p>');

        $this->clickCell(1);
        $this->toggleCellHeading(0);
        $this->assertHTMLMatchNoHeaders('<p>Test %1%</p><table border="1" style="width: 100%;"><tbody><tr><th></th><td></td><td></td></tr><tr><td></td><td></td><td></td></tr></tbody></table><p></p>');

    }//end testMergeSplit4()


}//end class

?>
