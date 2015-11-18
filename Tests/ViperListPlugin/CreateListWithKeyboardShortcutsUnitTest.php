<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_CreateListWithKeyboardShortcutsUnitTest extends AbstractViperListPluginUnitTest
{

	/**
     * Test that you can create an unordered list when using the tab key.
     *
     * @return void
     */
    public function testCreatingAListUsingTabKey()
    {
        $this->useTest(1);
        
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');

        $this->type('Test list:');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Item 1');
        $this->assertIconStatusesCorrect('active', TRUE, NULL, TRUE);
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Item 2');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->assertHTMLMatch('<p>Create list test %1%</p><p>Test list:</p><ul><li>Item 1</li><li>Item 2</li></ul>');

    }//end testCreatingAListUsingTabKey()


	/**
     * Test that you can create an unordered list and a sub list using the tab and shift+tab key.
     *
     * @return void
     */
    public function testCreatingAListWithASubListUsingKeyboard()
    {
        $this->useTest(1);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Test 2');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Test 3');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Test 4');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->type('Test 5');

        $this->assertHTMLMatch('<p>Create list test %1%</p><ul><li>Test<ul><li>Test 2</li><li>Test 3<ul><li>Test 4</li></ul></li></ul></li><li>Test 5</li></ul>');

    }//end testCreatingAListWithASubListUsingKeyboard()


    /**
     * Test that you can add items to an orderded list using the tab and shift+tab key.
     *
     * @return void
     */
    public function testAddingItemsToOrderedListWithUsingKeyboard()
    {
        $this->useTest(1);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('listOL');
        $this->type('Test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Test 2');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Test 3');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Test 4');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->type('Test 5');

        $this->assertHTMLMatch('<p>Create list test %1%</p><ol><li>Test<ol><li>Test 2</li><li>Test 3<ol><li>Test 4</li></ol></li></ol></li><li>Test 5</li></ol>');

    }//end testAddingItemsToOrderedListWithUsingKeyboard()


    /**
     * Test that you can create a list after entering some text and pressing tab.
     *
     * @return void
     */
    public function testCreatingAListAfterEnteringText()
    {
        $this->useTest(1);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');

        $this->type('New list item');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, NULL, TRUE);
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Second list item');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->assertHTMLMatch('<p>Create list test %1%</p><ul><li>New list item</li><li>Second list item</li></ul>');

    }//end testCreatingAListAfterEnteringText()


    /**
     * Tests creating a new list and then deleting it
     *
     * @return void
     */
    public function testCreatingNewListAfterDeletingAllContent()
    {
        //Test unordered list
        $this->useTest(2);

        //Enter content
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Create unordered list and delete it
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p></p>');

        // Create unordered list and add a list item
        $this->sikuli->keyDown('Key.TAB');
        $this->type('New list item');
        $this->assertHTMLMatch('<ul><li>New list item</li></ul>');

    }//end testCreatingNewListAfterDeletingAllContent()


}//end class

?>