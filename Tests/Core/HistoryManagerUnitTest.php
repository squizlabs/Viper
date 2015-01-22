<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_HistoryManagerUnitTest extends AbstractViperUnitTest
{
    /**
     * Test that Undo and Redo buttons are disabled when the page loads.
     *
     * @return void
     */
    public function testOnLoadButtonsDisabled()
    {
        $this->topToolbarButtonExists('historyUndo', 'disabled');
        $this->topToolbarButtonExists('historyRedo', 'disabled');

    }//end testOnLoadButtonsDisabled()


    /**
     * Test that Undo works using short cut key.
     *
     * @return void
     */
    public function testUndoUsingKeyboardShortcut()
    {
        $this->moveToKeyword(1, 'right');
        $this->type(' test');

        // Check that undo button is enabled and redo is disabled.
        $this->topToolbarButtonExists('historyUndo');
        $this->topToolbarButtonExists('historyRedo', 'disabled');

        // Undo using shortcut.
        $this->sikuli->keyDown('Key.CMD + z');

        // Check that undo button is disabled and redo is enabled.
        $this->topToolbarButtonExists('historyundo', 'disabled');
        $this->topToolbarButtonExists('historyRedo');

        // Make sure the content is reverted.
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');

    }//end testUndoUsingKeyboardShortcut()


    /**
     * Test that Undo works using the toolbar.
     *
     * @return void
     */
    public function testUndoUsingTopToolbar()
    {
        $this->moveToKeyword(1, 'right');
        $this->type(' test');

        $this->clickTopToolbarButton('historyUndo');

        // Check that undo button is disabled and redo is enabled.
        $this->topToolbarButtonExists('historyUndo', 'disabled');
        $this->topToolbarButtonExists('historyRedo');

        // Make sure the content is reverted.
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');

    }//end testUndoUsingTopToolbar()


    /**
     * Test that Redo works using short cut key.
     *
     * @return void
     */
    public function testRedoUsingKeyboardShort()
    {
        $this->moveToKeyword(1, 'right');
        $this->type(' test');

        // Undo and then Redo using shortcut.
        $this->sikuli->keyDown('Key.CMD + z');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');

        // Check that undo button is enabled and redo is disabled.
        $this->topToolbarButtonExists('historyUndo');
        $this->topToolbarButtonExists('historyRedo', 'disabled');

        // Make sure caret is at the correct position.
        $this->type('...');
        $this->assertHTMLMatch('<p>%1% test...</p><p>EIB MOZ</p>');

    }//end testRedoUsingKeyboardShort()


    /**
     * Test that Redo works using top toolbar.
     *
     * @return void
     */
    public function testRedoUsingTopToolbar()
    {
        $this->moveToKeyword(1, 'right');
        $this->type(' test');

        $this->clickTopToolbarButton('historyUndo');
        $this->clickTopToolbarButton('historyRedo');

        // Check that undo button is enabled and redo is disabled.
        $this->topToolbarButtonExists('historyUndo');
        $this->topToolbarButtonExists('historyRedo', 'disabled');

        // Make sure the content is reverted.
        $this->type('.');
        $this->assertHTMLMatch('<p>%1% test.</p><p>EIB MOZ</p>');

    }//end testRedoUsingTopToolbar()


    /**
     * Test that after 50 characters typed a new history item is created.
     *
     * @return void
     */
    public function testMaxCharlimit()
    {
        $this->moveToKeyword(1, 'right');

        $chars = '';
        for ($i = 0; $i < 55; $i++) {
            $chars .= 'a';
        }

        $this->type($chars);

        $this->sikuli->keyDown('Key.CMD + z');

        // Both Undo and Redo button should be active.
        $this->topToolbarButtonExists('historyUndo');
        $this->topToolbarButtonExists('historyRedo');

        $this->assertHTMLMatch('<p>%1%aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p><p>EIB MOZ</p>');
        sleep(1);

        $this->sikuli->keyDown('Key.CMD + z');

        $this->topToolbarButtonExists('historyUndo', 'disabled');
        $this->topToolbarButtonExists('historyRedo', 'disabled');

        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');

    }//end testMaxCharlimit()


    /**
     * Test undo and redo icons.
     *
     * @return void
     */
    public function testUndoAndRedoIcons()
    {
        $this->findKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'), 'Undo icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'), 'Redo icon should be disabled');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New content');
        $this->assertHTMLMatch('<p>%1%</p><p>New content</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'), 'Redo icon should be disabled');

        //Undo the new content
        $this->clickTopToolbarButton('historyUndo');
        //Undo the new paragraph
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'), 'Undo icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo'), 'Redo icon should be active');

        $this->clickTopToolbarButton('historyRedo');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1%</p><p>New content</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'), 'Redo icon should be disabled');

        $this->clickTopToolbarButton('historyUndo');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'), 'Undo icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo'), 'Redo icon should be active');

    }//end testUndoAndRedoIcons()


    /**
     * Test that you can delete all content and then undo the changes using the keyboard shortcuts.
     *
     * @return void
     */
    public function testUndoAndRedoUsingShortcuts()
    {
        $this->findKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'), 'Undo icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'), 'Redo icon should be disabled');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New content');
        $this->assertHTMLMatch('<p>%1%</p><p>New content</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'), 'Redo icon should be disabled');

        $this->sikuli->keyDown('Key.CMD + z');
        $this->sikuli->keyDown('Key.CMD + z');
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'), 'Undo icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo'), 'Redo icon should be active');

        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p>%1%</p><p>New content</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'), 'Redo icon should be disabled');

        $this->sikuli->keyDown('Key.CMD + z');
        $this->sikuli->keyDown('Key.CMD + z');
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'), 'Undo icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo'), 'Redo icon should be active');

    }//end testUndoAndRedoUsingShortcuts()


    /**
     * Test that you can delete all content and then undo the changes.
     *
     * @return void
     */
    public function testDeleteAllClickUndoAndClickRedo()
    {
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(2);
        $this->assertHTMLMatch('<p></p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'), 'Redo icon should be disabled');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'), 'Undo icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo'), 'Redo icon should be active');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p></p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'), 'Redo icon should be disabled');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'), 'Undo icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo'), 'Redo icon should be active');

    }//end testDeleteAllClickUndoAndClickRedo()


    /**
     * Test that you can delete all content and then undo the changes using the keyboard shortcuts.
     *
     * @return void
     */
    public function testDeleteAllClickUndoAndClickRedoUsingShortcuts()
    {
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertHTMLMatch('<p></p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'), 'Redo icon should be disabled');

        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'), 'Undo icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo'), 'Redo icon should be active');

        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p></p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'), 'Redo icon should be disabled');

        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'), 'Undo icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo'), 'Redo icon should be active');

    }//end testDeleteAllClickUndoAndClickRedo()

}//end class

?>
