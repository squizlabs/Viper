<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_BlankBaseTagWithListsUnitTest extends AbstractViperUnitTest
{


    /**
     * Test adding items to the list
     *
     * @return void
     */
    public function testAddingItemsToList()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

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

    }//end testAddingItemsToList()


    /**
     * Test adding content after a list
     *
     * @return void
     */
    public function testAddingContentAfterList()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test adding content after an unordered list
        $this->useTest(2);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<ul><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li></ul>test');

        // Test adding content after an ordered list
        $this->useTest(3);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<ol><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li></ol>test');
        
    }//end testAddingContentAfterList()


    /**
     * Test adding content before a list
     *
     * @return void
     */
    public function testAddingContentBeforeList()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test adding content before an unordered list
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->type('test');
        $this->assertHTMLMatch('test<ul><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li></ul>');

        // Test adding content before an ordered list
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->type('test');
        $this->assertHTMLMatch('test<ol><li>%1% Test content</li><li>%2% Test content</li><li>%3%</li></ol>');
        
    }//end testAddingContentBeforeList()


    /**
     * Test removing items from the list
     *
     * @return void
     */
    public function testRemovingItemsFromList()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test removing the first element from an unordered list
        $this->useTest(2);
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('%1% Test content<ul><li>%2%Test content</li><li>%3%</li></ul>');

        // Test removing the middle element from an unordered list
        $this->useTest(2);
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<ul><li>%1% Test content</li></ul>%2%Test content<ul><li>%3%</li></ul>');

        // Test removing the last element from an unordered list
        $this->useTest(2);
        $this->clickKeyword(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<ul><li>%1% Test content</li><li>%2%Test content</li></ul>%3%');

        // Test removing the first element from an ordered list
        $this->useTest(3);
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('%1% Test content<ol><li>%2%Test content</li><li>%3%</li></ol>');

        // Test removing the middle element from an ordered list
        $this->useTest(3);
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<ol><li>%1% Test content</li></ol>%2%Test content<ol><li>%3%</li></ol>');

        // Test removing the last element from an ordered list
        $this->useTest(2);
        $this->clickKeyword(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<ol><li>%1% Test content</li><li>%2%Test content</li></ol>%3%');
        
    }//end testRemovingItemsFromList()

}//end class