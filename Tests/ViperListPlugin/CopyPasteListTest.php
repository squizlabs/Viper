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
        $this->useTest(1);

        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>Unordered list %1%</p><ul><li>%2% 1</li><li>item 2</li><li>item 3 %3%</li></ul><ul><li>item %2% 1</li><li>item 2</li><li>item 3 %3%</li></ul>');

        //Test ordered list
        $this->useTest(2);
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>Ordered list %1%</p><ol><li>%2% 1</li><li>item 2</li><li>item 3 %3%</li></ol><ol><li>item %2% 1</li><li>item 2</li><li>item 3 %3%</li></ol>');

    }//end testCopyAndPastePartOfList()


    /**
     * Test copy and paste a list.
     *
     * @return void
     */
    public function testCopyAndPasteWholeList()
    {
        //Test unordered list
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);

        $this->assertHTMLMatch('<p>Unordered list %1%</p><ul><li>item %2% 1</li><li>item 2</li><li>item 3 %3%</li></ul><ul><li>item %2% 1</li><li>item 2</li><li>item 3 %3%</li></ul>');

        //Test ordered list
        $this->useTest(2);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>Ordered list %1%</p><ol><li>item %2% 1</li><li>item 2</li><li>item 3 %3%</li></ol><ol><li>item %2% 1</li><li>item 2</li><li>item 3 %3%</li></ol>');
    
    }//end testCopyAndPasteWholeList()

}//end class

?>
