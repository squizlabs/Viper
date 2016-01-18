<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_BaseTagWithListsUnitTest extends AbstractViperUnitTest
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
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<ul><li>%1% Test content</li><li>Test content</li><li>%2%</li><li>test</li></ul>');

        // Test adding an item to the start of an unordered list
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.UP');
        $this->type('test');
        $this->assertHTMLMatch('<ul><li>test</li><li>%1% Test content</li><li>Test content</li><li>%2%</li><li>test</li></ul>');

        // Test adding an item to the end an ordered list
        $this->useTest(3);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<ol><li>%1% Test content</li><li>Test content</li><li>%2%</li><li>test</li></ol>');

        // Test adding an item to the start of an ordered list
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.UP');
        $this->type('test');
        $this->assertHTMLMatch('<ol><li>test</li><li>%1% Test content</li><li>Test content</li><li>%2%</li><li>test</li></ol>');

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
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<ul><li>%1% Test content</li><li>Test content</li><li>%2%</li></ul>test');

        // Test adding content after an ordered list
        $this->useTest(3);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<ol><li>%1% Test content</li><li>Test content</li><li>%2%</li></ol>test');
        
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
        $this->assertHTMLMatch('test<ul><li>%1% Test content</li><li>Test content</li><li>%2%</li></ul>');

        // Test adding content before an ordered list
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->type('test');
        $this->assertHTMLMatch('test<ol><li>%1% Test content</li><li>Test content</li><li>%2%</li></ol>');
        
    }//end testAddingContentBeforeList()

}//end class