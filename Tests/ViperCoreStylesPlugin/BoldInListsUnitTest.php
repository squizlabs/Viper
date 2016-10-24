<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_BoldInListsUnitTest extends AbstractViperUnitTest
{


    /**
     * Test applying bold to a word in a list.
     *
     * @return void
     */
    public function testAddAndRemoveBoldToWordInListItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                } else {
                    $this->useTest(2);
                }

                $this->selectKeyword(1);
                $this->doAction($method, 'bold');
                $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
                $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 <strong>%1%</strong></li><li>item 3</li><li><strong>item 4 %2%</strong></li><li>item 5</li></'.$listType.'>');

                // Remove bold
                $this->selectKeyword(1);
                $this->doAction($method, 'bold', 'active');
                $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
                $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><strong>item 4 %2%</strong></li><li>item 5</li></'.$listType.'>');
            }
        }

    }//end testAddAndRemoveBoldToWordInListItem()


    /**
     * Test applying bold to an item in the list
     *
     * @return void
     */
    public function testAddAndRemoveBoldToListItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                } else {
                    $this->useTest(2);
                }

                $this->selectKeyword(1);
                $this->selectInlineToolbarLineageItem(1);
                $this->doAction($method, 'bold');
                sleep(1);
                $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
                $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li><strong>item 2 %1%</strong></li><li>item 3</li><li><strong>item 4 %2%</strong></li><li>item 5</li></'.$listType.'>');

                // Remove bold
                $this->selectKeyword(1);
                $this->selectInlineToolbarLineageItem(1);
                $this->doAction($method, 'bold', 'active');
                $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
                $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><strong>item 4 %2%</strong></li><li>item 5</li></'.$listType.'>');
            }
        }

    }//end testAddAndRemoveBoldToListItem()


    /**
     * Test applying bold to all items in the list.
     *
     * @return void
     */
    public function testAddAndRemoveBoldToAllItemsInList()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, FALSE, TRUE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                } else {
                    $this->useTest(2);
                }

                $this->selectKeyword(1);
                $this->selectInlineToolbarLineageItem(0);
                $this->doAction($method, 'bold');
                $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');

                // Make sure the bold icon does not appear in the inline toolbar
                $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon is in the inline toolbar is not active');
                $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active bold icon appears in the inline toolbar');
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><strong>item 1</strong></li><li><strong>item 2 %1%</strong></li><li><strong>item 3</strong></li><li><strong>item 4 %2%</strong></li><li><strong>item 5</strong></li></'.$listType.'>');

                $this->selectKeyword(1);
                $this->selectInlineToolbarLineageItem(0);
                $this->doAction($method, 'bold', 'active');
                $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li>item 4 %2%</li><li>item 5</li></'.$listType.'>');
            }
        }

    }//end testAddAndRemoveBoldToAllItemsInList()


    /**
     * Test that creating new list items after a bold formatted list item functions correctly.
     *
     * @return void
     */
    public function testCreatingNewListItemAfterABoldItem()
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
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><strong>item 4 %2%</strong></li><li><strong>new item</strong></li><li>item 5</li></'.$listType.'>');
        } 

    }//end testCreatingNewListItemAfterABoldItem()


    /**
     * Test deleting content from lists including bold formating
     *
     * @return void
     */
    public function testDeletingBoldContentFromLists()
    {
        // Check deleting a word after the bold content in a list item
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
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% <strong>test</strong></li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% <strong>testcontent</strong></li></'.$listType.'>');
        }

        // Check deleting from the end of the paragraph including bold content
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
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><strong>test</strong> %2%</li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><strong>contenttest</strong> %2%</li></'.$listType.'>');
        }

        // Check deleting from the start of the list item including bold content
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

    }//end testDeletingBoldContentFromLists()

}//end class

?>
