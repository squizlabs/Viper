<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_SubscriptInListsUnitTest extends AbstractViperUnitTest
{


    /**
     * Test applying subscript to a word in a list.
     *
     * @return void
     */
    public function testAddAndRemoveSubscriptToWordInListItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }


            // Apply subscript
            $this->selectKeyword(1);
            $this->clickTopToolbarButton('subscript');
            $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'subscript icon in the top toolbar is not active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 <sub>%1%</sub></li><li>item 3</li><li><sub>item 4 %2%</sub></li><li>item 5</li></'.$listType.'>');

             // Remove subscript
            $this->selectKeyword(1);
            $this->clickTopToolbarButton('subscript', 'active');
            $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><sub>item 4 %2%</sub></li><li>item 5</li></'.$listType.'>');
        }

    }//end testAddAndRemoveSubscriptToWordInListItem()


    /**
     * Test applying subscript to a list item.
     *
     * @return void
     */
    public function testAddAndRemoveSubscriptToListItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            // Apply subscript
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(1);
            $this->clickTopToolbarButton('subscript');
            $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li><sub>item 2 %1%</sub></li><li>item 3</li><li><sub>item 4 %2%</sub></li><li>item 5</li></'.$listType.'>');

             // Remove subscript
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(1);
            $this->clickTopToolbarButton('subscript', 'active');
            $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><sub>item 4 %2%</sub></li><li>item 5</li></'.$listType.'>');
        }

    }//end testAddAndRemoveSubscriptToListItem()


    /**
     * Test applying subscript to all items in the list.
     *
     * @return void
     */
    public function testAddAndRemoveSubscriptToListAllItems()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            // Apply subscript
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(0);
            $this->clickTopToolbarButton('subscript');
            $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><sub>item 1</sub></li><li><sub>item 2 %1%</sub></li><li><sub>item 3</sub></li><li><sub>item 4 %2%</sub></li><li><sub>item 5</sub></li></'.$listType.'>');

             // Remove subscript
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(0);
            $this->clickTopToolbarButton('subscript', 'active');
            $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li>item 4 %2%</li><li>item 5</li></'.$listType.'>');
        }

    }//end testAddAndRemoveSubscriptToListAllItems()


    /**
     * Test that creating new list items after a subscript formatted list item.
     *
     * @return void
     */
    public function testCreatingNewListItemAfterASubscriptItem()
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
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><sub>item 4 %2%</sub></li><li><sub>new item</sub></li><li>item 5</li></'.$listType.'>');
        }

    }//end testCreatingNewListItemAfterASubscriptItem()


    /**
     * Test deleting content from lists including subscript formating
     *
     * @return void
     */
    public function testDeletingSubscriptContentFromLists()
    {
        // Check deleting a word after the subscript content
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
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% <sub>test</sub></li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% <sub>testcontent</sub></li></'.$listType.'>');
        }

        // Check deleting from the end of the list item including subscript content
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

        // Check deleting from the start of the list item
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
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><sub>test</sub> %2%</li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><sub>contenttest</sub> %2%</li></'.$listType.'>');
        }

        // Check deleting from the start of the list item including subscript content
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

    }//end testDeletingSubscriptContentFromLists()

}//end class

?>
