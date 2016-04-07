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
        $this->useTest(1);

        // Apply subscript using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'subscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <sub>%1%</sub></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <sub>%1%</sub></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <sub>%2%</sub></li><li>item 3</li></ol>');

         // Remove subscript using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <sub>%2%</sub></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testAddAndRemoveSubscriptToWordInListItem()


    /**
     * Test applying subscript to a word a list item.
     *
     * @return void
     */
    public function testAddAndRemoveSubscriptToListItem()
    {
        $this->useTest(1);

        // Apply subscript using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><sub>item 2 %1%</sub></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><sub>item 2 %1%</sub></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><sub>item 2 %2%</sub></li><li>item 3</li></ol>');

         // Remove subscript using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><sub>item 2 %2%</sub></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testAddAndRemoveSubscriptToListItem()


    /**
     * Test applying subscript to a word a list.
     *
     * @return void
     */
    public function testAddAndRemoveSubscriptToListA()
    {
        $this->useTest(1);

        // Apply subscript using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li><sub>item 1</sub></li><li><sub>item 2 %1%</sub></li><li><sub>item 3</sub></li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('subscript');
        $this->assertTrue($this->topToolbarButtonExists('subscript', 'active'), 'Subscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li><sub>item 1</sub></li><li><sub>item 2 %1%</sub></li><li><sub>item 3</sub></li></ul><p>Ordered list:</p><ol><li><sub>item 1</sub></li><li><sub>item 2 %2%</sub></li><li><sub>item 3</sub></li></ol>');

         // Remove subscript using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li><sub>item 1</sub></li><li><sub>item 2 %2%</sub></li><li><sub>item 3</sub></li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('subscript'), 'Subscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testAddAndRemoveSubscriptToListItem()


      /**
     * Test deleting content from unordered lists including subscript formating
     *
     * @return void
     */
    public function testDeletingSubscriptContentFromUnorderedLists()
    {
        // Check deleting a word after the subscript content
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% <sub>test</sub></li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% <sub>testcontent</sub></li></ul>');

        // Check deleting from the end of the list item including subscript content
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% content</li></ul>');

        // Check deleting from the start of the list item
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li><sub>test</sub> %2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li><sub>contenttest</sub> %2%</li></ul>');

        // Check deleting from the start of the list item including subscript content
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>content %2%</li></ul>');

    }//end testDeletingSubscriptContentFromUnorderedLists()


    /**
     * Test deleting content from ordered lists including subscript formating
     *
     * @return void
     */
    public function testDeletingSubscriptContentFromOrderedLists()
    {
        // Check deleting a word after the stirkethrough content
        $this->useTest(3);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% <sub>test</sub></li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% <sub>testcontent</sub></li></ol>');

        // Check deleting from the end of the list item including stirkethrough content
        $this->useTest(3);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% content</li></ol>');

        // Check deleting from the start of the list item
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li><sub>test</sub> %2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li><sub>contenttest</sub> %2%</li></ol>');

        // Check deleting from the start of the paragraph including stirkethrough content
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>content %2%</li></ol>');

    }//end testDeletingSubscriptContentFromOrderedLists()

}//end class

?>
