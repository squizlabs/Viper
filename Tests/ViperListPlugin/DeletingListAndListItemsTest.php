<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_DeletingListAndListItemsTest extends AbstractViperListPluginUnitTest
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
        // Remove the item element.
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub list item 1</li><li>sub list item 3</li></ul></li><li>second item</li><li>third item</li></ul>');

        //Test ordered list
        $this->useTest(4);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(3);
        // Remove whole item.
        $this->sikuli->keyDown('Key.BACKSPACE');
        // Remove the item element.
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub list item 1</li><li>sub list item 3</li></ol></li><li>second item</li><li>third item</li></ol>');

    }//end testDeletingAnItemFromSubList()


}//end class

?>