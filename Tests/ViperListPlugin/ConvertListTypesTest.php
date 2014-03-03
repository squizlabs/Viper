<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_ConvertListTypesTest extends AbstractViperListPluginUnitTest
{


 	/**
     * Test a list can be converted from one list type to another.
     *
     * @return void
     */
    public function testConvertList()
    {
        $this->useTest(1);
        
        //Convert from unordered to ordered when selecting the whole list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3 %3%</li><li>item 4 %4%</li></ol>');

        //Convert from ordered to unordered when selecting the whole list
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3 %3%</li><li>item 4 %4%</li></ul>');

        //Convert from unordered to ordered when selecting a list item only
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3 %3%</li><li>item 4 %4%</li></ol>');

        //Convert from ordered to unordered when selecting a list item only
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3 %3%</li><li>item 4 %4%</li></ul>');

        //Convert from unordered to ordered when selecting a word
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3 %3%</li><li>item 4 %4%</li></ol>');

        //Convert from ordered to unordered when selecting a word
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3 %3%</li><li>item 4 %4%</li></ul>');

        //Convert from unordered to ordered when clicking in the list
        $this->moveToKeyword(3);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3 %3%</li><li>item 4 %4%</li></ol>');

        //Convert from ordered to unordered when clicking in the list
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%</li><li>item 2 %2%</li><li>item 3 %3%</li><li>item 4 %4%</li></ul>');

    }//end testConvertList()


    /**
     * Test a list can be converted when you select a sub list item and then the master list.
     *
     * @return void
     */
    public function testConvertListWhenSelectingASubListItem()
    {
        $this->useTest(1);

        //Create sub list
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%<ul><li>item 2 %2%</li><li>item 3 %3%</li></ul></li><li>item 4 %4%</li></ul>');

        //Convert master from unordered to ordered
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%<ul><li>item 2 %2%</li><li>item 3 %3%</li></ul></li><li>item 4 %4%</li></ol>');

        //Convert master from ordered to unordered
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%<ul><li>item 2 %2%</li><li>item 3 %3%</li></ul></li><li>item 4 %4%</li></ul>');

    }//end testConvertListFromUnorderedToOrderedWithSubList()


    /**
     * Test that a sub list can be converted to another list type when the master list is an unordered list
     *
     * @return void
     */
    public function testConvertSubListTypeWhenMasterIsUnorderedList()
    {
        $this->useTest(1);

        //Create sub list
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%<ul><li>item 2 %2%</li><li>item 3 %3%</li></ul></li><li>item 4 %4%</li></ul>');

        //Convert sub list from unordered to ordered by selecting the sub list
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%<ol><li>item 2 %2%</li><li>item 3 %3%</li></ol></li><li>item 4 %4%</li></ul>');

        //Convert sub list from ordered to unordered by selecting the sub list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%<ul><li>item 2 %2%</li><li>item 3 %3%</li></ul></li><li>item 4 %4%</li></ul>');

        //Convert sub list from unordered to ordered by selecting the list item
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%<ol><li>item 2 %2%</li><li>item 3 %3%</li></ol></li><li>item 4 %4%</li></ul>');

        //Convert sub list from ordered to unordered by selecting the list item
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%<ul><li>item 2 %2%</li><li>item 3 %3%</li></ul></li><li>item 4 %4%</li></ul>');

        //Convert sub list from unordered to ordered by selecting a word in a list item
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%<ol><li>item 2 %2%</li><li>item 3 %3%</li></ol></li><li>item 4 %4%</li></ul>');

        //Convert sub list from ordered to unordered by selecting a word in a list item
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%<ul><li>item 2 %2%</li><li>item 3 %3%</li></ul></li><li>item 4 %4%</li></ul>');

        //Convert sub list from unordered to ordered by clicking in the list
        $this->moveToKeyword(3);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%<ol><li>item 2 %2%</li><li>item 3 %3%</li></ol></li><li>item 4 %4%</li></ul>');

        //Convert sub list from ordered to unordered by clicking in the lsit
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ul><li>item 1 %1%<ul><li>item 2 %2%</li><li>item 3 %3%</li></ul></li><li>item 4 %4%</li></ul>');

    }//end testConvertSubListTypeWhenMasterIsUnorderedList()


    /**
     * Test that a sub list can be converted to another list type when the master list is an ordered list
     *
     * @return void
     */
    public function testConvertSubListTypeWhenMasterIsOrderedList()
    {
        $this->useTest(2);
        
        //Create sub list
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%<ol><li>item 2 %2%</li><li>item 3 %3%</li></ol></li><li>item 4 %4%</li></ol>');

        //Convert sub list from ordered to unordered by selecting the sub list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%<ul><li>item 2 %2%</li><li>item 3 %3%</li></ul></li><li>item 4 %4%</li></ol>');

        //Convert sub list from unordered to ordered by selecting the sub list
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%<ol><li>item 2 %2%</li><li>item 3 %3%</li></ol></li><li>item 4 %4%</li></ol>');

        //Convert sub list from ordered to unordered by selecting the list item
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%<ul><li>item 2 %2%</li><li>item 3 %3%</li></ul></li><li>item 4 %4%</li></ol>');

        //Convert sub list from unordered to ordered by selecting the list item
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%<ol><li>item 2 %2%</li><li>item 3 %3%</li></ol></li><li>item 4 %4%</li></ol>');

        //Convert sub list from ordered to unordered by selecting a word in a list item
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%<ul><li>item 2 %2%</li><li>item 3 %3%</li></ul></li><li>item 4 %4%</li></ol>');

        //Convert sub list from unordered to ordered by selecting a word in a list item
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%<ol><li>item 2 %2%</li><li>item 3 %3%</li></ol></li><li>item 4 %4%</li></ol>');

        //Convert sub list from ordered to unordered by clicking in the lsit
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%<ul><li>item 2 %2%</li><li>item 3 %3%</li></ul></li><li>item 4 %4%</li></ol>');

        //Convert sub list from unordered to ordered by clicking in the list
        $this->moveToKeyword(3);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>List convert test:</p><ol><li>item 1 %1%<ol><li>item 2 %2%</li><li>item 3 %3%</li></ol></li><li>item 4 %4%</li></ol>');

    }//end testConvertSubListTypeWhenMasterIsOrderedList()


}//end class

?>