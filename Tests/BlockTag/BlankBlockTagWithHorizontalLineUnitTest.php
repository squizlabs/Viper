<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_BlankBlockTagWithHorizontalLineUnitTest extends AbstractViperUnitTest
{

    /**
     * Test horizontal rule when there is no default block tag.
     *
     * @return void
     */
    public function testAddingHorizontalRule()
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
        $this->assertHTMLMatch('<hr /><br />test %1% Test content <hr/ ><br />test %2% more test content. %3%');

        $this->moveToKeyword(2, 'right');
        $this->clickTopToolbarButton('insertHr');
        $this->type('test ');
        $this->assertHTMLMatch('<hr /><br />test %1% Test content <hr/ ><br />test %2%<hr /><br />test more test content. %3%');

        // Test adding a horizontal rule at the end of the paragraph and add content
        $this->moveToKeyword(3, 'right');
        $this->clickTopToolbarButton('insertHr');
        $this->type('test');
        $this->assertHTMLMatch('<hr /><br />test %1% Test content <hr/ ><br />test %2% more test content. %3%<hr /><br />test');

        

    }//end testAddingHorizontalRule()


    /**
     * Test horizontal rule when there is no default block tag.
     *
     * @return void
     */
    public function testHorizontalRule()
    {

        // Test deleting using delete key
        $this->useTest(27);
        sleep(2);
        $this->moveToKeyword(1, 'right');
        sleep(3);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('%1%Test content %2%<br /><hr /><br /><hr />%3% more test content.<br /><hr />%4%');

        // Test deleting using backspace key
        sleep(1);
        $this->moveToKeyword(3, 'left');
        sleep(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('%1%Test content %2%<br /><hr /><br />%3% more test content.<br /><hr />%4%');

        // Test br tag
        $this->useTest(28);
        $this->moveToKeyword(1, 'right');
        $this->clickTopToolbarButton('insertHr');
        $this->assertHTMLMatch('%1%<br /><hr /> Test content.%2%<br />%3% Test content.');

        // Test applying before br tag
        $this->useTest(28);
        $this->moveToKeyword(2, 'right');
        $this->clickTopToolbarButton('insertHr');
        $this->assertHTMLMatch('%1% Test content.%2%<hr />%3% Test content.');

        // Test applying after br tag
        $this->useTest(28);
        $this->moveToKeyword(3, 'left');
        $this->clickTopToolbarButton('insertHr');
        $this->assertHTMLMatch('%1% Test content.%2%<hr />%3% Test content.');

        // Test for | placement with br tag
        $this->useTest(29);
        $this->moveToKeyword(1, 'right');
        $this->clickTopToolbarButton('insertHr');
        $this->assertHTMLMatch('%1%<br /><hr />| Test content.%2%<br />%3% Test content.');

        // Test undo adding hr tag using keyboard shortcuts
        $this->useTest(26);
        $this->moveToKeyword(1, 'right');
        $this->clickTopToolbarButton('insertHr');
        sleep(1);
        $this->getOSAltShortcut('Undo');
        $this->assertHTMLMatch('%1% Test content %2% %3% more test content. %4%');

        // Test redo adding hr tag using keyboard shortcuts
        $this->getOSAltShortcut('Redo');
        $this->assertHTMLMatch('%1%<br /><hr /> Test content %2% %3% more test content. %4%');

        // Test undo adding hr tag using top toolbar
        $this->useTest(26);
        $this->moveToKeyword(1, 'right');
        $this->clickTopToolbarButton('insertHr');
        sleep(1);
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('%1% Test content %2% %3% more test content. %4%');

        // Test redo adding hr tag using top toolbar
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('%1%<br /><hr /> Test content %2% %3% more test content. %4%');

    }//end testHorizontalRule()


}//end class
