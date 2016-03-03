<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_DeleteContentFromListsUnitTest extends AbstractViperListPluginUnitTest
{
    /**
     * Test that deleteing content around a unordered list
     *
     * @return void
     */
    public function testDeletingContentAroundUnorderedLists()
    {
        // Check deleting a paragraph after the list
        $this->useTest(1);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1%</p><ul><li>test list</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1%</p><ul><li>test list</li></ul><p>content</p>');

        // Check deleteing the paragraph after the list up to the end of the last list item
        $this->useTest(1);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1%</p><ul><li>test list</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1%</p><ul><li>test listcontent</li></ul>');

        // Check deleting a paragraph after the list and some content from the list
        $this->useTest(1);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 9; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>%1%</p><ul><li>test</li></ul>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1%</p><ul><li>testcontent</li></ul>');

        // Check deleting a paragraph before the list
        $this->useTest(1);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ul><li>test list</li></ul><p>%2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content</p><ul><li>test list</li></ul><p>%2%</p>');

        // Check deleting a paragraph before the list up to the start of the list
        $this->useTest(1);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ul><li>test list</li></ul><p>%2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>contenttest list</li></ul><p>%2%</p>');

        // Check deleting a paragraph before the list and some content from the list
        $this->useTest(1);
        $this->moveToKeyword(1, 'left');

        for ($i = 0; $i < 9; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ul><li>list</li></ul><p>%2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ul><li>contentlist</li></ul><p>%2%</p>');

    }//end testDeletingContentAroundUnorderedLists()


    /**
     * Test that deleteing content around a ordered list
     *
     * @return void
     */
    public function testDeletingContentWithinOrderedLists()
    {
        // Check deleting a paragraph after the list
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1%</p><ol><li>test list</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1%</p><ol><li>test list</li></ol><p>content</p>');

        // Check deleting a paragraph after the list up to the end of the list item
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1%</p><ol><li>test list</li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1%</p><ol><li>test listcontent</li></ol>');

        // Check deleting the paragraph after the list and content in the list
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');

        for ($i = 0; $i < 9; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>%1%</p><ol><li>test </li></ol>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>%1%</p><ol><li>testcontent</li></ol>');

        // Check deleting a paragraph before the list
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ol><li>test list</li></ol><p>%2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<p>content</p><ol><li>test list</li></ol><p>%2%</p>');

        // Check deleting a paragraph before the list up to the start of the list
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<ol><li>test list</li></ol><p>%2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>contenttest list</li></ol><p>%2%</p>');

        // Check deleting the paragraph before the list and content in the list
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');
        sleep(1);
        for ($i = 0; $i < 9; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<ol><li>list</li></ol><p>%2%</p>');

        // Add content to check the position of the cursor
        $this->type('content');
        $this->assertHTMLMatch('<ol><li>contentlist</li></ol><p>%2%</p>');

    }//end testDeletingContentWithinOrderedLists()

}//end class

?>