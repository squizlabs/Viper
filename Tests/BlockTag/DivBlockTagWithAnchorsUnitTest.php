<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithAnchorsUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding anchor tag to content
     *
     * @return void
     */
    public function testDivBlockTagAddingAnchorToAWordInContent()
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

    }//end testDivBlockTagAddingAnchorToAWordInContent()


     /**
     * Test adding anchor tag to all content
     *
     * @return void
     */
    public function testDivBlockTagAddingAnchorToAllContent()
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

    }//end testDivBlockTagAddingAnchorToAllContent()


    /**
     * Test editing anchor tags from a word in content
     *
     * @return void
     */
    public function testDivBlockTagEditingAnchorAppliedToWordInContent()
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

    }//end testDivBlockTagEditingAnchorAppliedToWordInContent()


    /**
     * Test editing anchor tags that are applied to all content
     *
     * @return void
     */
    public function testDivBlockTagEditingAnchorAppliedToAllContent()
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

    }//end testDivBlockTagEditingAnchorAppliedToAllContent()


    /**
     * Test removing anchor tag for a word in content
     *
     * @return void
     */
    public function testDivBlockTagRemoveAnchorAppliedToWordInContent()
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

    }//end testDivBlockTagRemoveAnchorAppliedToWordInContent()


     /**
     * Test removing anchor tags that are applied to all content
     *
     * @return void
     */
    public function testDivBlockTagRemoveAnchorAppliedToAllContent()
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

    }//end testDivBlockTagRemoveAnchorAppliedToAllContent()


    /**
     * Test undo and redo with anchors
     *
     * @return void
     */
    public function testDivBlockTagUndoAndRedoWithAnchors()
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

    }//end testDivBlockTagUndoAndRedoWithAnchors()


}//end class
