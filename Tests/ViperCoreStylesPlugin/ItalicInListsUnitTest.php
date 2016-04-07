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
        $this->useTest(1);

        // Apply italic using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <em>%1%</em></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <em>%1%</em></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <em>%2%</em></li><li>item 3</li></ol>');

        // Remove italic using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <em>%2%</em></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply italic using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <em>%1%</em></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <em>%1%</em></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <em>%2%</em></li><li>item 3</li></ol>');

         // Remove italic using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <em>%2%</em></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply italic using keyboard shortcuts
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <em>%1%</em></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <em>%1%</em></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <em>%2%</em></li><li>item 3</li></ol>');

         // Remove italic using top toolbar
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <em>%2%</em></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testAddAndRemoveItalicToWordInListItem()


    /**
     * Test applying italic to a word a list item.
     *
     * @return void
     */
    public function testAddAndRemoveItalicToListItem()
    {
        $this->useTest(1);

        // Apply italic using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><em>item 2 %1%</em></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickInlineToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><em>item 2 %1%</em></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><em>item 2 %2%</em></li><li>item 3</li></ol>');

        // Remove italic using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><em>item 2 %2%</em></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply italic using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><em>item 2 %1%</em></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><em>item 2 %1%</em></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><em>item 2 %2%</em></li><li>item 3</li></ol>');

         // Remove italic using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><em>item 2 %2%</em></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply italic using keyboard shortcuts
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><em>item 2 %1%</em></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('italic', 'active'), 'Italic icon in the inline toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><em>item 2 %1%</em></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><em>item 2 %2%</em></li><li>item 3</li></ol>');

        // Remove italic using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><em>item 2 %2%</em></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertTrue($this->inlineToolbarButtonExists('italic'), 'Italic icon in the inline toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testAddAndRemoveItalicToListItem()


    /**
     * Test applying italic to a word a list.
     *
     * @return void
     */
    public function testAddAndRemoveItalicToList()
    {
        $this->useTest(1);

        // Apply italic using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        // Make sure the italic icon does not appear in the inline toolbar
        $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon is in the inline toolbar is not active');
        $this->assertFalse($this->inlineToolbarButtonExists('italic', 'active'), 'Active italic icon appears in the inline toolbar');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li><em>item 1</em></li><li><em>item 2 %1%</em></li><li><em>item 3</em></li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('italic');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        // Make sure the italic icon does not appear in the inline toolbar
        $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon is in the inline toolbar is not active');
        $this->assertFalse($this->inlineToolbarButtonExists('italic', 'active'), 'Active italic icon appears in the inline toolbar');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li><em>item 1</em></li><li><em>item 2 %1%</em></li><li><em>item 3</em></li></ul><p>Ordered list:</p><ol><li><em>item 1</em></li><li><em>item 2 %2%</em></li><li><em>item 3</em></li></ol>');

         // Remove italic using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li><em>item 1</em></li><li><em>item 2 %2%</em></li><li><em>item 3</em></li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        // Apply italic using keyboard shortcuts
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        // Make sure the italic icon does not appear in the inline toolbar
        $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon is in the inline toolbar is not active');
        $this->assertFalse($this->inlineToolbarButtonExists('italic', 'active'), 'Active italic icon appears in the inline toolbar');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li><em>item 1</em></li><li><em>item 2 %1%</em></li><li><em>item 3</em></li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        // Make sure the italic icon does not appear in the inline toolbar
        $this->assertFalse($this->inlineToolbarButtonExists('italic'), 'Italic icon is in the inline toolbar is not active');
        $this->assertFalse($this->inlineToolbarButtonExists('italic', 'active'), 'Active italic icon appears in the inline toolbar');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li><em>item 1</em></li><li><em>item 2 %1%</em></li><li><em>item 3</em></li></ul><p>Ordered list:</p><ol><li><em>item 1</em></li><li><em>item 2 %2%</em></li><li><em>item 3</em></li></ol>');

        // Remove italic using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li><em>item 1</em></li><li><em>item 2 %2%</em></li><li><em>item 3</em></li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + i');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testAddAndRemoveItalicToListItem()


    /**
     * Test deleting content from unordered lists including italic formating
     *
     * @return void
     */
    public function testDeletingItalicContentFromUnorderedLists()
    {
        // Check deleting a word after the italic content in a list item
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% <em>test</em></li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% <em>testcontent</em></li></ul>');

        // Check deleting from the end of the list item including italic content
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
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li><em>test</em> %2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li><em>contenttest</em> %2%</li></ul>');

        // Check deleting from the start of the list item including italic content
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>content %2%</li></ul>');

    }//end testDeletingItalicContentFromUnorderedLists()


    /**
     * Test deleting content from ordered lists including italic formating
     *
     * @return void
     */
    public function testDeletingItalicContentFromOrderedLists()
    {
        // Check deleting a word after the italic content
        $this->useTest(3);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% <em>test</em></li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% <em>testcontent</em></li></ol>');

        // Check deleting from the end of the paragraph including italic content
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
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li><em>test</em> %2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li><em>contenttest</em> %2%</li></ol>');

        // Check deleting from the start of the paragraph including italic content
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>content %2%</li></ol>');

    }//end testDeletingItalicContentFromOrderedLists()

}//end class

?>
