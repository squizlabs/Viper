<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithHorizontalLineUnitTest extends AbstractViperUnitTest
{

    /**
     * Test adding horizontal rule when tdefault block tag is div.
     *
     * @return void
     */
    public function testAddingHorizontalRule()
    {

        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test adding a horizontal rule at start of page and add content
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');
        $this->clickTopToolbarButton('insertHr');
        $this->type('test ');
        $this->assertHTMLMatch('<hr /><div>test %1% Test content %2% more test content. %3%</div>');

        // Test adding a horizontal rule in the middle of the paragraph and add content
        $this->useTest(2);
        $this->moveToKeyword(2, 'left');
        $this->clickTopToolbarButton('insertHr');
        $this->type('test ');
        $this->assertHTMLMatch('<div>%1% Test content</div><hr /><div>test %2% more test content. %3%</div>');

        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->clickTopToolbarButton('insertHr');
        $this->type('test');
        $this->assertHTMLMatch('<div>%1% Test content %2%</div><hr /><div>test more test content. %3%</div>');

        // Test adding a horizontal rule at the end of the paragraph and add content
        $this->useTest(2);
        $this->moveToKeyword(3, 'right');
        $this->clickTopToolbarButton('insertHr');
        $this->sikuli->keyDown('Key.DOWN');
        $this->type('test');
        $this->assertHTMLMatch('<div>%1% Test content %2% more test content. %3%</div><hr /><div>test</div>');

    }//end testAddingHorizontalRule()


    /**
     * Test deleting horizontal rule when default block tag is div.
     *
     * @return void
     */
    public function testDeletingHorizontalRule()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Using forward delete
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<div>%1% Test content</div>');

        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<div>Test content %1% more test content</div>');

        $this->useTest(5);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<div>Test content more test content %1%</div>');

        // Using backspace
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<div>%1% Test content</div>');

        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<div>Test content %1% more test content</div>');

        $this->useTest(5);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<div>Test content more test content %1%</div>');

    }//end testDeletingHorizontalRule()


    /**
     * Test undo and redo.
     *
     * @return void
     */
    public function testUndoAndRedoWithHorizontalRule()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test undo and redo using toolbar icons
        $this->useTest(2);
        $this->moveToKeyword(2, 'left');
        $this->clickTopToolbarButton('insertHr');
        $this->assertHTMLMatch('<div>%1% Test content</div><hr /><div>%2% more test content. %3%</div>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>%1% Test content %2% more test content. %3%</div>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>%1% Test content</div><hr /><div>%2% more test content. %3%</div>');


        // Test undo and redo using keyboard shortcuts
        $this->useTest(2);
        $this->moveToKeyword(2, 'left');
        $this->clickTopToolbarButton('insertHr');
        $this->assertHTMLMatch('<div>%1% Test content</div><hr /><div>%2% more test content. %3%</div>');

        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>%1% Test content %2% more test content. %3%</div>');

        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>%1% Test content</div><hr /><div>%2% more test content. %3%</div>');

    }//end testUndoAndRedoWithHorizontalRule()


}//end class
