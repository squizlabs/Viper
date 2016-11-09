<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_ConvertListTypesUnitTest extends AbstractViperListPluginUnitTest
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

        $this->selectKeyword(2);

        //Selecting a word in the item
        foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
            $this->doAction($method, 'listOL');
            $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li></ul><ol><li>item 2 %2%</li></ol><ul><li>item 3</li><li>item 4 %3%</li></ul>');
            $this->doAction($method, 'listUL');
            $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');
        }

        $this->selectInlineToolbarLineageItem(1);

        //Selecting the whole list item
        foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
            $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
            $this->doAction($method, 'listOL');
            $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li></ul><ol><li>item 2 %2%</li></ol><ul><li>item 3</li><li>item 4 %3%</li></ul>');
            $this->doAction($method, 'listUL');
            $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');
        }

    }//end testConvertListItem()


    /**
     * Test converting all items in a list from unordered to ordered to unordered.
     *
     * @return void
     */
    public function testConvertingAllItemsInAList()
    {
        foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
            $this->useTest(1);
            $this->selectKeyword(2);
            $this->selectInlineToolbarLineageItem(0);
            $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
            $this->doAction($method, 'listOL');
            $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ol>');
            $this->doAction($method, 'listUL');
            $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');
        }

    }//end testConvertingAllItemsInAList()


    /**
     * Test converting the first item in the list from unordered to ordered to unordered.
     *
     * @return void
     */
    public function testConvertFirstItemInList()
    {
        foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
            $this->useTest(1);
            $this->selectKeyword(1);
            $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
            $this->doAction($method, 'listOL');
            $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%</li></ol><ul><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');
            $this->doAction($method, 'listUL');
            $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');
        }

    }//end testConvertFirstItemInList()


    /**
     * Test converting the last item in the list from unordered to ordered to unordered
     *
     * @return void
     */
    public function testConvertLastItemInList()
    {
        foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
            $this->useTest(1);
            $this->selectKeyword(3);
            $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
            $this->doAction($method, 'listOL');
            $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li></ul><ol><li>item 4 %3%</li></ol>');
            $this->doAction($method, 'listUL');
            $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3</li><li>item 4 %3%</li></ul>');
        }

    }//end testConvertFirstItemInList()


    /**
     * Test converting an item in a sub list from unordered to ordered to unordered.
     *
     * @return void
     */
    public function testConvertAnItemInASubList()
    {
        foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
            $this->useTest(2);
            $this->selectKeyword(1);
            $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
            $this->doAction($method, 'listOL');
            $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<ol><li>sub item 1 %1%</li></ol><ul><li>sub item 2 %2%</li></ul></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');
            $this->doAction($method, 'listUL');
            $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ul></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');
        }

    }//end testConvertListFromUnorderedToOrderedWithSubList()


    /**
     * Test converting all items in a sub list from unordered to ordered to unordered.
     *
     * @return void
     */
    public function testConvertAllItemsInASubList()
    {
         foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
            $this->useTest(2);
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(2);
            $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
            $this->doAction($method, 'listOL');
            $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ol></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');
            $this->doAction($method, 'listUL');
            $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ul></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');
        }

    }//end testConvertAllItemsInASubList()


    /**
     * Test converting all items in a list and sub list from unordered to ordered to unordered.
     *
     * @return void
     */
    public function testConvertAllItemsInAListAndSubList()
    {
        foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
            $this->useTest(2);
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(0);
            $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
            $this->doAction($method, 'listOL');
            $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1<ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ol></li><li>item 2</li><li>item 3</li><li>item 4</li></ol>');
            $this->doAction($method, 'listUL');
            $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
            $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1<ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ul></li><li>item 2</li><li>item 3</li><li>item 4</li></ul>');
        }

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


    /**
     * Test converting two list items and then converting them back to the original list type.
     *
     * @return void
     */
    public function testConvertTwoListItems()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(3);
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                    $ulConvertStatus = TRUE;
                    $olConvertStatus = 'active';
                    $convertListType = 'ol';
                    $firstIconToClick = 'listOL';
                    $secondIconToClick = 'listUL';
                } else {
                    $this->useTest(4);
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                    $ulConvertStatus = 'active';
                    $olConvertStatus = TRUE;
                    $convertListType = 'ul';
                    $firstIconToClick = 'listUL';
                    $secondIconToClick = 'listOL';
                }

                $this->selectKeyword(1, 2);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);

                $this->doAction($method, $firstIconToClick);
                $this->assertIconStatusesCorrect($ulConvertStatus, $olConvertStatus, FALSE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li></'.$listType.'><'.$convertListType.'><li>%1% item 2</li><li>item 3 %2%</li></'.$convertListType.'><'.$listType.'><li>item 4</li></'.$listType.'>');

                $this->doAction($method, $secondIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>%1% item 2</li><li>item 3 %2%</li><li>item 4</li></'.$listType.'>');
            }
        }

    }//end testConvertTwoListItems()


}//end class

?>