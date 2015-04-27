<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_CreateListUnitTest extends AbstractViperListPluginUnitTest
{


	/**
     * Test that a list is added and removed for the paragraph when you click inside a word.
     *
     * @return void
     */
    public function testListCreationFromClickingInText()
    {
        $this->useTest(1);

        $this->moveToKeyword(1);

        //Test unordered list.
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<ul><li>Create list test %1%</li></ul>');

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Create list test %1%</p>');

        //Test ordered list.
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<ol><li>Create list test %1%</li></ol>');

        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Create list test %1%</p>');

    }//end testListCreationFromClickingInText()


    /**
     * Test that a list is added and removed for the paragraph when you only selected one word in the paragraph.
     *
     * @return void
     */
    public function testListCreationFromTextSelection()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        //Test unordered list.
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<ul><li>Create list test %1%</li></ul>');

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Create list test %1%</p>');

        //Test ordered list.
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<ol><li>Create list test %1%</li></ol>');

        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Create list test %1%</p>');

    }//end testListCreationFromTextSelection()


    /**
     * Test that a list is added and removed when you select a paragraph.
     *
     * @return void
     */
    public function testListCreationFromParaSelection()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);

        //Test unordered list.
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<ul><li>Create list test %1%</li></ul>');

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Create list test %1%</p>');

        //Test ordered list.
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<ol><li>Create list test %1%</li></ol>');

        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Create list test %1%</p>');

    }//end testListCreationFromParaSelection()


    /**
     * Test that you can createa a list when you select all content on the page.
     *
     * @return void
     */
    public function testListCreationFromAllContent()
    {
        $this->useTest(5);

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        //Test unordered list.
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<ul><li>Create list test %1% paragraph one</li><li>This is paragraph two</li><li>This is paragraph three</li></ul>');

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Create list test %1% paragraph one</p><p>This is paragraph two</p><p>This is paragraph three</p>');

        //Test ordered list.
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<ol><li>Create list test %1% paragraph one</li><li>This is paragraph two</li><li>This is paragraph three</li></ol>');

        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Create list test %1% paragraph one</p><p>This is paragraph two</p><p>This is paragraph three</p>');

    }//end testListCreationFromAllContent()


    /**
     * Test creating a list and then clicking undo and redo.
     *
     * @return void
     */
    public function testCreateListAndClickUndo()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        //Test unordered list.
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<ul><li>Create list test %1%</li></ul>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Create list test %1%</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<ul><li>Create list test %1%</li></ul>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Create list test %1%</p>');

        //Test ordered list.
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<ol><li>Create list test %1%</li></ol>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Create list test %1%</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<ol><li>Create list test %1%</li></ol>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>Create list test %1%</p>');

    }//end testCreateListItemsAndClickUndo()


    /**
     * Tests that pressing enter key at the end of a list item that is before a sub list creats, a new list item.
     *
     * @return void
     */
    public function testCreatingNewListItemBeforeASubList()
    {
        //Test unordered list
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('item 2');
        $this->assertHTMLMatch('<p>Create list test %1%</p><ul><li>item 1 %2%</li><li>item 2<br /><ul><li>sub list %3%</li></ul></li></ul>');

        //Test ordered list
        $this->useTest(3);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('item 2');
        $this->assertHTMLMatch('<p>Create list test %1%</p><ol><li>item 1 %2%</li><li>item 2<br /><ol><li>sub list %3%</li></ol></li></ol>');

    }//end testCreatingNewListItemBeforeASubList()


    /**
     * Tests that pressing enter key twice at the end of a sub list item, adds a list item to the parent list.
     *
     * @return void
     */
    public function testCreatingNewListItemAfterASubListItem()
    {
        //Test unordered list
        $this->useTest(2);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('item 2');
        $this->assertHTMLMatch('<p>Create list test %1%</p><ul><li>item 1 %2%<br /><ul><li>sub list %3%</li></ul></li><li>item 2</li></ul>');

        //Test ordered list
        $this->useTest(3);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('item 2');
        $this->assertHTMLMatch('<p>Create list test %1%</p><ol><li>item 1 %2%<br /><ol><li>sub list %3%</li></ol></li><li>item 2</li></ol>');

    }//end testCreatingNewListItemAfterASubListItem()


    /**
     * Tests creating a new list and then deleting it
     *
     * @return void
     */
    public function testCreatingNewListAndDeletingIt()
    {
        //Test unordered list
        $this->useTest(1);

        //Enter content
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('This is content');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('%2% Item one');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Item two');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Item three %3%');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('End content');

        // Create unordered list
        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Create list test %1%</p><p>This is content</p><ul><li>%2% Item one</li><li>Item two</li><li>Item three %3%</li></ul><p>End content</p>');
        // Delete list
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Create list test %1%</p><p>This is content</p><p>End content</p>');

        //Test ordered list
        $this->useTest(1);

        //Enter content
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('This is content');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('%2% Item one');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Item two');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Item three %3%');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('End content');

        // Create unordered list
        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Create list test %1%</p><p>This is content</p><ol><li>%2% Item one</li><li>Item two</li><li>Item three %3%</li></ol><p>End content</p>');
        // Delete list
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<p>Create list test %1%</p><p>This is content</p><p>End content</p>');

    }//end testCreatingNewListAndDeletingIt()


    /**
     * Tests creating a new list and then deleting it
     *
     * @return void
     */
    public function testCreatingNewListAfterDeletingAllContent()
    {
        //Test unordered list
        $this->useTest(4);

        //Enter content
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Create unordered list and delete it
        $this->clickTopToolbarButton('listUL');
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertHTMLMatch('<p></p>');

        // Create unordered list and add a list item
        $this->clickTopToolbarButton('listUL');
        $this->type('New list item');
        $this->assertHTMLMatch('<ul><li>New list item</li></ul>');

        //Test ordered list
        $this->useTest(4);

        //Enter content
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Create ordered list and delete it
        $this->clickTopToolbarButton('listOL');
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertHTMLMatch('<p></p>');

        // Create ordered list and add a list item
        $this->clickTopToolbarButton('listOL');
        $this->type('New list item');
        $this->assertHTMLMatch('<ol><li>New list item</li></ol>');

    }//end testCreatingNewListAfterDeletingAllContent()

}//end class

?>