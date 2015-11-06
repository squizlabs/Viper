<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_DeleteContentUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that when you delete all of the content, enter new content and delete the last 3 words that the other content remains.
     *
     * @return void
     */
    public function testDeletingNewContent()
    {
        $this->useTest(1);

        // Select all content, delete it and replace with new content
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->type('Content');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('This is a line of content to delete the last three %1% words %2%');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(2);
        $this->assertHTMLMatch('<p>Content</p><p>This is a line of content to delete the last three %1% words %2%</p>');

        // Select the last 3 words and delete them
        $this->selectKeyword(1, 2);
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertHTMLMatch('<p>Content</p><p>This is a line of content to delete the last three</p>');

    }//end testDeletingNewContent()


    /**
     * Test Delete and Backspace.
     *
     * @return void
     */
    public function testDeleteAndBackspace()
    {
        // Test delete
        $this->useTest(1);

        $this->moveToKeyword(1, 'left');
        sleep(1);

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->type('test');
        $this->assertHTMLMatch('<p>Content testMOZ %2%</p>');

        // Test backspace
        $this->useTest(1);

        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->type('test');
        $this->assertHTMLMatch('<p>Content %1%</p><p>EIBtest</p>');

    }//end testDeleteAndBackspace()


    /**
     * Test deleting a line of content in a paragraph.
     *
     * @return void
     */
    public function testDeletingContentBeforeBRTag()
    {
        // Delete the content before the BR using Shit + down key then add new content
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');
        sleep(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        sleep(2);
        $this->sikuli->keyDown('Key.DELETE');
        sleep(2);
        $this->type('New content in paragraph');
        $this->assertHTMLMatch('<p>Some content here</p><p>New content in paragraphThis is the first line of content.<br />This is the second line of content.</p><p>Another paragraph</p>');

        // Delete the content before the BR using the delete key
        $this->useTest(11);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('New content in paragraph');
        $this->assertHTMLMatch('<p>Some content here</p><p>Content New content in paragraphThis is the first line of content.<br />This is the second line of content.</p><p>Another paragraph</p>');

    }//end testDeletingContentBeforeBRTag()


    /**
     * Test deleting a paragraph by pressing backspace and delete.
     *
     * @return void
     */
    public function testDeletingParagraph()
    {
        // Check deleting a paragraph with backspace
        $this->useTest(3);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');

        for ($i = 0; $i < 12; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>some content</p><p>a</p>');

        // Add content to check the position of the cursor
        $this->type(' New content in paragraph');
        $this->assertHTMLMatch('<p>some content</p><p>a New content in paragraph</p>');

        // Check deleting a paragraph with delete
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 12; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>some content</p><p>a</p>');

        // Add content to check the position of the cursor
        $this->type('New content in paragraph');
        $this->assertHTMLMatch('<p>some content</p><p>a</p><p>New content in paragraph</p>');

    }//end testDeletingParagraph()


    /**
     * Test deleting content including content with bold formatting
     *
     * @return void
     */
    public function testDeletingContentWithBoldFormatting()
    {
        // Check deleting a word after the bold content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% <strong>test</strong></p>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari' || $this->sikuli->getBrowserid() === 'ie9') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<p>%1% <strong>testcontent</strong></p>');
        } else {
            $this->assertHTMLMatch('<p>%1% <strong>test</strong>content</p>');
        }

        // Check deleting from the end of the paragraph including bold content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>%1%</p>');
        sleep(1);

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% content</p>');

        // Check deleting from the start of the paragraph
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p><strong>test</strong> %2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content <strong>test</strong> %2%</p>');

        // Check deleting from the start of the paragraph including bold content
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>%2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content %2%</p>');

    }//end testDeletingContentWithBoldFormatting()


    /**
     * Test deleting content including content with italic formatting
     *
     * @return void
     */
    public function testDeletingContentWithItalicFormatting()
    {
        // Check deleting a word after the italic content
        $this->useTest(5);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% <em>test</em></p>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<p>%1% <em>testcontent</em></p>');
        } else {
            $this->assertHTMLMatch('<p>%1% <em>test</em>content</p>');
        }

        // Check deleting from the end of the paragraph including italic content
        $this->useTest(5);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>%1%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% content</p>');

        // Check deleting from the start of the paragraph
        $this->useTest(5);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p><em>test</em> %2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content<em>test</em> %2%</p>');

        // Check deleting from the start of the paragraph including italic content
        $this->useTest(5);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>%2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content %2%</p>');

    }//end testDeletingContentWithItalicFormatting()


    /**
     * Test deleting content including content with strikethrough formatting
     *
     * @return void
     */
    public function testDeletingContentWithStrikethroughFormatting()
    {
        // Check deleting a word after the strikethrough content
        $this->useTest(6);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% <del>test</del></p>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<p>%1% <del>testcontent</del></p>');
        } else {
            $this->assertHTMLMatch('<p>%1% <del>test</del>content</p>');
        }

        // Check deleting from the end of the paragraph including strikethrough content
        $this->useTest(6);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>%1%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% content</p>');

        // Check deleting from the start of the paragraph
        $this->useTest(6);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p><del>test</del> %2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content<del>test</del> %2%</p>');

        // Check deleting from the start of the paragraph including strikethrough content
        $this->useTest(6);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>%2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content %2%</p>');

    }//end testDeletingContentWithStrikethroughFormatting()


    /**
     * Test deleting content including content with superscript formatting
     *
     * @return void
     */
    public function testDeletingContentWithSuperscriptFormatting()
    {
        // Check deleting a word after the superscript content
        $this->useTest(7);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% <sup>test</sup></p>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<p>%1% <sup>testcontent</sup></p>');
        } else {
            $this->assertHTMLMatch('<p>%1% <sup>test</sup>content</p>');
        }

        // Check deleting from the end of the paragraph including superscript content
        $this->useTest(7);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>%1%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% content</p>');

        // Check deleting from the start of the paragraph
        $this->useTest(7);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p><sup>test</sup> %2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content<sup>test</sup> %2%</p>');

        // Check deleting from the start of the paragraph including superscript content
        $this->useTest(7);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>%2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content %2%</p>');

    }//end testDeletingContentWithSuperscriptFormatting()
    

    /**
     * Test deleting content including content with subscript formatting
     *
     * @return void
     */
    public function testDeletingContentWithSubscriptFormatting()
    {
        // Check deleting a word after the subscript content
        $this->useTest(8);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% <sub>test</sub></p>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<p>%1% <sub>testcontent</sub></p>');
        } else {
            $this->assertHTMLMatch('<p>%1% <sub>test</sub>content</p>');
        }

        // Check deleting from the end of the paragraph including subscript content
        $this->useTest(8);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>%1%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1% content</p>');

        // Check deleting from the start of the paragraph
        $this->useTest(8);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p><sub>test</sub> %2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content<sub>test</sub> %2%</p>');

        // Check deleting from the start of the paragraph including subscript content
        $this->useTest(8);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>%2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content %2%</p>');

    }//end testDeletingContentWithSubscriptFormatting()


    /**
     * Test deleting content including content within unordered lists
     *
     * @return void
     */
    public function testDeletingContentWithinUnorderedLists()
    {
        // Check deleting a word after the unordered list content
        $this->useTest(9);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<ul><li>%1% test</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>%1% testcontent</li></ul>');

        // Check deleting from the end of the paragraph including unordered list content
        $this->useTest(9);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<ul><li>%1%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>%1% content</li></ul>');

        // Check deleting from the start of the paragraph
        $this->useTest(9);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ul><li>test %2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>content test %2%</li></ul>');

        // Check deleting from the start of the paragraph including unordered list content
        $this->useTest(9);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ul><li>%2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>content %2%</li></ul>');

    }//end testDeletingContentWithinUnorderedLists()
    

    /**
     * Test deleting content including content within unordered lists
     *
     * @return void
     */
    public function testDeletingContentWithinOrderedLists()
    {
        // Check deleting a word after the ordered list content
        $this->useTest(10);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<ol><li>%1% test</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>%1% testcontent</li></ol>');

        // Check deleting from the end of the paragraph including ordered list content
        $this->useTest(10);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<ol><li>%1%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>%1% content</li></ol>');

        // Check deleting from the start of the paragraph
        $this->useTest(10);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ol><li>test %2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>content test %2%</li></ol>');

        // Check deleting from the start of the paragraph including ordered list content
        $this->useTest(10);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ol><li>%2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>content %2%</li></ol>');

    }//end testDeletingContentWithinOrderedLists()


    /**
     * Test deleting content with unordered lists including content with italic formatting
     *
     * @return void
     */
    public function testDeletingItalicFormattedContentWithinUnorderedLists()
    {
        // Check deleting a word after the italic content
        $this->useTest(5);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<ul><li>%1% <em>test</em></li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<ul><li>%1% <em>testcontent</em></li></ul>');
        } else {
            $this->assertHTMLMatch('<ul><li>%1% <em>test</em>content</li></ul>');
        }

        // Check deleting from the end of the paragraph including italic content
        $this->useTest(5);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<ul><li>%1%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>%1% content</li></ul>');

        // Check deleting from the start of the paragraph
        $this->useTest(5);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ul><li><em>test</em> %2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>content<em>test</em> %2%</li></ul>');

        // Check deleting from the start of the paragraph including italic content
        $this->useTest(5);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ul><li>%2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>content %2%</li></ul>');

    }//end testDeletingItalicFormattedContentWithinUnorderedLists()


    /**
     * Test deleting content with ordered lists including content with italic formatting
     *
     * @return void
     */
    public function testDeletingItalicFormattedContentWithinOrderedLists()
    {
        // Check deleting a word after the italic content
        $this->useTest(5);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<ol><li>%1% <em>test</em></li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<ol><li>%1% <em>testcontent</em></li></ol>');
        } else {
            $this->assertHTMLMatch('<ol><li>%1% <em>test</em>content</li></ol>');
        }

        // Check deleting from the end of the paragraph including italic content
        $this->useTest(5);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<ol><li>%1%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>%1% content</li></ol>');

        // Check deleting from the start of the paragraph
        $this->useTest(5);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ol><li><em>test</em> %2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>content<em>test</em> %2%</li></ol>');

        // Check deleting from the start of the paragraph including italic content
        $this->useTest(5);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ol><li>%2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>content %2%</li></ol>');

    }//end testDeletingItalicFormattedContentWithinOrderedLists()


    /**
     * Test deleting content with unordered lists including content with bold formatting
     *
     * @return void
     */
    public function testDeletingBoldFormattedContentWithinUnorderedLists()
    {
        // Check deleting a word after the bold content
        $this->useTest(4);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<ul><li>%1% <strong>test</strong></li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<ul><li>%1% <strong>testcontent</strong></li></ul>');
        } else {
            $this->assertHTMLMatch('<ul><li>%1% <strong>test</strong>content</li></ul>');
        }

        // Check deleting from the end of the paragraph including bold content
        $this->useTest(4);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<ul><li>%1%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>%1% content</li></ul>');

        // Check deleting from the start of the paragraph
        $this->useTest(4);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ul><li><strong>test</strong> %2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>content<strong>test</strong> %2%</li></ul>');

        // Check deleting from the start of the paragraph including bold content
        $this->useTest(4);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ul><li>%2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>content %2%</li></ul>');

    }//end testDeletingBoldFormattedContentWithinUnorderedLists()


    /**
     * Test deleting content with ordered lists including content with bold formatting
     *
     * @return void
     */
    public function testDeletingBoldFormattedContentWithinOrderedLists()
    {
        // Check deleting a word after the bold content
        $this->useTest(4);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<ol><li>%1% <strong>test</strong></li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<ol><li>%1% <strong>testcontent</strong></li></ol>');
        } else {
            $this->assertHTMLMatch('<ol><li>%1% <strong>test</strong>content</li></ol>');
        }

        // Check deleting from the end of the paragraph including bold content
        $this->useTest(4);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<ol><li>%1%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>%1% content</li></ol>');

        // Check deleting from the start of the paragraph
        $this->useTest(4);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ol><li><strong>test</strong> %2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>content<strong>test</strong> %2%</li></ol>');

        // Check deleting from the start of the paragraph including bold content
        $this->useTest(4);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ol><li>%2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>content %2%</li></ol>');

    }//end testDeletingBoldFormattedContentWithinOrderedLists()


    /**
     * Test deleting content with unordered lists including content with strikethrough formatting
     *
     * @return void
     */
    public function testDeletingStrikethroughFormattedContentWithinUnorderedLists()
    {
        // Check deleting a word after the strikethrough content
        $this->useTest(6);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<ul><li>%1% <del>test</del></li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<ul><li>%1% <del>testcontent</del></li></ul>');
        } else {
            $this->assertHTMLMatch('<ul><li>%1% <del>test</del>content</li></ul>');
        }

        // Check deleting from the end of the paragraph including strikethrough content
        $this->useTest(6);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<ul><li>%1%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>%1% content</li></ul>');

        // Check deleting from the start of the paragraph
        $this->useTest(6);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ul><li><del>test</del> %2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>content<del>test</del> %2%</li></ul>');

        // Check deleting from the start of the paragraph including strikethrough content
        $this->useTest(6);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ul><li>%2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>content %2%</li></ul>');

    }//end testDeletingStrikethroughFormattedContentWithinUnorderedLists()


    /**
     * Test deleting content with ordered lists including content with stirkethrough formatting
     *
     * @return void
     */
    public function testDeletingStrikethroughFormattedContentWithinOrderedLists()
    {
        // Check deleting a word after the stirkethrough content
        $this->useTest(6);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<ol><li>%1% <del>test</del></li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<ol><li>%1% <del>testcontent</del></li></ol>');
        } else {
            $this->assertHTMLMatch('<ol><li>%1% <del>test</del>content</li></ol>');
        }

        // Check deleting from the end of the paragraph including stirkethrough content
        $this->useTest(6);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<ol><li>%1%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>%1% content</li></ol>');

        // Check deleting from the start of the paragraph
        $this->useTest(6);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ol><li><del>test</del> %2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>content<del>test</del> %2%</li></ol>');

        // Check deleting from the start of the paragraph including stirkethrough content
        $this->useTest(6);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ol><li>%2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>content %2%</li></ol>');

    }//end testDeletingStrikethroughFormattedContentWithinOrderedLists()


    /**
     * Test deleting content with unordered lists including content with superscript formatting
     *
     * @return void
     */
    public function testDeletingSuperscriptFormattedContentWithinUnorderedLists()
    {
        // Check deleting a word after the superscript content
        $this->useTest(7);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<ul><li>%1% <sup>test</sup></li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<ul><li>%1% <sup>testcontent</sup></li></ul>');
        } else {
            $this->assertHTMLMatch('<ul><li>%1% <sup>test</sup>content</li></ul>');
        }

        // Check deleting from the end of the paragraph including superscript content
        $this->useTest(7);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<ul><li>%1%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>%1% content</li></ul>');

        // Check deleting from the start of the paragraph
        $this->useTest(7);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ul><li><sup>test</sup> %2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>content<sup>test</sup> %2%</li></ul>');

        // Check deleting from the start of the paragraph including superscript content
        $this->useTest(7);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ul><li>%2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>content %2%</li></ul>');

    }//end testDeletingSuperscriptFormattedContentWithinUnorderedLists()


    /**
     * Test deleting content with ordered lists including content with stirkethrough formatting
     *
     * @return void
     */
    public function testDeletingSuperscriptFormattedContentWithinOrderedLists()
    {
        // Check deleting a word after the stirkethrough content
        $this->useTest(7);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<ol><li>%1% <sup>test</sup></li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<ol><li>%1% <sup>testcontent</sup></li></ol>');
        } else {
            $this->assertHTMLMatch('<ol><li>%1% <sup>test</sup>content</li></ol>');
        }

        // Check deleting from the end of the paragraph including stirkethrough content
        $this->useTest(7);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<ol><li>%1%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>%1% content</li></ol>');

        // Check deleting from the start of the paragraph
        $this->useTest(7);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ol><li><sup>test</sup> %2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>content<sup>test</sup> %2%</li></ol>');

        // Check deleting from the start of the paragraph including stirkethrough content
        $this->useTest(7);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ol><li>%2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>content %2%</li></ol>');

    }//end testDeletingSuperscriptFormattedContentWithinOrderedLists()


    /**
     * Test deleting content with unordered lists including content with subscript formatting
     *
     * @return void
     */
    public function testDeletingSubscriptFormattedContentWithinUnorderedLists()
    {
        // Check deleting a word after the subscript content
        $this->useTest(8);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<ul><li>%1% <sub>test</sub></li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<ul><li>%1% <sub>testcontent</sub></li></ul>');
        } else {
            $this->assertHTMLMatch('<ul><li>%1% <sub>test</sub>content</li></ul>');
        }

        // Check deleting from the end of the paragraph including subscript content
        $this->useTest(8);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<ul><li>%1%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>%1% content</li></ul>');

        // Check deleting from the start of the paragraph
        $this->useTest(8);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ul><li><sub>test</sub> %2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>content<sub>test</sub> %2%</li></ul>');

        // Check deleting from the start of the paragraph including subscript content
        $this->useTest(8);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListUl', NULL);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ul><li>%2%</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>content %2%</li></ul>');

    }//end testDeletingSubscriptFormattedContentWithinUnorderedLists()


    /**
     * Test deleting content with ordered lists including content with stirkethrough formatting
     *
     * @return void
     */
    public function testDeletingSubscriptFormattedContentWithinOrderedLists()
    {
        // Check deleting a word after the stirkethrough content
        $this->useTest(8);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<ol><li>%1% <sub>test</sub></li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            // It seems to be not possible to set the range after the strong tag when its the last element.
            $this->assertHTMLMatch('<ol><li>%1% <sub>testcontent</sub></li></ol>');
        } else {
            $this->assertHTMLMatch('<ol><li>%1% <sub>test</sub>content</li></ol>');
        }

        // Check deleting from the end of the paragraph including stirkethrough content
        $this->useTest(8);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<ol><li>%1%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>%1% content</li></ol>');

        // Check deleting from the start of the paragraph
        $this->useTest(8);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ol><li><sub>test</sub> %2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>content<sub>test</sub> %2%</li></ol>');

        // Check deleting from the start of the paragraph including stirkethrough content
        $this->useTest(8);
        $this->selectKeyword(1,2);
        $this->clickTopToolbarButton('ListOl', NULL);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ol><li>%2%</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>content %2%</li></ol>');

    }//end testDeletingSubscriptFormattedContentWithinOrderedLists()

}//end class
