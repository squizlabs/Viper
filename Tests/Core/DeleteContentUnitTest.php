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
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->type('This is a line of content to delete the last three %1% words %2%');
        sleep(1);

        // Select the last 3 words and delete them
        $this->selectKeyword(1, 2);
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertHTMLMatch('<p>This is a line of content to delete the last three</p>');

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
        $this->assertHTMLMatch('<p>testMOZ %2%</p>');

        // Test backspace
        $this->useTest(1);

        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->type('test');
        $this->assertHTMLMatch('<p>%1%</p><p>EIBtest</p>');

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
        $this->assertHTMLMatch('<p>New content in paragraphThis is the first line of content.<br />This is the second line of content.</p><p>Another paragraph</p>');

        // Delete the content before the BR using the delete key
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('New content in paragraph');
        $this->assertHTMLMatch('<p>New content in paragraphThis is the first line of content.<br />This is the second line of content.</p><p>Another paragraph</p>');

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
        $this->assertHTMLMatch('<p>%1% <strong>testcontent</strong></p>');

        // Check deleting from the end of the paragraph including bold content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>%1%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1%content</p>');

        // Check deleting from the start of the paragraph
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p><strong>test</strong> %2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p><strong>contenttest</strong> %2%</p>');

        // Check deleting from the start of the paragraph including bold content
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>%2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content%2%</p>');

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
        $this->assertHTMLMatch('<p>%1% <em>testcontent</em></p>');

        // Check deleting from the end of the paragraph including italic content
        $this->useTest(5);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>%1%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1%content</p>');

        // Check deleting from the start of the paragraph
        $this->useTest(5);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p><em>test</em> %2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p><em>contenttest</em> %2%</p>');

        // Check deleting from the start of the paragraph including italic content
        $this->useTest(5);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>%2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content%2%</p>');

    }//end testDeletingContentWithItalicFormatting()

}//end class
