<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_ListsInTablesTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test a list can be created and removed inside a table cell
     *
     * @return void
     */
    public function testCreatingAListInACellAndRemovingIt()
    {

        $this->useTest(1);

        //Test unordered list with list icon
        $this->moveToKeyword(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ul><li>Cell 1 %1%</li></ul></td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><p>Cell 1 %1%</p></td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        //Test creating ordered list
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ol><li>Cell 1 %1%</li></ol></td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><p>Cell 1 %1%</p></td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

    }//end testCreatingAListInACellAndRemovingIt()


    /**
     * Test creating a list in a table and clicking undo.
     *
     * @return void
     */
    public function testCreateListAndClickingUndo()
    {

        //Test unordered list
        $this->useTest(1);

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ul><li>Cell 1 %1%</li></ul></td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ul><li>Cell 1 %1%</li></ul></td><td>Cell 2</td><td>Cell 3<br /> <ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        
        //Test ordered list
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ol><li>Cell 1 %1%</li></ol></td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');      
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ol><li>Cell 1 %1%</li></ol></td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');
        
    }//end testCreateListAndClickingUndo()


    /**
     * Test indenting and outdenting a list item
     *
     * @return void
     */
    public function testIndentingAndOutdentingListItem()
    {
        //Test unordered list using the icons in the top toolbar
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1<ul><li>item 2 %2%</li></ul></li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        

        //Test unordered list using the inline toolbar
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1<ul><li>item 2 %2%</li></ul></li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
       

        //Test unordered list with keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1<ul><li>item 2 %2%</li></ul></li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        //Test ordered list using the icons in the top toolbar
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1<ol><li>item 2 %2%</li></ol></li></ol></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');      
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li></ol><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');      
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        

        //Test ordered list using the icons in the inline toolbar
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1<ol><li>item 2 %2%</li></ol></li></ol></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');      
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li></ol><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');      
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        

        //Test ordered list using the keyboard shortcuts
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1<ol><li>item 2 %2%</li></ol></li></ol></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');      
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li></ol><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);


    }//end testIndentingAndOutdentingListItem()


    /**
     * Test outdenting all items in the list
     *
     * @return void
     */
    public function testOutdentAllItemsInList()
    {

        //Test unordered list using top toolbar icon
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        //Test unordered list using inline toolbar icon
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        //Test ordered list using top toolbar icon
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        //Test ordered list using inline toolbar icon
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

    }//end testOutdentAllItemsInList()


    /**
     * Test a list item can be removed and added back in using the list icons.
     *
     * @return void
     */
    public function testRemovingAndAddingBackListItemUsingTheListIcons()
    {

        //Test unordered list using the top toolbar icons
        $this->useTest(1);
        $this->moveToKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        //Test unordered list using the inline toolbar icons
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li></ul><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        //Test ordered list using the top toolbar
        $this->useTest(2);
        $this->moveToKeyword(2);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li></ol><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        //Test ordered list using the inline toolbar
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li></ol><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

    }//end testRemovingAndAddingBackListItemUsingTheListIcons()


    /**
     * Test removing all list items using the list icons and then adding the list back again.
     *
     * @return void
     */
    public function testRemovingAllListItemsAndCreatingListAgain()
    {

        //Test unordered list using the top toolbar icons
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        //Test unordered list using the inline toolbar icons
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->clickInlineToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        //Test ordered list using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        //Test ordered list using the inline toolbar
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->clickInlineToolbarButton('listOL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

    }//end testRemovingAllListItemsAndCreatingListAgain()


    /**
     * Test a removing a list and then clicking undo.
     *
     * @return void
     */
    public function testRemovingListAndClickingUndo()
    {

        //Test unordered list
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
        
        //Test ordered list
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
        
    }//end testRemovingListAndClickingUndo()


    /**
     * Test chagning the list type for a list item
     *
     * @return void
     */
    public function testChangeListTypeForListItem()
    {

        //Test unordered list using top toolbar icon
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li></ul><ol><li>item 2 %2%</li></ol></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        //Test unordered list using inline toolbar icon
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('listOL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li></ul><ol><li>item 2 %2%</li></ol></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        //Test ordered list using top toolbar icon
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li></ol><ul><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        //Test ordered list using inline toolbar icon
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li></ol><ul><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

    }//end testChangeListTypeForListItem()


    /**
     * Test changing the list type for all items in the list
     *
     * @return void
     */
    public function testChangeingListType()
    {

        //Test unordered list using top toolbar icon
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        //Test unordered list using inline toolbar icon
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickInlineToolbarButton('listOL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with unordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ol><li>item 1</li><li>item 2 %2%</li></ol></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        //Test ordered list using top toolbar icon
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        //Test ordered list using inline toolbar icon
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickInlineToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with ordered list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

    }//end testChangeListTypeForListItem()


    /**
    * Test list tools in a table.
    *
    * @return void
    */
    public function testListToolsIconsInATable()
    {
        $this->useTest(3);

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
