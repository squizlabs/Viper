<?php

require_once 'AbstractViperViewSourcePluginUnitTest.php';

class Viper_Tests_ViperViewSourcePlugin_ViewSourceTest extends AbstractViperViewSourcePluginUnitTest
{


   /**
     * Test that you can open and close the source editor.
     *
     * @return void
     */
    public function testOpenAndCloseSourceEditor()
    {
        $this->click($this->findKeyword(2));
        $this->clickTopToolbarButton('sourceView');

        // Check to make sure the source editor appears.
        try {
            $image = $this->findImage('dragPopupIcon', '.Viper-popup-dragIcon');
        } catch (Exception $e) {
            $this->fail('Source editor did not appear on the screen');
        }

        try {
            $closeIcon = $this->findImage('closePopupIcon', '.Viper-popup-closeIcon');
            $this->click($closeIcon);
        } catch (Exception $e) {
            $this->fail('Source editor does not have a close icon');
        }

        // Check to make sure the source editor does not appear.
        $sourceEditorNotFound = false;
        try {
            $this->find($image);
            $this->fail('Source editor still appears on the screen');
        } catch (Exception $e) {
            // Do nothing.
        }

    }//end testSourceCodeAppears()


   /**
     * Test that Viper is responsive after you close the source editor.
     *
     * @return void
     */
    public function testEditingAfterClosingSourceEditor()
    {
        $this->click($this->findKeyword(1));
        $this->clickTopToolbarButton('sourceView');

        $closeIcon = $this->findImage('closePopupIcon', '.Viper-popup-closeIcon');
        $this->click($closeIcon);

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');
        $this->click($this->findKeyword(3));
        $this->assertHTMLMatch('<p>Lorem <em>%1%</em> dolor</p><p><strong>%2%</strong> sit amet</p><p>%3% p <em>XuT</em></p>');

    }//end testEditingAfterClosingSourceEditor()


   /**
     * Test that you can edit the source code.
     *
     * @return void
     */
    public function testEditingTheSourceCode()
    {
        $this->click($this->findKeyword(2));
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.DELETE');

        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p></p>');

    }//end testEditingTheSourceCode()


   /**
     * Test that you can still edit the content once you deleted some the source code.
     *
     * @return void
     */
    public function testEditingContentAfterDeletingSourceCode()
    {
        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.SHIFT + Key.DOWN');
        $this->keyDown('Key.SHIFT + Key.DOWN');
        $this->keyDown('Key.SHIFT + Key.DOWN');
        $this->keyDown('Key.SHIFT + Key.DOWN');
        $this->keyDown('Key.SHIFT + Key.DOWN');
        $this->keyDown('Key.SHIFT + Key.DOWN');
        $this->keyDown('Key.DELETE');

        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem %1% dolor</p>');

        $this->selectKeyword(1);
        $this->assertEquals('%1%', $this->getSelectedText(), 'Keyword is not selected');

    }//end testEditingContentAfterDeletingSourceCode()


}//end class

?>
