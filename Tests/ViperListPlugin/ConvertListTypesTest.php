<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_ConvertListTypesTest extends AbstractViperListPluginUnitTest
{


 	/**
     * Test converting a single list item from unordered to ordered to unordered.
     *
     * @return void
     */
    public function testConvertListItem()
    {
        //Clicking inside the list item
        $this->useTest(1);
        $this->moveToKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li></ul><ol><li>item 2 %2%</li></ol><ul><li>item 3</li><li>item 4 %3%</li></ul>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        //Selecting a word in the item and using the top toolbar
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li></ul><ol><li>item 2 %2%</li></ol><ul><li>item 3</li><li>item 4 %3%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');

        //Selecting a word in the item and using the inline toolbar
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li></ul><ol><li>item 2 %2%</li></ol><ul><li>item 3</li><li>item 4 %3%</li></ul>');
        $this->clickInlineToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');

        //Selecting the whole list item and using the top toolbar.
        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li></ul><ol><li>item 2 %2%</li></ol><ul><li>item 3</li><li>item 4 %3%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');

        //Selecting the whole list item and using inline toolbar.
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickInlineToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li></ul><ol><li>item 2 %2%</li></ol><ul><li>item 3</li><li>item 4 %3%</li></ul>');
        $this->clickInlineToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');

    }//end testConvertListItem()


    /**
     * Test converting all items in a list from unordered to ordered to unordered.
     *
     * @return void
     */
    public function testConvertingAllItemsInAList()
    {
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        //Using top toolbar
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ol>');
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');

        //Using inline toolbar
        $this->clickInlineToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ol>');
        $this->clickInlineToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');

    }//end testConvertingAllItemsInAList()


    /**
     * Test converting the first item in the list from unordered to ordered to unordered.
     *
     * @return void
     */
    public function testConvertFirstItemInList()
    {
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        //Using the top toolbar
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%</li></ol><ul><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');

        //Using the inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%</li></ol><ul><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');
        $this->clickInlineToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');

    }//end testConvertFirstItemInList()


    /**
     * Test converting the last item in the list from unordered to ordered to unordered
     *
     * @return void
     */
    public function testConvertLastItemInList()
    {
        $this->useTest(1);
        $this->moveToKeyword(3);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        //Using the top toolbar
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li></ul><ol><li>item 4 %3%</li></ol>');
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');

        //Using the inline toolbar
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li></ul><ol><li>item 4 %3%</li></ol>');
        $this->clickInlineToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');

    }//end testConvertFirstItemInList()


    /**
     * Test converting an item in a sub list from unordered to ordered to unordered.
     *
     * @return void
     */
    public function testConvertAnItemInASubList()
    {
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        //Using top toolbar
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<br /><ol><li>sub item 1 %1%</li></ol><ul><li>sub item 2 %2%</li></ul></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<br /><ul><li>sub item 1 %1%</li></ul><ul><li>sub item 2 %2%</li></ul></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');

        //Using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<br /><ol><li>sub item 1 %1%</li></ol><ul><li>sub item 2 %2%</li></ul></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');
        $this->clickInlineToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<br /><ul><li>sub item 1 %1%</li></ul><ul><li>sub item 2 %2%</li></ul></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');

    }//end testConvertListFromUnorderedToOrderedWithSubList()


    /**
     * Test converting all items in a sub list from unordered to ordered to unordered.
     *
     * @return void
     */
    public function testConvertAllItemsInASubList()
    {
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        //Using top toolbar
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ol></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ul></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');

        //Using inline toolbar
        $this->clickInlineToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ol></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');
        $this->clickInlineToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ul></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');

    }//end testConvertAllItemsInASubList()


    /**
     * Test converting all items in a list and sub list from unordered to ordered to unordered.
     *
     * @return void
     */
    public function testConvertAllItemsInAListAndSubList()
    {
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, FALSE);

        //Using top toolbar
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, FALSE);
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ol></li><li>item 2</li><li>item 3</li><li>item 4</li></ol>');
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, FALSE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ul></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');

        //Using inline toolbar
        $this->clickInlineToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, FALSE);
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ol></li><li>item 2</li><li>item 3</li><li>item 4</li></ol>');
        $this->clickInlineToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, FALSE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ul></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');

    }//end testConvertAllItemsInAListAndSubList()


    /**
     * Test converting list item and clicking undo and redo.
     *
     * @return void
     */
    public function testConvertListItemAndClickingUndo()
    {
        $this->useTest(1);

        $this->moveToKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li></ul><ol><li>item 2 %2%</li></ol><ul><li>item 3</li><li>item 4 %3%</li></ul>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li></ul><ol><li>item 2 %2%</li></ol><ul><li>item 3</li><li>item 4 %3%</li></ul>');

    }//end testConvertListItemAndClickingUndo()


}//end class

?>