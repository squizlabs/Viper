<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperViewSourcePlugin_ViewSourceTest extends AbstractViperUnitTest
{


    /**
     * Test that you can open and close the source editor.
     *
     * @return void
     */
    public function testOpenAndCloseSourceEditor()
    {
        $this->moveToKeyword(2);
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
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('sourceView');

        $closeIcon = $this->findImage('closePopupIcon', '.Viper-popup-closeIcon');
        $this->sikuli->click($closeIcon);

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->sikuli->click($this->findKeyword(1));
        $this->sikuli->click($this->findKeyword(3));
        $this->assertHTMLMatch('<p>Lorem dolor <em>%1%</em></p><p><strong>%2%</strong> sit amet</p><p>%3% test <em>XuT</em></p>');

    }//end testEditingAfterClosingSourceEditor()


    /**
     * Test that you can edit the source code.
     *
     * @return void
     */
    public function testEditingTheSourceCode()
    {
        $this->moveToKeyword(2);
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

        $this->moveToKeyword(2);
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

        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');

        $closeIcon = $this->findImage('closePopupIcon', '.Viper-popup-closeIcon');
        $this->sikuli->click($closeIcon);

        $this->clickButton('Discard', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem dolor %1%</p><p><strong>%2%</strong> sit amet</p><p>%3% test <em>XuT</em></p>');

    }//end testEditingAndDiscardingChanges()


    /**
     * Test that you can open source view in a new window.
     *
     * @return void
     */
    public function testOpeningSourceViewInNewWindow()
    {
        $this->markTestSkipped('Atm the testing system cannot handle more than one window');

        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);

        $newWindowIcon = $this->findImage('newWindowIcon', '.Viper-sourceNewWindow');
        $this->sikuli->click($newWindowIcon);

        $this->clickButton('Close Window', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lorem dolor %1%</p><p><strong>%2%</strong> sit amet</p><p>%3% test <em>XuT</em></p>');

    }//end testOpeningSourceViewInNewWindow()


    /**
     * Test that you can open source view in a new window and edit it.
     *
     * @return void
     */
    public function testOpeningSourceViewInNewWindowAndEditing()
    {
        $this->markTestSkipped('Atm the testing system cannot handle more than one window');

        $this->moveToKeyword(2);
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

        $this->assertHTMLMatch('<p>Lorem dolor %1%</p>');

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
        $this->moveToKeyword(2);
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


    /**
     * Test different types of tags in Viper
     *
     * @return void
     */
    public function testAddingDifferentTagsInSourceCode()
    {
        // Test that script tags are removed when they are entered in source code
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('sourceView');

        // Check to make sure the source editor appears.
        try {
            $image = $this->findImage('dragPopupIcon', '.Viper-popup-dragIcon');
        } catch (Exception $e) {
            $this->fail('Source editor did not appear on the screen');
        }

        // Embed script tags
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('<canvas id="myCanvas"></canvas><script></script>');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><canvas id="myCanvas"></canvas></p>');

        // Test form and text area tags remain when they are entered in source code.
        $this->clickTopToolbarButton('sourceView');

        // Check to make sure the source editor appears.
        try {
            $image = $this->findImage('dragPopupIcon', '.Viper-popup-dragIcon');
        } catch (Exception $e) {
            $this->fail('Source editor did not appear on the screen');
        }

        // Embed script tags
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('<form><label>Dave</label><input type="text"><textarea rows="5"></textarea><input type="submit" value="submit"></form>');
        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<form><label>Dave</label><input type="text" /><textarea rows="5"></textarea><input type="submit" value="submit" /></form>');


    }//end testAddingDifferentTagsInSourceCode()


    /**
     * Test that when you enter code without P tags but with BR tags that it wraps the code with P tags.
     *
     * @return void
     */
    public function testAddingCodeWithBrTags()
    {
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('Lead and Succeed with Middlesex University<br/>At Middlesex University, we give our graduates the confidence and skills to launch into');
        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Lead and Succeed with Middlesex University<br/>At Middlesex University, we give our graduates the confidence and skills to launch into</p>');

    }//end testAddingCodeWithBrTags()

}//end class

?>
