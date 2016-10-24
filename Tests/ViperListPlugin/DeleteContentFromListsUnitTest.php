<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_DeleteContentFromListsUnitTest extends AbstractViperListPluginUnitTest
{
    /**
     * Test deleteing a paragraph after the list
     *
     * @return void
     */
    public function testDeletingParagraphAfterList()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            $this->moveToKeyword(2, 'right');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->assertHTMLMatch('<p>%1%</p><'.$listType.'><li>test list</li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>%1%</p><'.$listType.'><li>test list</li></'.$listType.'><p>content</p>');
        }

    }//end testDeletingParagraphAfterList()


    /**
     * Test deleteing the paragraph after the list up to the end of the last list item
     *
     * @return void
     */
    public function testDeletingContentAfterListUpToLastListItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            $this->moveToKeyword(2, 'right');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->assertHTMLMatch('<p>%1%</p><'.$listType.'><li>test list</li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>%1%</p><'.$listType.'><li>test listcontent</li></'.$listType.'>');
        }

    }//end testDeletingContentAfterListUpToLastListItem()


    /**
     * Test deleting a paragraph after the list and some content from the list
     *
     * @return void
     */
    public function testDeletingContentAfterListAndSomeListContent()
    {

        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            $this->moveToKeyword(2, 'right');

            for ($i = 0; $i < 9; $i++) {
                $this->sikuli->keyDown('Key.BACKSPACE');
            }

            $this->assertHTMLMatch('<p>%1%</p><'.$listType.'><li>test</li></'.$listType.'>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>%1%</p><'.$listType.'><li>testcontent</li></'.$listType.'>');
        }

    }//end testDeletingContentAfterListAndSomeListContent()


    /**
     * Test deleting a paragraph before the list
     *
     * @return void
     */
    public function testDeletingContentBeforeList()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }
            $this->moveToKeyword(1, 'left');
            $this->sikuli->keyDown('Key.DELETE');
            $this->sikuli->keyDown('Key.DELETE');
            $this->sikuli->keyDown('Key.DELETE');
            $this->assertHTMLMatch('<'.$listType.'><li>test list</li></'.$listType.'><p>%2%</p>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<p>content</p><'.$listType.'><li>test list</li></'.$listType.'><p>%2%</p>');
        }

    }//end testDeletingContentBeforeList()


    /**
     * Test deleting a paragraph before the list up to the start of the list
     *
     * @return void
     */
    public function testDeletingContentBeforeListUpToStartOfList()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }
            $this->moveToKeyword(1, 'left');
            $this->sikuli->keyDown('Key.DELETE');
            $this->sikuli->keyDown('Key.DELETE');
            $this->sikuli->keyDown('Key.DELETE');
            $this->sikuli->keyDown('Key.DELETE');
            $this->assertHTMLMatch('<'.$listType.'><li>test list</li></'.$listType.'><p>%2%</p>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<'.$listType.'><li>contenttest list</li></'.$listType.'><p>%2%</p>');
        }

    }//end testDeletingContentBeforeListUpToStartOfList()


    /**
     * Test deleting a paragraph before the list and some content from the list
     *
     * @return void
     */
    public function testDeletingContentBeforeListAndSomeListContent()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }
            $this->moveToKeyword(1, 'left');

            for ($i = 0; $i < 9; $i++) {
                $this->sikuli->keyDown('Key.DELETE');
            }

            $this->assertHTMLMatch('<'.$listType.'><li>list</li></'.$listType.'><p>%2%</p>');

            // Add content to check the position of the cursor
            $this->type('content');
            $this->assertHTMLMatch('<'.$listType.'><li>contentlist</li></'.$listType.'><p>%2%</p>');
        }

    }//end testDeletingContentBeforeListAndSomeListContent()

}//end class

?>