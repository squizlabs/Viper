<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_CopyPasteListTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test copy and paste for part of a list.
     *
     * @return void
     */
    public function testCopyAndPastePartOfList()
    {
        //Test unordered list
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>Unordered list %1%</p><ul><li>%2% 1</li><li>item 2</li><li>item 3 %3%</li></ul><p></p><ul><li>item %2% 1</li><li>item 2</li><li>item 3 %3%</li></ul><p>Ordered list %4%</p><ol><li>item %5% 1</li><li>item 2</li><li>item 3 %6%</li></ol>');

        //Test ordered list
        $this->selectKeyword(5, 6);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>Unordered list %1%</p><ul><li>%2% 1</li><li>item 2</li><li>item 3 %3%</li></ul><p></p><ul><li>item %2% 1</li><li>item 2</li><li>item 3 %3%</li></ul><p>Ordered list %4%</p><ol><li>%5% 1</li><li>item 2</li><li>item 3 %6%</li></ol><p></p><ol><li>item %5% 1</li><li>item 2</li><li>item 3 %6%</li></ol>');
    }//end testCopyAndPastePartOfList()


    /**
     * Test copy and paste a list.
     *
     * @return void
     */
    public function testCopyAndPasteAWholeList()
    {
        //Test unordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>Unordered list %1%</p><ul><li>item %2% 1</li><li>item 2</li><li>item 3 %3%</li></ul><p></p><ul><li>item %2% 1</li><li>item 2</li><li>item 3 %3%</li></ul><p>Ordered list %4%</p><ol><li>item %5% 1</li><li>item 2</li><li>item 3 %6%</li></ol>');

        //Test ordered list
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>Unordered list %1%</p><ul><li>item %2% 1</li><li>item 2</li><li>item 3 %3%</li></ul><p></p><ul><li>item %2% 1</li><li>item 2</li><li>item 3 %3%</li></ul><p>Ordered list %4%</p><ol><li>item %5% 1</li><li>item 2</li><li>item 3 %6%</li></ol><p></p><ol><li>item %5% 1</li><li>item 2</li><li>item 3 %6%</li></ol>');
    
    }//end testCopyAndPasteAWholeList()

}//end class

?>
