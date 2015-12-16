<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_RemoveListAndListItemsUnitTest extends AbstractViperListPluginUnitTest
{


 	/**
     * Test revmoing and adding back the first list item.
     *
     * @return void
     */
    public function testRemoveAndAddBackTheFirstListItem()
    {
        //Test unordered list when click inside a list item
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><ul><li>%2% second item</li><li>%3% third item</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ul>');

        //Test unordered list when select a word in the list item
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><ul><li>%2% second item</li><li>%3% third item</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ul>');

        //Test unordered list when select the whole list item
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><ul><li>%2% second item</li><li>%3% third item</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ul>');

        //Test ordered list when click inside a list item
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><ol><li>%2% second item</li><li>%3% third item</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ol>');

        //Test ordered list when select a word in the list item
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><ol><li>%2% second item</li><li>%3% third item</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ol>');

        //Test ordered list when select the whole list item
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><ol><li>%2% second item</li><li>%3% third item</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ol>');

    }//end testRemoveAndAddBackTheFirstListItem()


    /**
     * Test removing and adding back in the middle list item.
     *
     * @return void
     */
    public function testRemoveAndAddBackTheMidlleListItem()
    {
        //Test unordered list when click inside a list item
        $this->useTest(1);
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>%2% second item</p><ul><li>%3% third item</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ul>');

        //Test unordered list when select a word in the list item
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>%2% second item</p><ul><li>%3% third item</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ul>');

        //Test unordered list when select the whole list item
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>%2% second item</p><ul><li>%3% third item</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ul>');

        //Test ordered list when click inside a list item
        $this->useTest(2);
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li></ol><p>%2% second item</p><ol><li>%3% third item</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ol>');

        //Test ordered list when select a word in the list item
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li></ol><p>%2% second item</p><ol><li>%3% third item</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ol>');

        //Test ordered list when select the whole list item
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li></ol><p>%2% second item</p><ol><li>%3% third item</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ol>');

    }//end testRemoveAndAddBackTheMidlleListItem()


    /**
     * Test removing and adding back in the last list item.
     *
     * @return void
     */
    public function testRemoveAndAddBackTheLastListItem()
    {
        //Test unordered list when click inside a list item
        $this->useTest(1);
        $this->moveToKeyword(3);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li></ul><p>%3% third item</p>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ul>');

        //Test unordered list when select a word in the list item
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li></ul><p>%3% third item</p>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ul>');

        //Test unordered list when select the whole list item
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li></ul><p>%3% third item</p>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ul>');

        //Test ordered list when click inside a list item
        $this->useTest(2);
        $this->moveToKeyword(3);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li></ol><p>%3% third item</p>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ol>');

        //Test ordered list when select a word in the list item
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li></ol><p>%3% third item</p>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ol>');

        //Test ordered list when select the whole list item
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li></ol><p>%3% third item</p>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ol>');

    }//end testRemoveAndAddBackTheLastListItem()


    /**
     * Test list is removed when you click the list icon
     *
     * @return void
     */
    public function testRemoveListUsingListIcon()
    {
        //Test unordered list using top toolbar icons
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><p>%2% second item</p><p>%3% third item</p>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ul>');

        //Test unordered list using inline toolbar icons
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><p>%2% second item</p><p>%3% third item</p>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ul>');

        //Test ordered list using top toolbar icons
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><p>%2% second item</p><p>%3% third item</p>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ol>');

        //Test ordered list using inline toolbar icons
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><p>%2% second item</p><p>%3% third item</p>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></ol>');

    }//end testRemoveListUsingListIcon()


    /**
     * Test revmoing and adding back the first list item in a sub list.
     *
     * @return void
     */
    public function testRemoveAndAddBackTheFirstItemInASubList()
    {
        //Test unordered list when click inside a list item
        $this->useTest(3);
        $this->moveToKeyword(4);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><p>sub item 1 %1%</p><ul><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');

        //Test unordered list when select a word in the list item
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><p>sub item 1 %1%</p><ul><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');

        //Test unordered list when select the whole list item
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><p>sub item 1 %1%</p><ul><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');

        //Test ordered list when click inside a list item
        $this->useTest(4);
        $this->moveToKeyword(4);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><p>sub item 1 %1%</p><ol><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');

        //Test ordered list when select a word in the list item
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><p>sub item 1 %1%</p><ol><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');

        //Test ordered list when select the whole list item
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><p>sub item 1 %1%</p><ol><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');

    }//end testRemoveAndAddBackTheFirstItemInASubList()


    /**
     * Test revmoing and adding back the middle list item in a sub list.
     *
     * @return void
     */
    public function testRemoveAndAddBackTheMiddleItemInASubList()
    {
        //Test unordered list when click inside a list item
        $this->useTest(3);
        $this->moveToKeyword(4);
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li></ul><p>sub item 2 %2%</p><ul><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');

        //Test unordered list when select a word in the list item
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li></ul><p>sub item 2 %2%</p><ul><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');
        $this->clickInlineToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');

        //Test unordered list when select the whole list item
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li></ul><p>sub item 2 %2%</p><ul><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');

        //Test ordered list when click inside a list item
        $this->useTest(4);
        $this->moveToKeyword(4);
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li></ol><p>sub item 2 %2%</p><ol><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');

        //Test ordered list when select a word in the list item
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li></ol><p>sub item 2 %2%</p><ol><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');
        $this->clickInlineToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');

        //Test ordered list when select the whole list item
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li></ol><p>sub item 2 %2%</p><ol><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');

    }//end testRemoveAndAddBackTheMiddleItemInASubList()


    /**
     * Test revmoing and adding back the last list item in a sub list.
     *
     * @return void
     */
    public function testRemoveAndAddBackTheLastItemInASubList()
    {
        //Test unordered list when click inside a list item
        $this->useTest(3);
        $this->moveToKeyword(4);
        $this->moveToKeyword(3);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ul><p>sub item 3 %3%</p></li><li>second item %4%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');

        //Test unordered list when select a word in the list item
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ul><p>sub item 3 %3%</p></li><li>second item %4%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');

        //Test unordered list when select the whole list item
        $this->selectInlineToolbarLineageItem(3);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ul><p>sub item 3 %3%</p></li><li>second item %4%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');

        //Test ordered list when click inside a list item
        $this->useTest(4);
        $this->moveToKeyword(4);
        $this->moveToKeyword(3);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ol><p>sub item 3 %3%</p></li><li>second item %4%</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');

        //Test ordered list when select a word in the list item
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ol><p>sub item 3 %3%</p></li><li>second item %4%</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');

        //Test ordered list when select the whole list item
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li></ol><p>sub item 3 %3%</p></li><li>second item %4%</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');

    }//end testRemoveAndAddBackTheLastItemInASubList()


    /**
     * Test sub list is removed when you click the list icon
     *
     * @return void
     */
    public function testRemoveSubListUsingListIcon()
    {
        //Test unordered list using top toolbar icons
        $this->useTest(3);
        $this->moveToKeyword(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><p>sub item 1 %1%</p><p>sub item 2 %2%</p><p>sub item 3 %3%</p></li><li>second item %4%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');

        //Test unordered list using inline toolbar icons
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><p>sub item 1 %1%</p><p>sub item 2 %2%</p><p>sub item 3 %3%</p></li><li>second item %4%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item<br /><ul><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ul></li><li>second item %4%</li></ul>');

        //Test ordered list using top toolbar icons
        $this->useTest(4);
        $this->moveToKeyword(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><p>sub item 1 %1%</p><p>sub item 2 %2%</p><p>sub item 3 %3%</p></li><li>second item %4%</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');

        //Test ordered list using the inline toolbar icons
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><p>sub item 1 %1%</p><p>sub item 2 %2%</p><p>sub item 3 %3%</p></li><li>second item %4%</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item<br /><ol><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></ol></li><li>second item %4%</li></ol>');

    }//end testRemoveListUsingListIcon()

    /**
     * Test removing an item from a list by pressing backspace.
     *
     * @return void
     */
    public function testRemoveItemUsingBackspace()
    {
        //Test unordered list
        $this->useTest(1);
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item%3% third item</li></ul>');
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item%2% second item%3% third item</li></ul>');
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:%1% first item%2% second item%3% third item</p>');
        //Test ordered list
        $this->useTest(2);
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item%3% third item</li></ol>');
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item%2% second item%3% third item</li></ol>');
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:%1% first item%2% second item%3% third item</p>');

    }//end testRemoveItemUsingBackspace()


    /**
     * Test removing all items in the list using backspace
     *
     * @return void
     */
    public function testRemovingAllItemUsingBackspace()
    {
        //Test unordered list from start of list
        $this->useTest(1);

        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:%1% first item</p><ul><li>%2% second item</li><li>%3% third item</li></ul>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:%1% first item%2% second item</p><ul><li>%3% third item</li></ul>');

        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:%1% first item%2% second item%3% third item</p>');

        //Test ordered list from start of list
        $this->useTest(2);

        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:%1% first item</p><ol><li>%2% second item</li><li>%3% third item</li></ol>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:%1% first item%2% second item</p><ol><li>%3% third item</li></ol>');

        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:%1% first item%2% second item%3% third item</p>');

        //Test unordered list from end of list
        $this->useTest(1);

        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>%2% second item%3% third item</li></ul>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item%2% second item%3% third item</li></ul>');

        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:%1% first item%2% second item%3% third item</p>');

        //Test ordered list from end of list
        $this->useTest(2);

        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>%2% second item%3% third item</li></ol>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item%2% second item%3% third item</li></ol>');

        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:%1% first item%2% second item%3% third item</p>');

    }//end testRemovingAllItemUsingBackspace()


    /**
     * Test removing all items in the list using backspace and forward delete
     *
     * @return void
     */
    public function testAddAndRemoveNewBulletsToList()
    {
        //Test unordered list using backspace
        $this->useTest(5);

        // Create list
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('%2% new list');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><ul><li>%2% new list</li></ul>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);

        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ul><li></li><li></li><li></li><li>%2% new list</li></ul>', $this->_getHtmllWithBlankLiTags());

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ul><li></li><li></li><li>%2% new list</li></ul>', $this->_getHtmllWithBlankLiTags());
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ul><li></li><li>%2% new list</li></ul>', $this->_getHtmllWithBlankLiTags());
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ul><li>%2% new list</li></ul>', $this->_getHtmllWithBlankLiTags());

        //Test unordered list using forward delete
        $this->useTest(5);

        // Create list
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('%2% new list');
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><ul><li>%2% new list</li></ul>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ul><li></li><li></li><li></li><li>%2% new list</li></ul>', $this->_getHtmllWithBlankLiTags());

        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ul><li></li><li></li><li>%2% new list</li></ul>', $this->_getHtmllWithBlankLiTags());
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ul><li></li><li>%2% new list</li></ul>', $this->_getHtmllWithBlankLiTags());
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ul><li>%2% new list</li></ul>', $this->_getHtmllWithBlankLiTags());

        //Test ordered list using backspace
        $this->useTest(5);

        // Create list
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('%2% new list');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><ol><li>%2% new list</li></ol>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ol><li></li><li></li><li></li><li>%2% new list</li></ol>', $this->_getHtmllWithBlankLiTags());

        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ol><li></li><li></li><li>%2% new list</li></ol>', $this->_getHtmllWithBlankLiTags());
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ol><li></li><li>%2% new list</li></ol>', $this->_getHtmllWithBlankLiTags());
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ol><li>%2% new list</li></ol>', $this->_getHtmllWithBlankLiTags());

        //Test ordered list using forward delete
        $this->useTest(5);

        // Create list
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('%2% new list');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><ol><li>%2% new list</li></ol>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ol><li></li><li></li><li></li><li>%2% new list</li></ol>', $this->_getHtmllWithBlankLiTags());

        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ol><li></li><li></li><li>%2% new list</li></ol>', $this->_getHtmllWithBlankLiTags());
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ol><li></li><li>%2% new list</li></ol>', $this->_getHtmllWithBlankLiTags());
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertEquals('<p>Adding and Removing Bullets %1%</p><ol><li>%2% new list</li></ol>', $this->_getHtmllWithBlankLiTags());

    }//end testAddAndRemoveNewBulletsToList()


    /**
     * Get the content of Viper without stripping the blank LI tags.
     *
     * @return string
     */
    private function _getHtmllWithBlankLiTags()
    {
        $html = $this->sikuli->execJS('ViperUtil.getHtml(ViperUtil.getid(\'content\'))');
        $html = str_replace('<br>', '', $html);

        return $html;

    }//end _getHtmllWithBlankLiTags


    /**
     * Test for removing multiple lists.
     *
     * @return string
     */
    public function testRemoveMultipleLists()
    {
        // Removing multiple unordered lists from content
        $this->useTest(6);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('listUl', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><p>second item</p><p>third item</p><p>Another list:</p><p>first item</p><p>second item</p><p>third item %2%</p>');

        // Removing multiple ordered lists from content
        $this->useTest(7);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('listOl', 'active');
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><p>second item</p><p>third item</p><p>Another list:</p><p>first item</p><p>second item</p><p>third item %2%</p>');

         // Removing multiple lists from content
        $this->useTest(8);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('listUl', 'active');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>XAX first item</p><p>second item</p><p>third item</p><p>Another list:</p><p>first item</p><p>second item</p><p>third item XBX</p>');

    }//end testRemoveMultipleLists


}//end class

?>
