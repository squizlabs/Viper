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
        $this->useTest(1);

        // Apply bold using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <strong>%1%</strong></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <strong>%1%</strong></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <strong>%2%</strong></li><li>item 3</li></ol>');

        // Remove bold using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <strong>%2%</strong></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply bold using top toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <strong>%1%</strong></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <strong>%1%</strong></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <strong>%2%</strong></li><li>item 3</li></ol>');

         // Remove bold using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <strong>%2%</strong></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply bold using keyboard shortcuts
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <strong>%1%</strong></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <strong>%1%</strong></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <strong>%2%</strong></li><li>item 3</li></ol>');

         // Remove bold using top toolbar
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <strong>%2%</strong></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testAddAndRemoveBoldToWordInListItem()


    /**
     * Test applying bold to a word a list item.
     *
     * @return void
     */
    public function testAddAndRemoveBoldToListItem()
    {
        $this->useTest(1);

        // Apply bold using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><strong>item 2 %1%</strong></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><strong>item 2 %1%</strong></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><strong>item 2 %2%</strong></li><li>item 3</li></ol>');

        // Remove bold using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><strong>item 2 %2%</strong></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply bold using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><strong>item 2 %1%</strong></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><strong>item 2 %1%</strong></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><strong>item 2 %2%</strong></li><li>item 3</li></ol>');

         // Remove bold using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><strong>item 2 %2%</strong></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply bold using keyboard shortcuts
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><strong>item 2 %1%</strong></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('bold', 'active'), 'Bold icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><strong>item 2 %1%</strong></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><strong>item 2 %2%</strong></li><li>item 3</li></ol>');

        // Remove bold using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><strong>item 2 %2%</strong></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('bold'), 'Bold icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testAddAndRemoveBoldToListItem()


    /**
     * Test applying bold to a word a list.
     *
     * @return void
     */
    public function testAddAndRemoveBoldToList()
    {
        $this->useTest(1);

        // Apply bold using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        // Make sure the bold icon does not appear in the inline toolbar
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon is in the inline toolbar is not active');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active bold icon appears in the inline toolbar');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li><strong>item 1</strong></li><li><strong>item 2 %1%</strong></li><li><strong>item 3</strong></li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        // Make sure the bold icon does not appear in the inline toolbar
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon is in the inline toolbar is not active');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active bold icon appears in the inline toolbar');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li><strong>item 1</strong></li><li><strong>item 2 %1%</strong></li><li><strong>item 3</strong></li></ul><p>Ordered list:</p><ol><li><strong>item 1</strong></li><li><strong>item 2 %2%</strong></li><li><strong>item 3</strong></li></ol>');

         // Remove bold using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li><strong>item 1</strong></li><li><strong>item 2 %2%</strong></li><li><strong>item 3</strong></li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply bold using keyboard shortcuts
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        // Make sure the bold icon does not appear in the inline toolbar
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon is in the inline toolbar is not active');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active bold icon appears in the inline toolbar');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li><strong>item 1</strong></li><li><strong>item 2 %1%</strong></li><li><strong>item 3</strong></li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        // Make sure the bold icon does not appear in the inline toolbar
        $this->assertFalse($this->inlineToolbarButtonExists('bold'), 'Bold icon is in the inline toolbar is not active');
        $this->assertFalse($this->inlineToolbarButtonExists('bold', 'active'), 'Active bold icon appears in the inline toolbar');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li><strong>item 1</strong></li><li><strong>item 2 %1%</strong></li><li><strong>item 3</strong></li></ul><p>Ordered list:</p><ol><li><strong>item 1</strong></li><li><strong>item 2 %2%</strong></li><li><strong>item 3</strong></li></ol>');

        // Remove bold using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li><strong>item 1</strong></li><li><strong>item 2 %2%</strong></li><li><strong>item 3</strong></li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testAddAndRemoveBoldToListItem()


    /**
     * Test deleting content from unordered lists including bold formating
     *
     * @return void
     */
    public function testDeletingBoldContentFromUnorderedLists()
    {
        // Check deleting a word after the bold content in a list item
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% <strong>test</strong></li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% <strong>testcontent</strong></li></ul>');

        // Check deleting from the end of the paragraph including bold content
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
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li><strong>test</strong> %2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li><strong>contenttest</strong> %2%</li></ul>');

        // Check deleting from the start of the list item including bold content
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>content %2%</li></ul>');

    }//end testDeletingBoldContentFromUnorderedLists()


     /**
     * Test deleting content from ordered lists including bold formating
     *
     * @return void
     */
    public function testDeletingBoldContentFromOrderedLists()
    {
        // Check deleting a word after the bold content in a list item
        $this->useTest(3);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% <strong>test</strong></li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% <strong>testcontent</strong></li></ol>');

        // Check deleting from the end of the list item including bold content
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
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li><strong>test</strong> %2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li><strong>contenttest</strong> %2%</li></ol>');

        // Check deleting from the start of the paragraph including bold content
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>content %2%</li></ol>');

    }//end testDeletingBoldContentFromOrderedLists()

}//end class

?>
