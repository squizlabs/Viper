<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_StrikethroughInListsUnitTest extends AbstractViperUnitTest
{

    /**
     * Test applying strikethrough to a word in a list.
     *
     * @return void
     */
    public function testAddAndRemoveStrikethroughToWordInListItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            // Apply strikethrough
            $this->selectKeyword(1);
            $this->clickTopToolbarButton('strikethrough');
            $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'strikethrough icon in the top toolbar is not active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 <del>%1%</del></li><li>item 3</li><li><del>item 4 %2%</del></li><li>item 5</li></'.$listType.'>');

            // Remove strikethrough
            $this->selectKeyword(1);
            $this->clickTopToolbarButton('strikethrough', 'active');
            $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><del>item 4 %2%</del></li><li>item 5</li></'.$listType.'>');
        }

    }//end testAddAndRemoveStrikethroughToWordInListItem()


    /**
     * Test applying strikethrough to a list item.
     *
     * @return void
     */
    public function testAddAndRemoveStrikethroughToListItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            // Apply strikethrough 
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(1);
            $this->clickTopToolbarButton('strikethrough');
            $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li><del>item 2 %1%</del></li><li>item 3</li><li><del>item 4 %2%</del></li><li>item 5</li></'.$listType.'>');

             // Remove strikethrough
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(1);
            $this->clickTopToolbarButton('strikethrough', 'active');
            $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><del>item 4 %2%</del></li><li>item 5</li></'.$listType.'>');
        }

    }//end testAddAndRemoveStrikethroughToListItem()


    /**
     * Test applying strikethrough to all items in the list.
     *
     * @return void
     */
    public function testAddAndRemoveStrikethroughToAllListItems()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            // Apply strikethrough
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(0);
            $this->clickTopToolbarButton('strikethrough');
            $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><del>item 1</del></li><li><del>item 2 %1%</del></li><li><del>item 3</del></li><li><del>item 4 %2%</del></li><li><del>item 5</del></li></'.$listType.'>');

             // Remove strikethrough
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(0);
            $this->clickTopToolbarButton('strikethrough', 'active');
            $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li>item 4 %2%</li><li>item 5</li></'.$listType.'>');
        }

    }//end testAddAndRemoveStrikethroughToAllListItems()


    /**
     * Test that creating new list items after a strikethrough formatted list item.
     *
     * @return void
     */
    public function testCreatingNewListItemAfterAStrikethroughItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            $this->moveToKeyword(2, 'right');
            $this->sikuli->keyDown('Key.ENTER');
            sleep(1);
            $this->type('new item');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><del>item 4 %2%</del></li><li><del>new item</del></li><li>item 5</li></'.$listType.'>');
        }

    }//end testCreatingNewListItemAfterAStrikethroughItem()


    /**
     * Test deleting content from lists including strikethrough formating
     *
     * @return void
     */
    public function testDeletingStrikethroughContentFromLists()
    {
        // Check deleting a word after the strikethrough content
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(3);
            } else {
                $this->useTest(4);
            }

            $this->moveToKeyword(2, 'right');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% <del>test</del></li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% <del>testcontent</del></li></'.$listType.'>');
        }

        // Check deleting from the end of the list item including strikethrough content
         foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(3);
            } else {
                $this->useTest(4);
            }

            $this->moveToKeyword(2, 'right');

            for ($i = 0; $i < 8; $i++) {
                $this->sikuli->keyDown('Key.BACKSPACE');
            }

            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1%</li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% content</li></'.$listType.'>');
        }

        // Check deleting from the list item of the paragraph
         foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(3);
            } else {
                $this->useTest(4);
            }

            $this->moveToKeyword(1, 'left');
            $this->sikuli->keyDown('Key.DELETE');
            $this->sikuli->keyDown('Key.DELETE');
            $this->sikuli->keyDown('Key.DELETE');
            $this->sikuli->keyDown('Key.DELETE');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><del>test</del> %2%</li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><del>contenttest</del> %2%</li></'.$listType.'>');
        }

        // Check deleting from the start of the list item including strikethrough content
         foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(3);
            } else {
                $this->useTest(4);
            }

            $this->moveToKeyword(1, 'left');

            for ($i = 0; $i < 8; $i++) {
                $this->sikuli->keyDown('Key.DELETE');
            }

            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%2%</li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>content %2%</li></'.$listType.'>');
        }


    }//end testDeletingStrikethroughContentFromLists()

}//end class

?>
