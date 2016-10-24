<?php

require_once 'AbstractViperImagePluginUnitTest.php';

class Viper_Tests_ViperReplacementPlugin_UndoAndRedoKeywordUnitTest extends AbstractViperImagePluginUnitTest
{

    /**
     * Test that keyword can be deleted.
     *
     * @return void
     */
    public function testUndoAndRedoDeletingKeywords()
    {
        // Using keyboard shortcuts
        $this->useTest(1);
        $this->clickKeyword(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(3);
        $this->sikuli->keyDown('Key.CMD + z');
        sleep(5);

        $this->assertHTMLMatch('<p>%1% ((prop:productName)) %2%</p><p>%3% %4%</p>');
        $this->assertRawHTMLMatch('<p>%1%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %2%</p><p>%3% %4%</p>');

        // Test for redo
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');

        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>');

        // Using top toolbar
        $this->clickTopToolbarButton('historyUndo', NULL);

        $this->assertHTMLMatch('<p>%1% ((prop:productName)) %2%</p><p>%3% %4%</p>');
        $this->assertRawHTMLMatch('<p>%1%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %2%</p><p>%3% %4%</p>');

        // Test for redo
        $this->clickTopToolbarButton('historyRedo', NULL);

        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>');

    }//end testUndoAndRedoDeletingKeywords()

}
