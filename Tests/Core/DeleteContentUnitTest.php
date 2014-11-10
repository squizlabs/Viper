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
        $this->type('This is a long line of content to test deleting the last three %1% words %2%');

        // Select the last 3 words and delete them
        $this->selectKeyword(1, 2);
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertHTMLMatch('<p>This is a long line of content to test deleting the last three</p>');

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


}//end class
