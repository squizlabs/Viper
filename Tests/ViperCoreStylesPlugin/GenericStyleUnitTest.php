<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_GenericStyleUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that starting and stopping styles is working with keyboard shortcuts.
     *
     * @return void
     */
    public function testStartAndStopStyleWithShortcut()
    {
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');

        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->type('TEST');
        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');

        $this->type(' ');
        $this->keyDown('Key.CMD + i');
        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->type('TEST');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->type('TEST');
        $this->keyDown('Key.CMD + b');
        $this->type('TEST');
        $this->keyDown('Key.CMD + i');
        $this->type('TEST');
        $this->keyDown('Key.CMD + i');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>text XAX<strong>TEST</strong><em><strong>TEST</strong></em>TEST<strong>TEST<em>TEST</em></strong> test</p>');

    }//end testStartAndStopStyleWithShortcut()


    /**
     * Test that starting and stopping styles is working with toolbar buttons.
     *
     * @return void
     */
    public function testStartAndStopStyleWithButtons()
    {
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');

        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->type('TEST');
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');

        $this->type(' ');
        $this->clickTopToolbarButton('italic');
        $this->clickTopToolbarButton('bold');
        $this->assertTrue($this->topToolbarButtonExists('bold', 'active'), 'Bold icon in the top toolbar is not active');
        $this->assertTrue($this->topToolbarButtonExists('italic', 'active'), 'Italic icon in the top toolbar is not active');
        $this->type('TEST');
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');

        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'Italic icon in the top toolbar is active');
        $this->type('TEST');
        $this->clickTopToolbarButton('bold');
        $this->type('TEST');
        $this->clickTopToolbarButton('italic');
        $this->type('TEST');
        $this->clickTopToolbarButton('italic', 'active');
        $this->clickTopToolbarButton('bold', 'active');

        $this->assertHTMLMatch('<p>text %1%<strong>TEST</strong> <em><strong>TEST</strong></em>TEST<strong>TEST<em>TEST</em></strong> test</p>');

    }//end testStartAndStopStyleWithButtons()


    /**
     * Test that starting and stopping styles is working inside existing styles.
     *
     * @return void
     */
    public function testStartAndStopStylesInActiveStyles()
    {
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');

        $this->type(' ');

        // Turn on and off bold.
        $this->clickTopToolbarButton('bold', 'active');
        $this->clickTopToolbarButton('italic', 'active');
        $this->type('TEST');
        $this->keyDown('Key.CMD + i');
        $this->type('TEST');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + b');
        $this->type('TEST');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $this->keyDown('Key.CMD + i');
        $this->type('TEST');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $this->type('TEST');

        $this->assertHTMLMatch('<p><em><strong>text %1%</strong></em>TESTTEST<strong>TEST</strong>TEST<strong><em>TEST</em></strong><em><strong> test</strong></em></p>');

    }//end testStartAndStopStylesInActiveStyles()


    /**
     * Test that stopping styles is working at the end of an existing style.
     *
     * @return void
     */
    public function testStopStyleAtTheEndOfStyleTag()
    {
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');

        $this->keyDown('Key.CMD + b');
        $this->assertTrue($this->topToolbarButtonExists('bold'), 'Bold icon in the top toolbar is active');
        $this->keyDown('Key.CMD + i');
        $this->assertTrue($this->topToolbarButtonExists('italic'), 'italic icon in the top toolbar is active');
        $this->type('TEST');

        $this->assertHTMLMatch('<p><em><strong>text %1%</strong></em>TEST</p>');

    }//end testStopStyleAtTheEndOfStyleTag()


}//end class

?>
