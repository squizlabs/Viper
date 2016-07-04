<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_BlankBlockTagWithClassesUnitTest extends AbstractViperUnitTest
{
	/**
     * Test adding class tag to content
     *
     * @return void
     */
    public function testAddingClassToAWordInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying class using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is <span class="test1">%1%</span> %2% some content');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test2');
        $this->clickInlineToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('This is <span class="test1">%1%</span> <span class="test2">%2%</span> some content');

         // Test applying class using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is <span class="test1">%1%</span> %2% some content');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test2');
        $this->clickTopToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('This is <span class="test1">%1%</span> <span class="test2">%2%</span> some content');

    }//end testAddingClassToAWordInContent()


     /**
     * Test adding class tag to all content
     *
     * @return void
     */
    public function testAddingClassToAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying class using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<span class="test1">%1% This is some content %2%</span>');

        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test2');
        $this->clickInlineToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<span class="test2">%1% This is some content %2%</span>');

        // Test applying class using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<span class="test1">%1% This is some content %2%</span>');

        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test2');
        $this->clickTopToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<span class="test2">%1% This is some content %2%</span>');

    }//end testAddingClassToAllContent()


	/**
     * Test editing class tags from a word in content
     *
     * @return void
     */
    public function testEditingClassAppliedToWordInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test editing class using inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is <span class="test_class edit">%1%</span> some content');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->clickInlineToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('This is <span class="test_class edit">%1%</span> some content');

        // Test editing class using top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is <span class="test_class edit">%1%</span> some content');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->clickTopToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('This is <span class="test_class edit">%1%</span> some content');

    }//end testEditingClassAppliedToWordInContent()


    /**
     * Test editing class tags that are applied to all content
     *
     * @return void
     */
    public function testEditingClassAppliedToAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test editing class using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<span class="test_class edit">%1% This is some content %2%</span>');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->clickInlineToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<span class="test_class edit">%1% This is some content %2%</span>');

        // Test editing class using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<span class="test_class edit">%1% This is some content %2%</span>');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->clickTopToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<span class="test_class edit">%1% This is some content %2%</span>');

    }//end testEditingClassAppliedToAllContent()


	/**
     * Test removing anchor tag for a word in content
     *
     * @return void
     */
    public function testRemoveClassAppliedToWordInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test remove an anchor using the inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is %1% some content');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickInlineToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('This is %1% some content');

        // Test remove an anchor using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is %1% some content');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('This is %1% some content');

    }//end testRemoveClassAppliedToWordInContent()


     /**
     * Test removing anchor tags that are applied to all content
     *
     * @return void
     */
    public function testRemoveClassAppliedToAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test remove anchor using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('%1% This is some content %2%');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickInlineToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('%1% This is some content %2%');

        // Test editing anchor using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('%1% This is some content %2%');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('%1% This is some content %2%');

    }//end testRemoveClassAppliedToAllContent()


	/**
     * Test undo and redo with class
     *
     * @return void
     */
    public function testUndoAndRedoWithClass()
    {
    	// Test using keyboard shortcuts
    	$this->useTest(1);
    	$this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

    	$this->useTest(2);
    	$this->selectKeyword(1,2);
    	$this->clickTopToolbarButton('cssClass');
    	$this->type('test_class');
    	$this->sikuli->keyDown('Key.ENTER');
    	$this->assertHTMLMatch('This is<span class="test_class">%1% %2%</span> some content');

    	// Test undo
    	$this->selectKeyword(2);
    	$this->sikuli->keyDown('Key.CMD + z');
    	$this->assertHTMLMatch('This is %1% %2% some content');

    	// Test redo
    	$this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
    	$this->assertHTMLMatch('This is<span class="test_class">%1% %2%</span> some content');

		// Test using top toolbar
    	// Test undo
    	$this->clickTopToolbarButton('HistoryUndo');
    	$this->assertHTMLMatch('This is %1% %2% some content');

    	// Test redo
    	$this->clickTopToolbarButton('HistoryRedo');
    	$this->assertHTMLMatch('This is<span class="test_class">%1% %2%</span> some content');

    }//end testUndoAndRedoWithClass()

}//end class