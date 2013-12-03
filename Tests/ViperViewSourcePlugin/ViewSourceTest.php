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
        $this->sikuli->click($this->findKeyword(2));
        $this->clickTopToolbarButton('sourceView');

        // Check to make sure the source editor appears.
        try {
            $image = $this->findImage('dragPopupIcon', '.Viper-popup-dragIcon');
        } catch (Exception $e) {
            $this->fail('Source editor did not appear on the screen');
        }

        try {
            $closeIcon = $this->findImage('closePopupIcon', '.Viper-popup-closeIcon');
            $this->sikuli->click($closeIcon);
        } catch (Exception $e) {
            $this->fail('Source editor does not have a close icon');
        }

        // Check to make sure the source editor does not appear.
        $sourceEditorNotFound = false;
        try {
            $this->sikuli->find($image);
            $this->fail('Source editor still appears on the screen');
        } catch (Exception $e) {
            // Do nothing.
        }

    }//end testOpenAndCloseSourceEditor()


   /**
     * Test that Viper is responsive after you close the source editor.
     *
     * @return void
     */
    public function testEditingAfterClosingSourceEditor()
    {
        $this->sikuli->click($this->findKeyword(1));
        $this->clickTopToolbarButton('sourceView');

        $closeIcon = $this->findImage('closePopupIcon', '.Viper-popup-closeIcon');
        $this->sikuli->click($closeIcon);

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->sikuli->click($this->findKeyword(1));
        $this->sikuli->click($this->findKeyword(3));
        $this->assertHTMLMatch('<p>Lorem <em>%1%</em> dolor</p><p><strong>%2%</strong> sit amet</p><p>%3% p <em>XuT</em></p>');

    }//end testEditingAfterClosingSourceEditor()


   /**
     * Test that you can edit the source code.
     *
     * @return void
     */
    public function testEditingTheSourceCode()
    {
        $this->sikuli->click($this->findKeyword(2));
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('<p>Hello world</p>');

        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Hello world</p>');

    }//end testEditingTheSourceCode()


   /**
     * Test that you can edit the source code, click close but apply the changes.
     *
     * @return void
     */
    public function testEditingClosingTheWindowWithApplyingChanges()
    {
        $this->markTestSkipped('Atm the top buttons are removed when it switches windows. Need a way to keep the buttons there');

        $this->sikuli->click($this->findKeyword(2));
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');

        $closeIcon = $this->findImage('closePopupIcon', '.Viper-popup-closeIcon');
        $this->sikuli->click($closeIcon);

        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p></p>');

    }//end testEditingClosingTheWindowWithApplyingChanges()


   /**
     * Test that you can edit the source code and then discard the changes.
     *
     * @return void
     */
    public function testEditingAndDiscardingChanges()
    {
        $this->markTestSkipped('Atm the top buttons are removed when it switches windows. Need a way to keep the buttons there');

        $this->sikuli->click($this->findKeyword(2));
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');

        $closeIcon = $this->findImage('closePopupIcon', '.Viper-popup-closeIcon');
        $this->sikuli->click($closeIcon);

        $this->clickButton('Discard', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem %1% dolor</p><p><strong>%2%</strong> sit amet</p><p>%3% p <em>XuT</em></p>');

    }//end testEditingAndDiscardingChanges()


   /**
     * Test that you can open source view in a new window.
     *
     * @return void
     */
    public function testOpeningSourceViewInNewWindow()
    {
        $this->markTestSkipped('Atm the testing system cannot handle more than one window');

        $this->sikuli->click($this->findKeyword(2));
        $this->clickTopToolbarButton('sourceView');
        sleep(2);

        $newWindowIcon = $this->findImage('newWindowIcon', '.Viper-sourceNewWindow');
        $this->sikuli->click($newWindowIcon);

        $this->clickButton('Close Window', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem %1% dolor</p><p><strong>%2%</strong> sit amet</p><p>%3% p <em>XuT</em></p>');

    }//end testOpeningSourceViewInNewWindow()


   /**
     * Test that you can open source view in a new window and edit it.
     *
     * @return void
     */
    public function testOpeningSourceViewInNewWindowAndEditing()
    {
        $this->markTestSkipped('Atm the testing system cannot handle more than one window');

        $this->sikuli->click($this->findKeyword(2));
        $this->clickTopToolbarButton('sourceView');
        sleep(2);

        $newWindowIcon = $this->findImage('newWindowIcon', '.Viper-sourceNewWindow');
        $this->sikuli->click($newWindowIcon);

        sleep(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');

        $this->clickButton('Close Window', NULL, TRUE);

        $this->assertHTMLMatch('<p></p>');

    }//end testOpeningSourceViewInNewWindowAndEditing()


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
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        $this->sikuli->keyDown('Key.SHIFT + Key.DOWN');
        $this->sikuli->keyDown('Key.DELETE');

        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem %1% dolor</p>');

        $this->selectKeyword(1);
        $this->assertEquals('%1%', $this->getSelectedText(), 'Keyword is not selected');

    }//end testEditingContentAfterDeletingSourceCode()


    /**
     * Test that you can open the source editor after you embed a youtube video.
     *
     * @return void
     */
    public function testOpenSourceEditorAfterEmbeddingVideo()
    {
        $this->sikuli->click($this->findKeyword(2));
        $this->clickTopToolbarButton('sourceView');

        // Check to make sure the source editor appears.
        try {
            $image = $this->findImage('dragPopupIcon', '.Viper-popup-dragIcon');
        } catch (Exception $e) {
            $this->fail('Source editor did not appear on the screen');
        }

        // Embed the video
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('<iframe title="Roadmap" src="http://www.youtube.com/embed/PYm4Atlxe4M" allowfullscreen="" frameborder="0" height="315" width="420"></iframe>');
        $this->clickButton('Apply Changes', NULL, TRUE);

        // Check to make sure the source editor does not appear.
        $sourceEditorNotFound = false;
        try {
            $this->sikuli->find($image);
            $this->fail('Source editor still appears on the screen');
        } catch (Exception $e) {
            // Do nothing.
        }

        $this->clickTopToolbarButton('sourceView');

        // Check to make sure the source editor appears.
        try {
            $image = $this->findImage('dragPopupIcon', '.Viper-popup-dragIcon');
        } catch (Exception $e) {
            $this->fail('Source editor did not appear on the screen');
        }

    }//end testOpenSourceEditorAfterEmbeddingVideo()


}//end class

?>
