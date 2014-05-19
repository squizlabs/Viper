<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_AnchorInListsUnitTest extends AbstractViperUnitTest
{
    /**
     * Test that applying and removing an anchor to a word in a list item.
     *
     * @return void
     */
    public function testApplyAndRemoveAnchorToWordInListItem()
    {

        // Apply anchor using the inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <span id="test1">%1%</span></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test2');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <span id="test1">%1%</span></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <span id="test2">%2%</span></li><li>item 3</li></ol>');

        // Remove anchor using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <span id="test2">%2%</span></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

         // Apply anchor using the top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <span id="test1">%1%</span></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test2');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <span id="test1">%1%</span></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <span id="test2">%2%</span></li><li>item 3</li></ol>');

        // Remove anchor using inline toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <span id="test2">%2%</span></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testApplyAndRemoveAnchorToWordInListItem()


    /**
     * Test that applying and removing an anchor to a list item.
     *
     * @return void
     */
    public function testApplyAndRemoveAnchorToListItem()
    {

        // Apply anchor using the inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li id="test1">item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test2');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li id="test1">item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li id="test2">item 2 %2%</li><li>item 3</li></ol>');

        // Remove anchor using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li id="test2">item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

         // Apply anchor using the top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li id="test1">item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test2');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li id="test1">item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li id="test2">item 2 %2%</li><li>item 3</li></ol>');

        // Remove anchor using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li id="test2">item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testApplyAndRemoveAnchorToListItem()


    /**
     * Test that applying and removing an anchor to a list.
     *
     * @return void
     */
    public function testApplyAndRemoveAnchorToList()
    {

        // Apply anchor using the inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul id="test1"><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test2');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul id="test1"><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol id="test2"><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Remove anchor using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol id="test2"><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

         // Apply anchor using the top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul id="test1"><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test2');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul id="test1"><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol id="test2"><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Remove anchor using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol id="test2"><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testApplyAndRemoveAnchorToWordInListItem()

}//end class

?>
