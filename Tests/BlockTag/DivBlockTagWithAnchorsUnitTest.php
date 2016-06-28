<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithAnchorsUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding anchor tag to content
     *
     * @return void
     */
    public function testAddingAnchorToAWordInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying anchor using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is <span id="test1">%1%</span> %2% some content</div>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test2');
        $this->clickInlineToolbarButton('Insert Anchor', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is <span id="test1">%1%</span> <span id="test2">%2%</span> some content</div>');

         // Test applying anchor using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is <span id="test1">%1%</span> %2% some content</div>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test2');
        $this->clickTopToolbarButton('Insert Anchor', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is <span id="test1">%1%</span> <span id="test2">%2%</span> some content</div>');

    }//end testAddingAnchorToAWordInContent()


     /**
     * Test adding anchor tag to all content
     *
     * @return void
     */
    public function testAddingAnchorToAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying anchor using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div id="test1">%1% This is some content %2%</div>');

        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test2');
        $this->clickInlineToolbarButton('Insert Anchor', NULL, TRUE);
        $this->assertHTMLMatch('<div id="test2">%1% This is some content %2%</div>');

        // Test applying anchor using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div id="test1">%1% This is some content %2%</div>');

        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test2');
        $this->clickTopToolbarButton('Insert Anchor', NULL, TRUE);
        $this->assertHTMLMatch('<div id="test2">%1% This is some content %2%</div>');

    }//end testAddingAnchorToAllContent()


    /**
     * Test editing anchor tags from a word in content
     *
     * @return void
     */
    public function testEditingAnchorAppliedToWordInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test editing anchor using inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is <span id="test edit">%1%</span> some content</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->clickInlineToolbarButton('Update Anchor', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is <span id="test edit">%1%</span> some content</div>');

        // Test editing anchor using top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is <span id="test edit">%1%</span> some content</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->clickTopToolbarButton('Update Anchor', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is <span id="test edit">%1%</span> some content</div>');

    }//end testEditingAnchorAppliedToWordInContent()


    /**
     * Test editing anchor tags that are applied to all content
     *
     * @return void
     */
    public function testEditingAnchorAppliedToAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test editing anchor using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><span id="test edit">%1% This is some content %2%</span></div>');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->clickInlineToolbarButton('Update Anchor', NULL, TRUE);
        $this->assertHTMLMatch('<div><span id="test edit">%1% This is some content %2%</span></div>');

        // Test editing anchor using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><span id="test edit">%1% This is some content %2%</span></div>');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clickField('ID');
        $this->type(' edit');
        $this->clickTopToolbarButton('Update Anchor', NULL, TRUE);
        $this->assertHTMLMatch('<div><span id="test edit">%1% This is some content %2%</span></div>');

    }//end testEditingAnchorAppliedToAllContent()


    /**
     * Test removing anchor tag for a word in content
     *
     * @return void
     */
    public function testRemoveAnchorAppliedToWordInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test remove an anchor using the inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->clickInlineToolbarButton('Update Anchor', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        // Test remove an anchor using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->clickTopToolbarButton('Update Anchor', NULL, TRUE);
        $this->assertHTMLMatch('<div>This is %1% some content</div>');

    }//end testRemoveAnchorAppliedToWordInContent()


     /**
     * Test removing anchor tags that are applied to all content
     *
     * @return void
     */
    public function testRemoveAnchorAppliedToAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test remove anchor using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>%1% This is some content %2%</div>');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->clickInlineToolbarButton('Update Anchor', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% This is some content %2%</div>');

        // Test editing anchor using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>%1% This is some content %2%</div>');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->clickTopToolbarButton('Update Anchor', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% This is some content %2%</div>');

    }//end testRemoveAnchorAppliedToAllContent()


    /**
     * Test undo and redo with anchors
     *
     * @return void
     */
    public function testUndoAndRedoWithAnchors()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Apply the anchor
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div>This is <span id="test1">%1%</span> %2% some content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        sleep(3);
        $this->assertHTMLMatch('<div>This is <span id="test1">%1%</span> %2% some content</div>');

         // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>This is %1% %2% some content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>This is <span id="test1">%1%</span> %2% some content</div>');

    }//end testUndoAndRedoWithAnchors()


}//end class
