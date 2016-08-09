<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_ListsInTablesUnitTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test a list can be created and removed inside a table cell
     *
     * @return void
     */
    public function testCreatingAListInACellAndRemovingIt()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $listIconToClick = 'listUL';
                $ulStatus = 'active';
                $olStatus = TRUE;
            } else {
                $listIconToClick = 'listOL';
                $ulStatus = TRUE;
                $olStatus = 'active';
            }

            $this->useTest(1);
            $this->moveToKeyword(1);
            $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE, FALSE, FALSE);

            $this->clickTopToolbarButton($listIconToClick);
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><'.$listType.'><li>Cell 1 %1%</li></'.$listType.'></td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE, FALSE, FALSE);

            $this->clickTopToolbarButton($listIconToClick, 'active');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><p>Cell 1 %1%</p></td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
            $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
        }

    }//end testCreatingAListInACellAndRemovingIt()


    /**
     * Test creating a list in a cell, removing it and re-creating it
     *
     * @return void
     */
    public function testCreatingRemovingAdnCreatingAList()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $listIconToClick = 'listUL';
                $ulStatus = 'active';
                $olStatus = TRUE;
            } else {
                $listIconToClick = 'listOL';
                $ulStatus = TRUE;
                $olStatus = 'active';
            }

            $this->useTest(1);
            $this->moveToKeyword(1);
            $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE, FALSE, FALSE);
            $this->clickTopToolbarButton($listIconToClick);
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><'.$listType.'><li>Cell 1 %1%</li></'.$listType.'></td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE, FALSE, FALSE);

            // Test removing list
            $this->clickTopToolbarButton($listIconToClick, 'active');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><p>Cell 1 %1%</p></td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
            $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FASLE);

            // Test re-creating the list
            $this->clickTopToolbarButton($listIconToClick);
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><'.$listType.'><li>Cell 1 %1%</li></'.$listType.'></td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE, FALSE, FALSE);
        }

    }//end testCreatingRemovingAdnCreatingAList()


    /**
     * Test creating a list in a table and clicking undo.
     *
     * @return void
     */
    public function testCreateListAndClickingUndo()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $listIconToClick = 'listUL';
                $ulStatus = 'active';
                $olStatus = TRUE;
            } else {
                $listIconToClick = 'listOL';
                $ulStatus = TRUE;
                $olStatus = 'active';
            }

            $this->useTest(1);

            $this->moveToKeyword(1);
            $this->clickTopToolbarButton($listIconToClick);
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><'.$listType.'><li>Cell 1 %1%</li></'.$listType.'></td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE, FALSE, FALSE);

            $this->clickTopToolbarButton('historyUndo');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');

            $this->clickTopToolbarButton('historyRedo');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><'.$listType.'><li>Cell 1 %1%</li></'.$listType.'></td><td>Cell 2</td><td>Cell 3<br /> <ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
        }
        
    }//end testCreateListAndClickingUndo()


    /**
     * Test indenting and outdenting a list item with shortcut keys
     *
     * @return void
     */
    public function testIndentingAndOutdentingListItemsWithShortcutKeys()
    {
        // Test single list item
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
                $ulStatus = 'active';
                $olStatus = TRUE;
            } else {
                $this->useTest(2);
                $ulStatus = TRUE;
                $olStatus = 'active';
            }

            $this->selectKeyword(2);
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);

            // Test that you can indent an exisiting list item
            $this->sikuli->keyDown('Key.TAB');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1<'.$listType.'><li>item 2 %2%</li></'.$listType.'></li></'.$listType.'></td></tr></tbody></table>');
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);

            // Test that you can outdent an existing list item
            $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1</li><li>item 2 %2%</li></'.$listType.'></td></tr></tbody></table>');
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);

            $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1</li></'.$listType.'><p>item 2 %2%</p></td></tr></tbody></table>');
            $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

            // Test that you cannot indent a paragraph to an existing list
            $this->sikuli->keyDown('Key.TAB');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1</li></'.$listType.'><p>item 2 %2%</p></td></tr></tbody></table>');
            $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

            // Test that you cannot indent a paragraph in a cell
            $this->clickKeyword(1);
            $this->sikuli->keyDown('Key.TAB');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1</li></'.$listType.'><p>item 2 %2%</p></td></tr></tbody></table>');
        }

        // Test all items in the list
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
                $ulStatus = 'active';
                $olStatus = TRUE;
            } else {
                $this->useTest(2);
                $ulStatus = TRUE;
                $olStatus = 'active';
            }

            $this->selectKeyword(2);
            $this->selectInlineToolbarLineageItem(4);

            // Test that tab does nothing
            $this->sikuli->keyDown('Key.TAB');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1</li><li>item 2 %2%</li></'.$listType.'></td></tr></tbody></table>');
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);

            // Test that you can outdent all list items
            $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
            $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);

            // Test that tab does nothing
            $this->sikuli->keyDown('Key.TAB');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
            $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);
        }

    }//end testIndentingAndOutdentingListItemsWithShortcutKeys()


    /**
     * Test indenting and outdenting a list item
     *
     * @return void
     */
    public function testIndentingAndOutdentingListItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(2);
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(2);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);

                $this->doAction($method, 'listIndent');
                $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1<'.$listType.'><li>item 2 %2%</li></'.$listType.'></li></'.$listType.'></td></tr></tbody></table>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);

                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1</li><li>item 2 %2%</li></'.$listType.'></td></tr></tbody></table>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);

                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1</li></'.$listType.'><p>item 2 %2%</p></td></tr></tbody></table>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                $this->doTopToolbarAction($method, 'listIndent');
                $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1</li><li>item 2 %2%</li></'.$listType.'></td></tr></tbody></table>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
            }
        }

    }//end testIndentingAndOutdentingListItem()


    /**
     * Test outdenting all items in the list
     *
     * @return void
     */
    public function testOutdentAndIndentAllItemsInList()
    {

        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);  
                } else {
                    $this->useTest(2);
                }

                $this->selectKeyword(2);
                $this->selectInlineToolbarLineageItem(4);

                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);

                $this->doTopToolbarAction($method, 'listIndent');
                $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><ul><li>item 1</li><li>item 2 %2%</li></ul></td></tr></tbody></table>');
                $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
            }
        }

    }//end testOutdentAndIndentAllItemsInList()


    /**
     * Test a list item can be removed and added back in using the list icons.
     *
     * @return void
     */
    public function testRemovingAndAddingBackListItemUsingTheListIcons()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(2);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(2);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);

                $this->doAction($method, $listIconToClick, 'active');
                $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1</li></'.$listType.'><p>item 2 %2%</p></td></tr></tbody></table>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1</li><li>item 2 %2%</li></'.$listType.'></td></tr></tbody></table>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
            }
        }

    }//end testRemovingAndAddingBackListItemUsingTheListIcons()


    /**
     * Test removing all list items using the list icons and then adding the list back again.
     *
     * @return void
     */
    public function testRemovingAllListItemsAndCreatingListAgain()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(2);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(2);
                $this->selectInlineToolbarLineageItem(4);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);

                $this->doAction($method, $listIconToClick, 'active');
                $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);

                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1</li><li>item 2 %2%</li></'.$listType.'></td></tr></tbody></table>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
            }
        }

    }//end testRemovingAllListItemsAndCreatingListAgain()


    /**
     * Test a removing a list and then clicking undo.
     *
     * @return void
     */
    public function testRemovingListAndClickingUndo()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
                $listIconToClick = 'listUL';
            } else {
                $this->useTest(2);
                $listIconToClick = 'listOL';
            }

            $this->selectKeyword(2);
            $this->selectInlineToolbarLineageItem(4);
            $this->clickTopToolbarButton($listIconToClick, 'active');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');

            $this->clickTopToolbarButton('historyUndo');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1</li><li>item 2 %2%</li></'.$listType.'></td></tr></tbody></table>');

            $this->clickTopToolbarButton('historyRedo');
            $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><p>item 1</p><p>item 2 %2%</p></td></tr></tbody></table>');
        }
        
    }//end testRemovingListAndClickingUndo()


    /**
     * Test chagning the list type for a list item
     *
     * @return void
     */
    public function testChangeListTypeForListItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $listIconToClick = 'listOL';
                    $newListType = 'ol';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                } else {
                    $this->useTest(2);
                    $listIconToClick = 'listUL';
                    $newListType = 'ul';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                }
        
                $this->selectKeyword(2);
                $this->doAction($method, $listIconToClick);
                $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$listType.'><li>item 1</li></'.$listType.'><'.$newListType.'><li>item 2 %2%</li></'.$newListType.'></td></tr></tbody></table>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
            }
        }

    }//end testChangeListTypeForListItem()


    /**
     * Test changing the list type for all items in the list
     *
     * @return void
     */
    public function testChangeingListType()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $listIconToClick = 'listOL';
                    $newListType = 'ol';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                } else {
                    $this->useTest(2);
                    $listIconToClick = 'listUL';
                    $newListType = 'ul';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                }
        
                $this->selectKeyword(2);
                $this->selectInlineToolbarLineageItem(4);
                $this->doAction($method, $listIconToClick);
                $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> A table with list</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>Cell 1 %1%</td><td>Cell 2</td><td>Cell 3<br /><'.$newListType.'><li>item 1</li><li>item 2 %2%</li></'.$newListType.'></td></tr></tbody></table>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
            }
        }

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
        $this->clickKeyword(1);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        // Test in a header section
        $this->clickKeyword(2);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        // Test in the footer section
        $this->clickKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        // Test in the body section
        $this->clickKeyword(4);
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        $this->clickKeyword(3);
        sleep(1);
        $this->selectKeyword(4);
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE, FALSE, FALSE);

    }//end testListToolsIconsInATable()

}//end class

?>
