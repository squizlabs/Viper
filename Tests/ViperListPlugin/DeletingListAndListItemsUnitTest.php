<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_DeletingListAndListItemsUnitTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test deleting list items for a list and then click undo and redo.
     *
     * @return void
     */
    public function testDeletingAllListItemsForListAndClickingUndo()
    {
        //Test unordered list
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        
        // Check that the inline toolbar no longer appears  on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }

        $this->assertFalse($inlineToolbarFound, 'The inline toolbar was found');
        $this->assertHTMLMatch('<p>Unordered List:</p>');

        //Click undo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Click redo
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Unordered List:</p>');

        //Test ordered list
        $this->useTest(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);

        // Check that the inline toolbar no longer appears  on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }

        $this->assertFalse($inlineToolbarFound, 'The inline toolbar was found');

        $this->assertHTMLMatch('<p>Ordered List:</p>');

        //Click undo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

        //Click redo
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Ordered List:</p>');

    }//end testDeletingAllListItemsForListAndClickingUndo()


    /**
     * Test deleteing multiple list items and then click undo.
     *
     * @return void
     */
    public function testDeletingMultipleListItemsAndClickUndoAndRedo()
    {
        //Test Unordered list
        $this->useTest(1);

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>third %3% item</li></ul>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>third %3% item</li></ul>');

        //Test ordered list
        $this->useTest(2);

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>third %3% item</li></ol>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>third %3% item</li></ol>');

    }//end testDeletingMultipleListItemsAndClickUndoAndRedo()


    /**
     * Test that a single list item can be deleted from the list.
     *
     * @return void
     */
    public function testDeleteAnItemFromList()
    {
        //Test unordered list
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        // Remove whole item.
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>third %3% item</li></ul>');

        //Test ordered list
        $this->useTest(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        // Remove whole item.
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>third %3% item</li></ol>');

    }//end testDeleteAnItemFromList()


    /**
     * Test that a sub list is deleted from the main list.
     *
     * @return void
     */
    public function testDeletingSubListFromList()
    {
        //Test unordered list
        $this->useTest(3);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        // Check that the inline toolbar no longer appears  on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item</li><li>third item</li></ul>');

        //Test ordered list
        $this->useTest(4);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        // Check that the inline toolbar no longer appears  on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item</li><li>third item</li></ol>');

    }//end testDeletingSubListFromList()


    /**
     * Test deleting an item from a sub list.
     *
     * @return void
     */
    public function testDeletingAnItemFromSubList()
    {
        //Test unordered list
        $this->useTest(3);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(3);
        // Remove whole item.
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub list item 1</li><li>sub list item 3</li></ul></li><li>second item</li><li>third item</li></ul>');

        //Test ordered list
        $this->useTest(4);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(3);
        // Remove whole item.
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub list item 1</li><li>sub list item 3</li></ol></li><li>second item</li><li>third item</li></ol>');

    }//end testDeletingAnItemFromSubList()


    /**
     * Test deleting list items for a list using the delete key.
     *
     * @return void
     */
    public function testDeletingAllListItemsUsingDeleteKey()
    {
        //Test unordered list
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        
        // Check that the inline toolbar no longer appears  on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }

        $this->assertFalse($inlineToolbarFound, 'The inline toolbar was found');
        $this->assertHTMLMatch('<p>Unordered List:</p>');

        //Test ordered list
        $this->useTest(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);

        // Check that the inline toolbar no longer appears  on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }

        $this->assertFalse($inlineToolbarFound, 'The inline toolbar was found');
        $this->assertHTMLMatch('<p>Ordered List:</p>');

    }//end testDeletingAllListItemsUsingDeleteKey()


    /**
     * Test deleteing multiple list items using the delete key.
     *
     * @return void
     */
    public function testDeletingMultipleListItemsUsingDeleteKey()
    {
        //Test Unordered list
        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>third %3% item</li></ul>');

        //Test ordered list
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>third %3% item</li></ol>');

    }//end testDeletingMultipleListItemsUsingDeleteKey()


    /**
     * Test that a single list item can be deleted from the list using the delete key.
     *
     * @return void
     */
    public function testDeleteAnItemFromListUsingDeleteKey()
    {
        //Test unordered list
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        // Remove whole item.
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>third %3% item</li></ul>');

        //Test ordered list
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        // Remove whole item.
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>third %3% item</li></ol>');

    }//end testDeleteAnItemFromListUsingDeleteKey()


    /**
     * Test that a sub list is deleted from the main list using the delete key.
     *
     * @return void
     */
    public function testDeletingSubListFromListUsingDeleteKey()
    {
        //Test unordered list
        $this->useTest(3);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $this->sikuli->keyDown('Key.DELETE');
        // Check that the inline toolbar no longer appears  on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item</li><li>third item</li></ul>');

        //Test ordered list
        $this->useTest(4);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $this->sikuli->keyDown('Key.DELETE');
        // Check that the inline toolbar no longer appears  on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item</li><li>third item</li></ol>');

    }//end testDeletingSubListFromListUsingDeleteKey()


    /**
     * Test deleting an item from a sub list using the delete key.
     *
     * @return void
     */
    public function testDeletingAnItemFromSubListUsingDeleteKey()
    {
        //Test unordered list
        $this->useTest(3);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(3);
        // Remove whole item.
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub list item 1</li><li>sub list item 3</li></ul></li><li>second item</li><li>third item</li></ul>');

        //Test ordered list
        $this->useTest(4);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(3);
        // Remove whole item.
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub list item 1</li><li>sub list item 3</li></ol></li><li>second item</li><li>third item</li></ol>');

    }//end testDeletingAnItemFromSubListUsingDeleteKey()


    /**
     * Test deleting a whole list item then a part of another list item after it at the same time in an unordered list.
     *
     * @return void
     */
    public function testDeletingAndReplacingWholeThenPartialItemsFromUnorderedList()
    {
        // Test using delete key
        // Select whole item first
        $this->useTest(5);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.UP');
        for ($i = 0; $i < 9; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Replacement item.');

        $this->assertHTMLMatch('<ul><li>First item.</li><li>Second %1%</li><li>Replacement item.</li><li>Fourth %5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ul>');

        // Select partial item first
        $this->useTest(5);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        for ($i = 0; $i < 9; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Replacement item.');

        $this->assertHTMLMatch('<ul><li>First item.</li><li>Second %1%</li><li>Replacement item.</li><li>Fourth %5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ul>');

        // Test using backspace key
        // Select whole item first
        $this->useTest(5);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.UP');
        for ($i = 0; $i < 9; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Replacement item.');

        $this->assertHTMLMatch('<ul><li>First item.</li><li>Second %1%</li><li>Replacement item.</li><li>Fourth %5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ul>');

        // Select partial item first
        $this->useTest(5);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        for ($i = 0; $i < 9; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Replacement item.');

        $this->assertHTMLMatch('<ul><li>First item.</li><li>Second %1%</li><li>Replacement item.</li><li>Fourth %5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ul>');

    }//end testDeletingAndReplacingWholeThenPartialItemsFromUnorderedList()


    /**
     * Test deleting a whole list item then a part of another list item before it at the same time in an unordered list.
     *
     * @return void
     */
    public function testDeletingAndReplacingPartialThenWholeItemsFromUnorderedList()
    {
        // Test using delete key
        // Select whole item first
        $this->useTest(5);
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        for ($i = 0; $i < 7; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->moveToKeyword(5, 'left');
        $this->type('Replacement item.');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<ul><li>First item.</li><li>Second %1% %2% item.</li><li>Replacement item.</li><li>%5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ul>');

        // Select partial item first
        $this->useTest(5);
        $this->moveToKeyword(5, 'left');
        $this->sikuli->keyDown('Key.SHIFT + Key.UP');
        for ($i = 0; $i < 7; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->moveToKeyword(5, 'left');
        $this->type('Replacement item.');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<ul><li>First item.</li><li>Second %1% %2% item.</li><li>Replacement item.</li><li>%5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ul>');

        // Test using backspace key
        // Select whole item first
        $this->useTest(5);
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        for ($i = 0; $i < 7; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->moveToKeyword(5, 'left');
        $this->type('Replacement item.');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<ul><li>First item.</li><li>Second %1% %2% item.</li><li>Replacement item.</li><li>%5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ul>');

        // Select partial item first
        $this->useTest(5);
        $this->moveToKeyword(5, 'left');
        $this->sikuli->keyDown('Key.SHIFT + Key.UP');
        for ($i = 0; $i < 7; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->moveToKeyword(5, 'left');
        $this->type('Replacement item.');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<ul><li>First item.</li><li>Second %1% %2% item.</li><li>Replacement item.</li><li>%5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ul>');

    }//end testDeletingAndReplacingPartialThenWholeItemsFromUnorderedList()


    /**
     * Test deleting a whole list item then a part of another list item after it at the same time in an ordered list.
     *
     * @return void
     */
    public function testDeletingAndReplacingWholeThenPartialItemsFromOrderedList()
    {
        // Test using delete key
        // Select whole item first
        $this->useTest(6);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.UP');
        for ($i = 0; $i < 9; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Replacement item.');

        $this->assertHTMLMatch('<ol><li>First item.</li><li>Second %1%</li><li>Replacement item.</li><li>Fourth %5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ol>');

        // Select partial item first
        $this->useTest(6);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        for ($i = 0; $i < 9; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Replacement item.');

        $this->assertHTMLMatch('<ol><li>First item.</li><li>Second %1%</li><li>Replacement item.</li><li>Fourth %5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ol>');

        // Test using backspace key
        // Select whole item first
        $this->useTest(6);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.UP');
        for ($i = 0; $i < 9; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Replacement item.');

        $this->assertHTMLMatch('<ol><li>First item.</li><li>Second %1%</li><li>Replacement item.</li><li>Fourth %5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ol>');

        // Select partial item first
        $this->useTest(6);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        for ($i = 0; $i < 9; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Replacement item.');

        $this->assertHTMLMatch('<ol><li>First item.</li><li>Second %1%</li><li>Replacement item.</li><li>Fourth %5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ol>');

    }//end testDeletingAndReplacingWholeThenPartialItemsFromOrderedList()


    /**
     * Test deleting a whole list item then a part of another list item before it at the same time in an ordered list.
     *
     * @return void
     */
    public function testDeletingAndReplacingPartialThenWholeItemsFromOrderedList()
    {
        // Test using delete key
        // Select whole item first
        $this->useTest(6);
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        for ($i = 0; $i < 7; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->moveToKeyword(5, 'left');
        $this->type('Replacement item.');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<ol><li>First item.</li><li>Second %1% %2% item.</li><li>Replacement item.</li><li>%5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ol>');

        // Select partial item first
        $this->useTest(6);
        $this->moveToKeyword(5, 'left');
        $this->sikuli->keyDown('Key.SHIFT + Key.UP');
        for ($i = 0; $i < 7; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->moveToKeyword(5, 'left');
        $this->type('Replacement item.');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<ol><li>First item.</li><li>Second %1% %2% item.</li><li>Replacement item.</li><li>%5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ol>');

        // Test using backspace key
        // Select whole item first
        $this->useTest(6);
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        for ($i = 0; $i < 7; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->moveToKeyword(5, 'left');
        $this->type('Replacement item.');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<ol><li>First item.</li><li>Second %1% %2% item.</li><li>Replacement item.</li><li>%5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ol>');

        // Select partial item first
        $this->useTest(6);
        $this->moveToKeyword(5, 'left');
        $this->sikuli->keyDown('Key.SHIFT + Key.UP');
        for ($i = 0; $i < 7; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->moveToKeyword(5, 'left');
        $this->type('Replacement item.');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<ol><li>First item.</li><li>Second %1% %2% item.</li><li>Replacement item.</li><li>%5% item.</li><li>Fifth item.</li><li>Sixth item.</li></ol>');

    }//end testDeletingAndReplacingPartialThenWholeItemsFromOrderedList()


}//end class

?>