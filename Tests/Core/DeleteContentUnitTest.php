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
     * Test deleting content
     *
     * @return void
     */
    public function testDeleteContent()
    {

        // Press delete to remove individual characters from end of paragraph
        $this->useTest(1);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 3; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->type('test');
        $this->assertHTMLMatch('<p>Content test</p><p>EIB MOZ %2% additional %3% content</p>');

        // Place cursor infront of word and press delete for content across two paragraphs
        $this->useTest(1);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 8; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->type('test');
        $this->assertHTMLMatch('<p>Content testMOZ %2% additional %3% content</p>');

        // Select a word at the end of a paragraph and press delete 
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Content test</p><p>EIB MOZ %2% additional %3% content</p>');

        // Select content across two paragraphs and press delete
        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Content test additional %3% content</p>');

        // Press delete to remove individual characters from centre of paragraph
        $this->useTest(1);
        $this->moveToKeyword(2, 'left');

        for ($i = 0; $i < 3; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->type('test');
        $this->assertHTMLMatch('<p>Content %1%</p><p>EIB MOZ test additional %3% content</p>');

        // Select a word and press DELETE
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Content %1%</p><p>EIB MOZ test additional %3% content</p>');

        // Select content between two keywords and press DELETE
        $this->useTest(1);
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Content %1%</p><p>EIB MOZ test content</p>');

    }//end testDeleteContent()


    /**
     * Test backspace with content
     *
     * @return void
     */
    public function testBackspaceWithContent()
    {

        // Press backspace to remove individual characters from end of paragraph
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');

        for ($i = 0; $i < 3; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->type('test');
        $this->assertHTMLMatch('<p>Content test</p><p>EIB MOZ %2% additional %3% content</p>');

        // Place cursor at end of word and press backsapce for content across two paragraphs
        $this->useTest(1);
        $this->moveToKeyword(2, 'right');
        sleep(1);

        for ($i = 0; $i < 12; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->type('test');
        $this->assertHTMLMatch('<p>Content %1%test additional %3% content</p>');

        // Select a word at the end of a paragraph and press backspace 
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Content test</p><p>EIB MOZ %2% additional %3% content</p>');

        // Select content across two paragraphs and press backspace
        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Content test additional %3% content</p>');


        // Press backspace to remove individual characters from centre of paragraph
        $this->useTest(1);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 3; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->type('test');
        $this->assertHTMLMatch('<p>Content %1%</p><p>EIB MOZ test additional %3% content</p>');

        // Select a word and press backspace
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Content %1%</p><p>EIB MOZ test additional %3% content</p>');

        // Select content between two keywords and press backspace
        $this->useTest(1);
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('<p>Content %1%</p><p>EIB MOZ test content</p>');

    }//end testBackspaceWithContent()


    /**
     * Test that removing characters using BACKSPACE works.
     *
     * @return void
     */
    public function testBackspace()
    {
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->type('test');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->type(' input...');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Testing...');

        $this->assertHTMLMatch('<p>Content %1%<strong>test</strong> input...</p><p>Testing...</p><p>EIB MOZ %2% additional %3% content</p>');

        for ($i = 0; $i < 35; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>EIB MOZ %2% additional %3% content</p>');

    }//end testBackspace()


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
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('New content in paragraph');
        $this->assertHTMLMatch('<p>Some content here</p><p>New content in paragraphThis is the first line of content.<br />This is the second line of content.</p><p>Another paragraph</p>');

        // Delete content after a space before BR using delete key
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->type(' Some test content. %2% ');
        $this->sikuli->keyDown('Key.SHIFT + Key.ENTER');
        $this->type('%3% More test content.');
        $this->assertHTMLMatch('<p>%1% Some test content. %2% <br />%3% More test content.</p>');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>%1% Some test content. %2% %3% More test content.</p>');

        // Undo a use backspace to delete the br
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1% Some test content. %2% <br />%3% More test content.</p>');
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% Some test content. %2% %3% More test content.</p>');

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

}//end class
