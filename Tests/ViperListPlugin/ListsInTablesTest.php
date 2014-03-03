<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_ListsInTablesTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test a list can be created and removed from inside a table cell and by clicking the list icon
     *
     * @return void
     */
    public function testCreatingAListInACellAndRemovingIt()
    {
        $this->useTest(1);

        //Test unordered list
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ul><li>Cell 1 %1%</li></ul></td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        //Test creating ordered list
        $this->selectKeyword(4);

        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td><ol><li>Cell 5 %4%</li></ol></td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testCreatingAListInACellAndRemovingIt()


    /**
     * Test creating a list in a table and clicking undo.
     *
     * @return void
     */
    public function testCreateListAndClickingUndo()
    {
        $this->useTest(1);

        //Test unordered list
        $this->moveToKeyword(1);

        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ul><li>Cell 1 %1%</li></ul></td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ul><li>Cell 1 %1%</li></ul></td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        
        //Test ordered list
        $this->selectKeyword(4);

        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ul><li>Cell 1 %1%</li></ul></td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td><ol><li>Cell 5 %4%</li></ol></td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ul><li>Cell 1 %1%</li></ul></td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ul><li>Cell 1 %1%</li></ul></td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td><ol><li>Cell 5 %4%</li></ol></td><td>Cell 6</td></tr></tbody></table>');
        
    }//end testCreateListAndClickingUndo()


    /**
     * Test a list can be indented and outdented using the top toolbar icons.
     *
     * @return void
     */
    public function testIndentingAndOutdentingAListItemUsingTopToolbar()
    {
        $this->useTest(1);

        //Test unordered list
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1<ul><li>item 2 %2%</li></ul></li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        //Test ordered list
        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1<ol><li>item 2 %3%</li></ol></li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li></ol><p>item 2 %3%</p></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testIndentingAndOutdentingAListItemUsingTopToolbar()


    /**
     * Test a list can be indented and outdented using the inline toolbar icons.
     *
     * @return void
     */
    public function testIndentingAndOutdentingAListItemUsingInlineToolbar()
    {
        $this->useTest(1);

        //Test unordered list
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1<ul><li>item 2 %2%</li></ul></li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        //Test ordered list
        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1<ol><li>item 2 %3%</li></ol></li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li></ol><p>item 2 %3%</p></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testIndentingAndOutdentingAListItemUsingInlineToolbar()


    /**
     * Test a list can be indented and outdented using keyboard shortcuts.
     *
     * @return void
     */
    public function testIndentingAndOutdentingAListItemUsingShortcuts()
    {

        $this->useTest(1);

        //Test unordered list
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1<ul><li>item 2 %2%</li></ul></li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        //Test ordered list
        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1<ol><li>item 2 %3%</li></ol></li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li></ol><p>item 2 %3%</p></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testIndentingAndOutdentingAListItemUsingShortcuts()


    /**
     * Test a list item is removed when using the list icons.
     *
     * @return void
     */
    public function testRemovingAListTemUsingTheListIcons()
    {
        $this->useTest(1);

        //Test unordered list
        $this->moveToKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickTopToolbarButton('listUL', 'active');

        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><p>item 1</p><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        //Test ordered list
        $this->moveToKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickTopToolbarButton('listOL', 'active');

        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><p>item 1</p><p>item 2 %2%</p></td></tr><tr><td><p>item 1</p><p>item 2 %3%</p></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testRemovingAListTemUsingTheListIcons()


    /**
     * Test a list is removed using the outdent icon in the inline toolbar
     *
     * @return void
     */
    public function testRemovingListUsingOutdentIconInInlineToolbar()
    {
        $this->useTest(1);

        //Test unordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><p>item 1</p><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        //Test ordered list
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><p>item 1</p><p>item 2 %2%</p></td></tr><tr><td><p>item 1</p><p>item 2 %3%</p></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testRemovingListUsingOutdentIconInInlineToolbar()


    /**
     * Test a list is removed using the outdent icon in the top toolbar.
     *
     * @return void
     */
    public function testRemovingListUsingOutdentIconInTopToolbar()
    {
        $this->useTest(1);

        //Test unordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><p>item 1</p><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        //Test ordered list
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><p>item 1</p><p>item 2 %2%</p></td></tr><tr><td><p>item 1</p><p>item 2 %3%</p></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testRemovingListUsingOutdentIconInTopToolbar()


    /**
     * Test a removing a list and then clicking undo.
     *
     * @return void
     */
    public function testRemovingListAndClickingUndo()
    {
        $this->useTest(1);

        //Test unordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(5);

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><p>item 1</p><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><p>item 1</p><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');

        //Test ordered list
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(5);

        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><p>item 1</p><p>item 2 %2%</p></td></tr><tr><td><p>item 1</p><p>item 2 %3%</p></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><p>item 1</p><p>item 2 %2%</p></td></tr><tr><td><ol><li>item 1</li><li>item 2 %3%</li></ol></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td><p>item 1</p><p>item 2 %2%</p></td></tr><tr><td><p>item 1</p><p>item 2 %3%</p></td><td>Cell 5 %4%</td><td>Cell 6</td></tr></tbody></table>');
    
    }//end testRemovingListAndClickingUndo()


    /**
    * Test list tools in a table.
    *
    * @return void
    */
    public function testListToolsIconsInATable()
    {
        $this->useTest(2);

        // Test in a caption
        $this->sikuli->click($this->findKeyword(1));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test in a header section
        $this->sikuli->click($this->findKeyword(2));
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test in the footer section
        $this->sikuli->click($this->findKeyword(3));
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test in the body section
        $this->sikuli->click($this->findKeyword(4));
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->sikuli->click($this->findKeyword(3));
        sleep(1);
        $this->selectKeyword(4);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

    }//end testListToolsIconsInATable()

}//end class

?>
