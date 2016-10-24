<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_ItalicInListsUnitTest extends AbstractViperUnitTest
{


    /**
     * Test applying italic to a word in a list.
     *
     * @return void
     */
    public function testAddAndRemoveItalicToWordInListItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                } else {
                    $this->useTest(2);
                }

                // Apply italic
                $this->selectKeyword(1);
                $this->doAction($method,'italic');
                $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
                $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 <em>%1%</em></li><li>item 3</li><li><em>item 4 %2%</em></li><li>item 5</li></'.$listType.'>');

                // Remove italic
                $this->selectKeyword(1);
                $this->doAction($method, 'italic', 'active');
                $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
                $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><em>item 4 %2%</em></li><li>item 5</li></'.$listType.'>');
            }
        }

    }//end testAddAndRemoveItalicToWordInListItem()


    /**
     * Test applying italic to an item in the list.
     *
     * @return void
     */
    public function testAddAndRemoveItalicToListItem()
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
                sleep(1);
                $this->doAction($method, 'italic');
                sleep(1);
                $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
                $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li><em>item 2 %1%</em></li><li>item 3</li><li><em>item 4 %2%</em></li><li>item 5</li></'.$listType.'>');

                // Remove italic
                $this->selectKeyword(1);
                $this->selectInlineToolbarLineageItem(1);
                sleep(1);
                $this->doAction($method, 'italic', 'active');
                $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
                $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><em>item 4 %2%</em></li><li>item 5</li></'.$listType.'>');
            }
        }

    }//end testAddAndRemoveItalicToListItem()


    /**
     * Test applying italic to all items in the list.
     *
     * @return void
     */
    public function testAddAndRemoveItalicToAllItemsInList()
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
                $this->doAction($method, 'italic');
                $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
                // Make sure the italic icon does not appear in the inline toolbar
                $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon is in the inline toolbar is not active');
                $this->assertFalse($this->inlineToolbarButtonExists('italic', 'active'), 'Active italic icon appears in the inline toolbar');
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><em>item 1</em></li><li><em>item 2 %1%</em></li><li><em>item 3</em></li><li><em>item 4 %2%</em></li><li><em>item 5</em></li></'.$listType.'>');

                // Remove italic
                $this->selectKeyword(1);
                $this->selectInlineToolbarLineageItem(0);
                $this->clickTopToolbarButton('italic', 'active');
                $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li>item 4 %2%</li><li>item 5</li></'.$listType.'>');
            }
        }

    }//end testAddAndRemoveItalicToAllItemsInList()


    /**
     * Test that creating new list items after an italic formatted list item functions correctly.
     *
     * @return void
     */
    public function testCreatingNewListItemAfterAnItalicItem()
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
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><em>item 4 %2%</em></li><li><em>new item</em></li><li>item 5</li></'.$listType.'>');
        } 

    }//end testCreatingNewListItemAfterAnItalicItem()


    /**
     * Test deleting content from lists including italic formating
     *
     * @return void
     */
    public function testDeletingItalicContentFromLists()
    {
        // Check deleting a word after the italic content in a list item
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
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% <em>test</em></li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% <em>testcontent</em></li></'.$listType.'>');
        }

        // Check deleting from the end of the list item including italic content
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
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><em>test</em> %2%</li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><em>contenttest</em> %2%</li></'.$listType.'>');
        }

        // Check deleting from the start of the list item including italic content
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

    }//end testDeletingItalicContentFromLists()

}//end class

?>
