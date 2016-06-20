<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithClassesUnitTest extends AbstractViperUnitTest
{
	/**
     * Test adding class tag to content
     *
     * @return void
     */
    public function testDivBlockTagAddingClassToAWordInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying class using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is <span class="test1">%1%</span> %2% some content</div>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test2');
        $this->clickInlineToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is <span class="test1">%1%</span> <span class="test2">%2%</span> some content</div>');

         // Test applying class using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is <span class="test1">%1%</span> %2% some content</div>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test2');
        $this->clickTopToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is <span class="test1">%1%</span> <span class="test2">%2%</span> some content</div>');

    }//end testDivBlockTagAddingClassToAWordInContent()


     /**
     * Test adding class tag to all content
     *
     * @return void
     */
    public function testDivBlockTagAddingClassToAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying class using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div class="test1">%1% This is some content %2%</div>');

        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass');
        $this->type('test2');
        $this->clickInlineToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<div class="test2">%1% This is some content %2%</div>');

        // Test applying class using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div class="test1">%1% This is some content %2%</div>');

        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass');
        $this->type('test2');
        $this->clickTopToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<div class="test2">%1% This is some content %2%</div>');

    }//end testDivBlockTagAddingClassToAllContent()


	/**
     * Test editing class tags from a word in content
     *
     * @return void
     */
    public function testDivBlockTagEditingClassAppliedToWordInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test editing class using inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is <span class="test_class edit">%1%</span> some content</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->clickInlineToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is <span class="test_class edit">%1%</span> some content</div>');

        // Test editing class using top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is <span class="test_class edit">%1%</span> some content</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->clickTopToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is <span class="test_class edit">%1%</span> some content</div>');

    }//end testDivBlockTagEditingClassAppliedToWordInContent()


    /**
     * Test editing class tags that are applied to all content
     *
     * @return void
     */
    public function testDivBlockTagEditingClassAppliedToAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test editing class using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(3);
        $this->assertHTMLMatch('<div class="test_class edit">%1% This is some content %2%</div>');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->clickInlineToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<div class="test_class edit">%1% This is some content %2%</div>');

        // Test editing class using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div class="test_class edit">%1% This is some content %2%</div>');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clickField('Class');
        $this->type(' edit');
        $this->clickTopToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<div class="test_class edit">%1% This is some content %2%</div>');

    }//end testDivBlockTagEditingClassAppliedToAllContent()


	/**
     * Test removing anchor tag for a word in content
     *
     * @return void
     */
    public function testDivBlockTagRemoveClassAppliedToWordInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test remove an anchor using the inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
//        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickInlineToolbarButton('Apply Styles', NULL, TRUE);
//        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test remove an anchor using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
//        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Apply Styles', NULL, TRUE);
//        $this->assertHTMLMatch('<div>This is %1% some content</div>');

    }//end testDivBlockTagRemoveClassAppliedToWordInContent()


     /**
     * Test removing anchor tags that are applied to all content
     *
     * @return void
     */
    public function testDivBlockTagRemoveClassAppliedToAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test remove anchor using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>%1% This is some content %2%</div>');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickInlineToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% This is some content %2%</div>');

        // Test editing anchor using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>%1% This is some content %2%</div>');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('cssClass', 'active');
        $this->clearFieldValue('Class');
        $this->clickTopToolbarButton('Apply Styles', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% This is some content %2%</div>');

    }//end testDivBlockTagRemoveClassAppliedToAllContent()


	/**
     * Test undo and redo with class
     *
     * @return void
     */
    public function testDivBlockTagUndoAndRedoWithClass()
    {
    	// Test using keyboard shortcuts
    	$this->useTest(1);
    	$this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

    	$this->useTest(2);
    	$this->selectKeyword(1,2);
    	$this->clickTopToolbarButton('cssClass');
    	$this->type('test_class');
    	$this->sikuli->keyDown('Key.ENTER');
    	$this->assertHTMLMatch('<div>This is<span class="test_class">%1% %2%</span> some content</div>');

    	// Test undo
    	$this->selectKeyword(2);
    	$this->sikuli->keyDown('Key.CMD + z');
//    	$this->assertHTMLMatch('<div>This is %1% %2% some content</div>');

    	// Test redo
    	$this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
    	$this->assertHTMLMatch('<div>This is<span class="test_class">%1% %2%</span> some content</div>');
		
		// Test using top toolbar
    	// Test undo
    	$this->clickTopToolbarButton('HistoryUndo');
//    	$this->assertHTMLMatch('<div>This is %1% %2% some content</div>');

    	// Test redo
    	$this->clickTopToolbarButton('HistoryRedo');
    	$this->assertHTMLMatch('<div>This is<span class="test_class">%1% %2%</span> some content</div>');    	

    }//end testDivBlockTagUndoAndRedoWithClass()

}//end class