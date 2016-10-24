<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_SuperscriptInListsUnitTest extends AbstractViperUnitTest
{


    /**
     * Test applying superscript to a word in a list.
     *
     * @return void
     */
    public function testAddAndRemoveSuperscriptToWordInListItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            // Apply superscript
            $this->selectKeyword(1);
            $this->clickTopToolbarButton('superscript');
            $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'superscript icon in the top toolbar is not active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 <sup>%1%</sup></li><li>item 3</li><li><sup>item 4 %2%</sup></li><li>item 5</li></'.$listType.'>');

             // Remove superscript
            $this->selectKeyword(1);
            $this->clickTopToolbarButton('superscript', 'active');
            $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><sup>item 4 %2%</sup></li><li>item 5</li></'.$listType.'>');
        }

    }//end testAddAndRemoveSuperscriptToWordInListItem()


    /**
     * Test applying superscript to a list item.
     *
     * @return void
     */
    public function testAddAndRemoveSuperscriptToListItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            // Apply superscript
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(1);
            $this->clickTopToolbarButton('superscript');
            $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li><sup>item 2 %1%</sup></li><li>item 3</li><li><sup>item 4 %2%</sup></li><li>item 5</li></'.$listType.'>');

             // Remove superscript
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(1);
            $this->clickTopToolbarButton('superscript', 'active');
            $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><sup>item 4 %2%</sup></li><li>item 5</li></'.$listType.'>');
        }

    }//end testAddAndRemoveSuperscriptToListItem()


    /**
     * Test applying superscript to all items in the list.
     *
     * @return void
     */
    public function testAddAndRemoveSuperscriptToList()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            // Apply superscript
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(0);
            $this->clickTopToolbarButton('superscript');
            $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><sup>item 1</sup></li><li><sup>item 2 %1%</sup></li><li><sup>item 3</sup></li><li><sup>item 4 %2%</sup></li><li><sup>item 5</sup></li></'.$listType.'>');

             // Remove superscript
            $this->selectKeyword(1);
            $this->selectInlineToolbarLineageItem(0);
            $this->clickTopToolbarButton('superscript', 'active');
            $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is active');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li>item 4 %2%</li><li>item 5</li></'.$listType.'>');
        }

    }//end testAddAndRemoveSuperscriptToListItem()


    /**
     * Test that creating new list items after a superscript formatted list item.
     *
     * @return void
     */
    public function testCreatingNewListItemAfterASuperscriptItem()
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
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>item 1</li><li>item 2 %1%</li><li>item 3</li><li><sup>item 4 %2%</sup></li><li><sup>new item</sup></li><li>item 5</li></'.$listType.'>');
        }

    }//end testCreatingNewListItemAfterASuperscriptItem()


    /**
     * Test deleting content from lists including superscript formating
     *
     * @return void
     */
    public function testDeletingSuperscriptContentFromLists()
    {
        // Check deleting a word after the superscript content
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
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% <sup>test</sup></li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% <sup>testcontent</sup></li></'.$listType.'>');
        }

        // Check deleting from the end of the list item including superscript content
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

        // Check deleting from the start of the paragraph
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
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><sup>test</sup> %2%</li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li><sup>contenttest</sup> %2%</li></'.$listType.'>');
        }

        // Check deleting from the start of the list item including superscript content
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

    }//end testDeletingSuperscriptContentFromLists()

}//end class

?>
