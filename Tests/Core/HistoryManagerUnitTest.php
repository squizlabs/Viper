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
                $this->topToolbarButtonExists(dirname(__FILE__).'/Images/'.$button.'Icon.png'),
                'The '.$button.' button should be disabled.'
            );
        } else {
            $this->assertTrue(
                $this->topToolbarButtonExists(dirname(__FILE__).'/Images/'.$button.'Icon_active.png'),
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
        $this->_checkButtonState('undo', FALSE);
        $this->_checkButtonState('redo', FALSE);

    }//end testOnLoadButtonsDisabled()


    /**
     * Test that Undo works using short cut key and toolbar.
     *
     * @return void
     */
    public function testUndo()
    {
        $text = $this->selectText('Lorem');
        $this->keyDown('Key.RIGHT');
        $this->type(' test');

        // Check that undo button is enabled and redo is disabled.
        $this->_checkButtonState('undo', TRUE);
        $this->_checkButtonState('redo', FALSE);

        // Undo using shortcut.
        $this->keyDown('Key.CMD + z');

        // Check that undo button is disabled and redo is enabled.
        $this->_checkButtonState('undo', FALSE);
        $this->_checkButtonState('redo', TRUE);

        // Make sure the content is reverted.
        $this->assertHTMLMatch('<p>Lorem</p><p>EIB MOZ</p>');

        // Repeat the same process using toolbar buttons.
        $text = $this->selectText('Lorem');
        $this->keyDown('Key.RIGHT');
        $this->type(' test');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/undoIcon_active.png');

        // Check that undo button is disabled and redo is enabled.
        $this->_checkButtonState('undo', FALSE);
        $this->_checkButtonState('redo', TRUE);

        // Make sure the content is reverted.
        $this->assertHTMLMatch('<p>Lorem</p><p>EIB MOZ</p>');

    }//end testUndo()


    /**
     * Test that Redo works using short cut key and toolbar.
     *
     * @return void
     */
    public function testRedo()
    {
        $text = $this->selectText('Lorem');
        $this->keyDown('Key.RIGHT');
        $this->type(' test');

        // Undo and then Redo using shortcut.
        $this->keyDown('Key.CMD + z');
        $this->keyDown('Key.CMD + Key.SHIFT + z');

        // Check that undo button is enabled and redo is disabled.
        $this->_checkButtonState('undo', TRUE);
        $this->_checkButtonState('redo', FALSE);

        // Make sure caret is at the correct position.
        $this->type('...');

        // Repeat the same process using toolbar buttons.
        $this->keyDown('Key.CMD + z');
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/redoIcon_active.png');

        // Check that undo button is enabled and redo is disabled.
        $this->_checkButtonState('undo', TRUE);
        $this->_checkButtonState('redo', FALSE);

        // Make sure the content is reverted.
        $this->type('.');
        $this->assertHTMLMatch('<p>Lorem test....</p><p>EIB MOZ</p>');

    }//end testRedo()


    /**
     * Test that after 50 characters typed a new history item is created.
     *
     * @return void
     */
    public function testMaxCharlimit()
    {
        $text = $this->selectText('Lorem');
        $this->keyDown('Key.RIGHT');

        $chars = '';
        for ($i = 0; $i < 55; $i++) {
            $chars .= 'a';
        }

        $this->type($chars);

        $this->keyDown('Key.CMD + z');

        // Both Undo and Redo button should be active.
        $this->_checkButtonState('undo', TRUE);
        $this->_checkButtonState('redo', TRUE);

        $this->assertHTMLMatch('<p>Loremaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p><p>EIB MOZ</p>');
        sleep(1);

        $this->keyDown('Key.CMD + z');

        $this->_checkButtonState('undo', FALSE);
        $this->_checkButtonState('redo', TRUE);

        $this->assertHTMLMatch('<p>Lorem</p><p>EIB MOZ</p>');

    }//end testMaxCharlimit()


}//end class

?>
