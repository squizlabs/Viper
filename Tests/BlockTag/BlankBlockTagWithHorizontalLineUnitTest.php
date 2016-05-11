<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_BlankBlockTagWithHorizontalLineUnitTest extends AbstractViperUnitTest
{

    /**
     * Test adding horizontal rule when there is no default block tag.
     *
     * @return void
     */
    public function testAddingHorizontalRuleM()
    {

        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test adding a horizontal rule at start of page and add content
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');
        $this->clickTopToolbarButton('insertHr');
        $this->type('test ');
        $this->assertHTMLMatch('<hr /><br />test %1% Test content %2% more test content. %3%');

        // Test adding a horizontal rule in the middle of the paragraph and add content
        $this->useTest(2);
        $this->moveToKeyword(2, 'left');
        $this->clickTopToolbarButton('insertHr');
        $this->type('test ');
        $this->assertHTMLMatch('%1% Test content<br /><hr />test %2% more test content. %3%');

        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->clickTopToolbarButton('insertHr');
        $this->type('test ');
        $this->assertHTMLMatch('%1% Test content %2%<br /><hr />test&nbsp;&nbsp;more test content. %3%');

        // Test adding a horizontal rule at the end of the paragraph and add content
        $this->useTest(2);
        $this->moveToKeyword(3, 'right');
        $this->clickTopToolbarButton('insertHr');
        $this->sikuli->keyDown('Key.DOWN');
        $this->type('test');
        $this->assertHTMLMatch('%1% Test content %2% more test content. %3%<hr />test');

    }//end testAddingHorizontalRule()


    /**
     * Test deleting horizontal rule when there is no default block tag.
     *
     * @return void
     */
    public function testDeletingHorizontalRule()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Using forward delete
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('%1% Test content');

        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('Test content %1%more test content');

        $this->useTest(5);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('Test content more test content %1%');

        // Using backspace
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('%1% Test content');

        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('Test content %1% more test content');

        $this->useTest(5);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('Test content more test content %1%');

    }//end testDeletingHorizontalRule()


    /**
     * Test undo and redo.
     *
     * @return void
     */
    public function testUndoAndRedoWithHorizontalRule()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test undo and redo using toolbar icons
        $this->useTest(2);
        $this->moveToKeyword(2, 'left');
        $this->clickTopToolbarButton('insertHr');
        $this->assertHTMLMatch('%1% Test content<br /><hr />%2% more test content. %3%');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('%1% Test content %2% more test content. %3%');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('%1% Test content<br /><hr />%2% more test content. %3%');


        // Test undo and redo using keyboard shortcuts
        $this->useTest(2);
        $this->moveToKeyword(2, 'left');
        $this->clickTopToolbarButton('insertHr');
        $this->assertHTMLMatch('%1% Test content<br /><hr />%2% more test content. %3%');

        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('%1% Test content %2% more test content. %3%');

        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('%1% Test content<br /><hr />%2% more test content. %3%');

    }//end testAddingHorizontalRule()


}//end class
