<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_RemoveListAndListItemsTest extends AbstractViperListPluginUnitTest
{


 	/**
     * Test that when you click the unordered or ordered list icon for one item in the list, all items in the list are removed
     *
     * @return void
     */
    public function testRemoveListWhenClickingInListItem()
    {
        //Test unordered list
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><p>second item %2%</p><p>third %3% item</p><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test unordered list
        $this->selectKeyword(5);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><p>second item %2%</p><p>third %3% item</p><p>Ordered List:</p><p>%4% first item</p><p>second item %5%</p><p>third %6% item</p>');

    }//end testRemoveListWhenClickingInListItem()


    /**
     * Test remove list items for an unordered list and then click undo and redo.
     *
     * @return void
     */
    public function testRemoveAllListItemsForUnorderedListAndClickUndo()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
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

        $this->assertFalse($inlineToolbarFound, 'The inline toolbar was found');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Click undo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Click redo
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testRemoveAllListItemsForUnorderedListAndClickUndo()


    /**
     * Test remove list items for an ordered list and then click undo and redo.
     *
     * @return void
     */
    public function testRemoveAllListItemsForOrderedListAndClickUndo()
    {
        $this->selectKeyword(5);
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

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p>');

        //Click undo
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Click redo
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>XAX first item</li><li>second item XBX</li><li>third XCX item</li></ul><p>Ordered List:</p>');

    }//end testRemoveAllListItemsForOrderedListAndClickUndo()


    /**
     * Test remove list items and then click undo.
     *
     * @return void
     */
    public function testRemoveListItemsAndClickUndoAndRedo()
    {
        //Test Unordered list
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test ordered list
        $this->selectKeyword(4, 5);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>third %6% item</li></ol>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>third %6% item</li></ol>');

    }//end testRemoveListItemsAndClickUndoAndRedo()


	/**
     * Test that an item can be removed from the list.
     *
     * @return void
     */
    public function testRemoveAnItemFromList()
    {
        //Test unordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);

        // Remove whole item.
        $this->sikuli->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test ordered list
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);

        // Remove whole item.
        $this->sikuli->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>third %6% item</li></ol>');

    }//end testRemoveItemFromList()


    /**
     * Test that a sub list with single item is removed from the main list.
     *
     * @return void
     */
    public function testRemoveSubListFromList()
    {
        //Test unordered list
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item<ul><li>second item %2%</li></ul></li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        $this->selectInlineToolbarLineageItem(3);

        // Remove whole item.
        $this->sikuli->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test ordered list
        $this->selectKeyword(5);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item<ol><li>second item %5%</li></ol></li><li>third %6% item</li></ol>');

        $this->selectInlineToolbarLineageItem(3);

        // Remove whole item.
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);

        // Remove the item element.
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>third %6% item</li></ol>');

    }//end testRemoveSubListFromList()


    /**
     * Test removing one item from a sub list.
     *
     * @return void
     */
    public function testRemoveOneItemFromASubList()
    {
        //Test unordered list
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.TAB');
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        // Remove whole item.
        $this->sikuli->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item<ul><li>third %3% item</li></ul></li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test ordered list
        $this->selectKeyword(5, 6);
        $this->sikuli->keyDown('Key.TAB');
        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(3);

        // Remove whole item.
        $this->sikuli->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item<ul><li>third %3% item</li></ul></li></ul><p>Ordered List:</p><ol><li>%4% first item<ol><li>second item %5%</li></ol></li></ol>');

    }//end testRemoveSubListItemFromList()


    /**
     * Test removing an item from a list by pressing backspace.
     *
     * @return void
     */
    public function testRemoveItemUsingBackspace()
    {
        //Test unordered list
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test ordered list
        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%third %6% item</li></ol>');

    }//end testRemoveItemUsingBackspace()


    /**
     * Test removing all items in the list using backspace
     *
     * @return void
     */
    public function testRemovingAllItemUsingBackspace()
    {
        //Test unordered list
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first itemsecond item %2%third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:%1% first itemsecond item %2%third %3% item</p><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test ordered list
        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:%1% first itemsecond item %2%third %3% item</p><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%third %6% item</li></ol>');

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:%1% first itemsecond item %2%third %3% item</p><p>Ordered List:</p><ol><li>%4% first itemsecond item %5%third %6% item</li></ol>');

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:%1% first itemsecond item %2%third %3% item</p><p>Ordered List:%4% first itemsecond item %5%third %6% item</p>');

    }//end testRemovingAllItemUsingBackspace()


}//end class

?>