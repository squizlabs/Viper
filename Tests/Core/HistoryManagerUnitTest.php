<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_HistoryManagerUnitTest extends AbstractViperUnitTest
{


    /**
     * Asserts that specified button state is valid.
     *
     * @param string  $button The button name.
     * @param boolean $state  The state the button is in.
     *
     * @return void
     */
    private function _checkButtonState($button, $state)
    {
        if ($state === FALSE) {
            $this->assertTrue(
                $this->topToolbarButtonExists($button),
                'The '.$button.' button should be disabled.'
            );
        } else {
            $this->assertTrue(
                $this->topToolbarButtonExists($button, $state),
                'The '.$button.' button should be enabled.'
            );
        }

    }//end _checkButtonState()


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
        $text = $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->type(' test');

        // Check that undo button is enabled and redo is disabled.
        $this->topToolbarButtonExists('historyUndo');
        $this->topToolbarButtonExists('historyRedo', 'disabled');

        // Undo using shortcut.
        $this->keyDown('Key.CMD + z');

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
        $text = $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
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
        $text = $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->type(' test');

        // Undo and then Redo using shortcut.
        $this->keyDown('Key.CMD + z');
        $this->keyDown('Key.CMD + Key.SHIFT + z');

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
        $text = $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
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
        $text = $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');

        $chars = '';
        for ($i = 0; $i < 55; $i++) {
            $chars .= 'a';
        }

        $this->type($chars);

        $this->keyDown('Key.CMD + z');

        // Both Undo and Redo button should be active.
        $this->topToolbarButtonExists('historyUndo');
        $this->topToolbarButtonExists('historyRedo');

        $this->assertHTMLMatch('<p>%1%aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p><p>EIB MOZ</p>');
        sleep(1);

        $this->keyDown('Key.CMD + z');

        $this->topToolbarButtonExists('historyUndo', 'disabled');
        $this->topToolbarButtonExists('historyRedo', 'disabled');

        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');

    }//end testMaxCharlimit()


}//end class

?>
