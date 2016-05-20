<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_BlankBlockTagWithAnchorsUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding anchor tag to content
     *
     * @return void
     */
    public function testAddingAnchorToAWordInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying anchor using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is <span id="test1">%1%</span> %2% some content');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test2');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('This is <span id="test1">%1%</span> <span id="test2">%2%</span> some content');

         // Test applying anchor using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is <span id="test1">%1%</span> %2% some content');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test2');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('This is <span id="test1">%1%</span> <span id="test2">%2%</span> some content');

    }//end testAddingAnchorToAWordInContent()


     /**
     * Test adding anchor tag to all content
     *
     * @return void
     */
    public function testAddingAnchorToAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying anchor using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<span id="test1">This is %1% %2% some content</span>');

        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test2');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<span id="test1">This is %1% %2% some content</span>');

        // Test applying anchor using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<span id="test1">This is %1% %2% some content</span>');

        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test2');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<span id="test1">This is %1% %2% some content</span>');

    }//end testAddingAnchorToAllContent()


    /**
     * Test editing anchor tags from a word in content
     *
     * @return void
     */
    public function testEditingAnchorAppliedToWordInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test editing anchor using inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is <span id="test edit">%1%</span> some content');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('This is <span id="test edit">%1%</span> some content');

        // Test editing anchor using top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is <span id="test edit">%1%</span> some content');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('This is <span id="test edit">%1%</span> some content');

    }//end testEditingAnchorAppliedToWordInContent()


    /**
     * Test editing anchor tags that are applied to all content
     *
     * @return void
     */
    public function testEditingAnchorAppliedToAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test editing anchor using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<span id="test edit">%1% This is some content %2%</span>');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<span id="test edit">%1% This is some content %2%</span>');

        // Test editing anchor using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<span id="test edit">%1% This is some content %2%</span>');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<span id="test edit">%1% This is some content %2%</span>');

    }//end testEditingAnchorAppliedToAllContent()


    /**
     * Test removing anchor tag for a word in content
     *
     * @return void
     */
    public function testRemoveAnchorAppliedToWordInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test remove an anchor using the inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is %1% some content');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('This is %1% some content');

        // Test remove an anchor using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is %1% some content');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('This is %1% some content');

    }//end testRemoveAnchorAppliedToWordInContent()


     /**
     * Test removing anchor tags that are applied to all content
     *
     * @return void
     */
    public function testRemoveAnchorAppliedToAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test remove anchor using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('%1% This is some content %2%');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('%1% This is some content %2%');

        // Test editing anchor using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('%1% This is some content %2%');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('%1% This is some content %2%');

    }//end testRemoveAnchorAppliedToAllContent()


    /**
     * Test undo and redo with anchors
     *
     * @return void
     */
    public function testUndoAndRedoWithAnchors()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Apply the anchor
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('This is <span id="test1">%1%</span> %2% some content');

        // Test undo and redo with keyboard shortcuts
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('This is %1% %2% some content');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('This is <span id="test1">%1%</span> %2% some content');

         // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('This is %1% %2% some content');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('This is <span id="test1">%1%</span> %2% some content');

    }//end testUndoAndRedoWithAnchors()


}//end class
