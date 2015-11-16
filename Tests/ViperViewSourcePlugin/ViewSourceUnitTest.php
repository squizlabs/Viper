<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperViewSourcePlugin_ViewSourceUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that you can open and close the source editor.
     *
     * @return void
     */
    public function testOpenAndCloseSourceEditor()
    {
        $this->useTest(1);
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
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('sourceView');

        $closeIcon = $this->findImage('closePopupIcon', '.Viper-popup-closeIcon');
        $this->sikuli->click($closeIcon);

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->clickKeyword(1);
        $this->clickKeyword(3);
        $this->assertHTMLMatch('<p>Lorem dolor <em>%1%</em></p><p><strong>%2%</strong> sit amet</p><p>%3% test <em>XuT</em></p>');

    }//end testEditingAfterClosingSourceEditor()


    /**
     * Test that you can edit the source code.
     *
     * @return void
     */
    public function testEditingTheSourceCode()
    {
        $this->useTest(1);
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
     * Test that cursor automatically corrects itself to be in current position.
     *
     * @return void
     */
    public function testCursorPositionInSourceCode()
    {
        $this->useTest(2);
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->type('Needs more content...');

        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% Test content.</p><p>Needs more content... More test content then more test content and then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then still more test content then even more test content then even more test content then %2% then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content some might say that theres too much content...</p><p>But theyre wrong because theres still more test content and then theres more test content and then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then %3% then even more test content then even more test content and then the content stops.</p>');

        $this->moveToKeyword(3);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->type('Still not enough content...');

        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% Test content.</p><p>Needs more content... More test content then more test content and then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then still more test content then even more test content then even more test content then %2% then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content some might say that theres too much content...</p><p>Still not enough content... But theyre wrong because theres still more test content and then theres more test content and then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then even more test content then %3% then even more test content then even more test content and then the content stops.</p>');

    }//end testCursorPositionInSourceCode()


    /**
     * Test that commenting with the source code retains source.
     *
     * @return void
     */
    public function testCommentingInSourceCode()
    {
        // Test entire HTML
        $this->useTest(3);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->moveToKeyword(2, 'left');

        for ($i = 0; $i < 13; $i++) {
            $this->sikuli->keyDown('Key.LEFT');
        }
        $this->type('<!---');
        $this->moveToKeyword(3, 'right');

        for ($i = 0; $i < 5; $i++) {
            $this->sikuli->keyDown('Key.RIGHT');
        }
        $this->type('--->');

        $this->clickButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<!---<p>%1%Test%2% content.</p><p>More test content.</p><p>Even more test content.%3%</p>--->');

    }//end testCommentingInSourceCode()


    /**
     * Test that you can edit the source code, click close but apply the changes.
     *
     * @return void
     */
    public function testEditingClosingTheWindowWithApplyingChanges()
    {
        $this->useTest(1);
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');

        $closeIcon = $this->findImage('closePopupIcon', '.Viper-popup-closeIcon');
        $this->sikuli->click($closeIcon);

        // Wait for animations to complete.
        sleep(2);

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
        $this->useTest(1);
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');

        $closeIcon = $this->findImage('closePopupIcon', '.Viper-popup-closeIcon');
        $this->sikuli->click($closeIcon);
        sleep(1);
        $this->clickButton('Discard', NULL, TRUE);
        sleep(1);

        $this->assertHTMLMatch('<p>Lorem dolor %1%</p><p><strong>%2%</strong> sit amet</p><p>%3% test <em>XuT</em></p>');

    }//end testEditingAndDiscardingChanges()


    /**
     * Test that you can open source view in a new window.
     *
     * @return void
     */
    public function testOpeningSourceViewInNewWindow()
    {
        $this->useTest(1);
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
        $this->useTest(1);
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
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('sourceView');
        sleep(2);
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.DOWN');
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

        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('<p>Lorem dolor %1% test</p>');

    }//end testEditingContentAfterDeletingSourceCode()


    /**
     * Test that you can open the source editor after you embed a youtube video.
     *
     * @return void
     */
    public function testOpenSourceEditorAfterEmbeddingVideo()
    {
        $this->useTest(1);
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
        $this->useTest(1);
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
        $this->useTest(1);
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
