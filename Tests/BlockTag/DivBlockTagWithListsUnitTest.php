<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithListsUnitTest extends AbstractViperUnitTest
{


    /**
     * Test adding items to the list
     *
     * @return void
     */
    public function testDivBlockTagAddingItemsToList()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test adding an item to the end an unordered list
        $this->useTest(2);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<ul><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li><li>test</li></ul>');

        // Test adding an item to the start of an unordered list
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.UP');
        $this->type('test');
        $this->assertHTMLMatch('<ul><li>test</li><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li><li>test</li></ul>');

        // Test adding an item to the end an ordered list
        $this->useTest(3);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<ol><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li><li>test</li></ol>');

        // Test adding an item to the start of an ordered list
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.UP');
        $this->type('test');
        $this->assertHTMLMatch('<ol><li>test</li><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li><li>test</li></ol>');

    }//end testDivBlockTagAddingItemsToList()


    /**
     * Test adding content after a list
     *
     * @return void
     */
    public function testDivBlockTagAddingContentAfterList()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test adding content after an unordered list
        $this->useTest(2);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<ul><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li></ul><div>test</div>');

        // Test adding content after an ordered list
        $this->useTest(3);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<ol><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li></ol><div>test</div>');

    }//end testDivBlockTagAddingContentAfterList()


    /**
     * Test adding content before a list
     *
     * @return void
     */
    public function testDivBlockTagAddingContentBeforeList()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test adding content before an unordered list
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(5);
        $this->type('test');
//        $this->assertHTMLMatch('<div>test</div><ul><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li></ul>');

        // Test adding content before an ordered list
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
//        $this->assertHTMLMatch('<div>test</div><ol><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li></ol>');

    }//end testDivBlockTagAddingContentBeforeList()


    /**
     * Test removing items from the list
     *
     * @return void
     */
    public function testDivBlockTagRemovingItemsFromList()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test removing the first element from an unordered list
        $this->useTest(2);
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
//        $this->assertHTMLMatch('<div>%1% Test content</div><ul><li>%2% Test content</li><li>%3%</li></ul>');

        // Test removing the middle element from an unordered list
        $this->useTest(2);
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
//        $this->assertHTMLMatch('<ul><li>%1% Test content</li></ul><div>%2% Test content</div><ul><li>%3%</li></ul>');

        // Test removing the last element from an unordered list
        $this->useTest(2);
        $this->clickKeyword(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
//        $this->assertHTMLMatch('<ul><li>%1% Test content</li><li><div>%2% Test content</div></li></ul>%3%');

        // Test removing the first element from an ordered list
        $this->useTest(3);
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
//        $this->assertHTMLMatch('%1% Test content<ol><li><div>%2% Test content</div></li><li>%3%</li></ol>');

        // Test removing the middle element from an ordered list
        $this->useTest(3);
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
//        $this->assertHTMLMatch('<ol><li>%1% Test content</li></ol><div>%2% Test content</div><ol><li>%3%</li></ol>');

        // Test removing the last element from an ordered list
        $this->useTest(2);
        $this->clickKeyword(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
//        $this->assertHTMLMatch('<ul><li>%1% Test content</li><li>%2% Test content</li></ul><div>%3%</div>');

    }//end testDivBlockTagRemovingItemsFromList()


    /**
     * Test undo and redo with lists
     *
     * @return void
     */
    public function testDivBlockTagUndoAndRedoWithLists()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Add a list item to an unordered list
        $this->useTest(2);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<ul><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li><li>test</li></ul>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<ul><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li></ul>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<ul><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li><li>test</li></ul>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<ul><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li></ul>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<ul><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li><li>test</li></ul>');  

        // Add a list item to an ordered list
        $this->useTest(3);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<ol><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li><li>test</li></ol>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<ol><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li></ol>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<ol><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li><li>test</li></ol>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<ol><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li></ol>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<ol><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li><li>test</li></ol>');

    }//end testDivBlockTagUndoAndRedoWithLists()

}//end class
