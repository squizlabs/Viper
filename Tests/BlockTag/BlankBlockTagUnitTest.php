<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_BlankBlockTagUnitTest extends AbstractViperUnitTest
{

    /**
     * Test horizontal rule when there is no default block tag.
     *
     * @return void
     */
    public function testHorizontalRule()
    {

         $this->useTest(1);
         $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying after first word of content
        $this->useTest(26);
        $this->moveToKeyword(1, 'right');
        $this->clickTopToolbarButton('insertHr');
        $this->assertHTMLMatch('%1%<br /><hr /> Test content %2% %3% more test content. %4%');

        // Test applying before last word of content
        $this->useTest(26);
        $this->moveToKeyword(4, 'left');
        $this->clickTopToolbarButton('insertHr');
        $this->assertHTMLMatch('%1% Test content %2% %3% more test content.<br /><hr />%4%');

        // Test applying multiple to content
        $this->useTest(26);
        $this->moveToKeyword(1, 'right');
        $this->clickTopToolbarButton('insertHr');
        sleep(1);
        $this->moveToKeyword(2, 'right');
        $this->clickTopToolbarButton('insertHr');
        sleep(1);
        $this->moveToKeyword(4, 'left');
        $this->clickTopToolbarButton('insertHr');
        sleep(1);
        $this->moveToKeyword(3, 'left');
        $this->clickTopToolbarButton('insertHr');
        sleep(1);
        $this->assertHTMLMatch('%1%<br /><hr /> Test content %2%<br /><hr /><br /><hr />%3% more test content.<br /><hr />%4%');

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
