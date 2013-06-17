<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_InputUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that typing standard characters work.
     *
     * @return void
     */
    public function testTextType()
    {
        $text = $this->selectKeyword(1);
        $this->keyDown('Key.DELETE');

        $chars  = '`1234567890-=qwertyuiop[]asdfghjkl;zxcvbnm,.';
        $chars .= 'QWERTYUIOPASDFGHJKLZXCVBNM';
        $chars .= '~!@#$%^&*()_+{}|:"<>?   . ';

        $this->type($chars);

        $expected  = '`1234567890-=qwertyuiop[]asdfghjkl;zxcvbnm,.';
        $expected .= 'QWERTYUIOPASDFGHJKLZXCVBNM';
        $expected .= '~!@#$%^&amp;*()_+{}|:"&lt;&gt;? &nbsp; .&nbsp;';

        $this->assertHTMLMatch('<p>'.$expected.'</p><p>EIB MOZ</p>');

    }//end testTextType()


    /**
     * Test that typing replaces the selected text.
     *
     * @return void
     */
    public function testTextTypeReplaceSelection()
    {
        $this->selectKeyword(1);

        $this->type('Testing input');

        $this->assertHTMLMatch('<p>Testing input</p><p>EIB MOZ</p>');

    }//end testTextTypeReplaceSelection()


    /**
     * Test enter a new paragraph.
     *
     * @return void
     */
    public function testCreatingANewParagraph()
    {
        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.ENTER');
        $this->type('Testing input');

        $this->assertHTMLMatch('<p>%1%</p><p>Testing input</p>');

    }//end testCreatingANewParagraph()


    /**
     * Test that using UP, DOWN, RIGHT, and LEFT arrows move caret correctly.
     *
     * @return void
     */
    public function testKeyboradNavigation()
    {
        $text = $this->selectKeyword(1);
        $this->type('Testing input');

        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->type('L');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.RIGHT');
        $this->type('R');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.DOWN');
        $this->type('D');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.UP');
        $this->type('U');

        $this->assertHTMLMatch('<p>TeUsting LinRput</p><p>EIB MOZD</p>');

    }//end testKeyboradNavigation()


    /**
     * Test that removing characters using BACKSPACE works.
     *
     * @return void
     */
    public function testBackspace()
    {
        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.CMD + b');
        $this->type('test');
        $this->keyDown('Key.CMD + b');
        $this->type(' input...');
        $this->keyDown('Key.ENTER');
        $this->type('Testing...');

        for ($i = 0; $i < 30; $i++) {
            $this->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>EIB MOZ</p>');

    }//end testBackspace()


    /**
     * Test that removing characters using DELETE works.
     *
     * @return void
     */
    public function testDelete()
    {
        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.CMD + b');
        $this->type('test');
        $this->keyDown('Key.CMD + b');
        $this->type(' input...');
        $this->keyDown('Key.ENTER');
        $this->type('Testing...');

        for ($i = 0; $i < 26; $i++) {
            $this->keyDown('Key.LEFT');
        }

        for ($i = 0; $i < 26; $i++) {
            $this->keyDown('Key.DELETE');
        }

        $this->assertHTMLMatch('<p>EIB MOZ</p>');

    }//end testDelete()


    /**
     * Test that holding down Shift + Right does select text.
     *
     * @return void
     */
    public function testRightKeyboardSelection()
    {
        $text = $this->selectKeyword(1);
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.DELETE');
        $this->type('p');
        $this->assertHTMLMatch('<p>pIB MOZ</p>');

    }//end testRightKeyboardSelection()


    /**
     * Test that holding down Shift + Left does select text.
     *
     * @return void
     */
    public function testLeftKeyboardSelection()
    {
        $text = $this->selectKeyword(1);
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.SHIFT + Key.LEFT');
        $this->keyDown('Key.DELETE');
        $this->type('p');
        $this->assertHTMLMatch('<p>pAX</p><p>EIB MOZ</p>');

    }//end testRightKeyboardSelection()


    /**
     * Test that selecting the whole content is possible with short cut.
     *
     * @return void
     */
    public function testSelectAllAndRemove()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.DELETE');

        $this->type('abc');
        $this->assertHTMLMatch('<p>abc</p>');

    }//end testSelectAllAndRemove()


    /**
     * Test that selecting the whole content is possible with short cut.
     *
     * @return void
     */
    public function testSelectAllAndReplace()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + a');

        sleep(1);
        $this->type('abc');
        $this->assertHTMLMatch('<p>abc</p>');

    }//end testSelectAllAndReplace()


    /**
     * Test that you can delete all content and then undo the changes.
     *
     * @return void
     */
    public function testDeleteAllClickUndoAndClickRedo()
    {

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.DELETE');
        sleep(1);
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
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.DELETE');
        sleep(1);
        $this->assertHTMLMatch('<p></p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'), 'Redo icon should be disabled');

        $this->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'), 'Undo icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo'), 'Redo icon should be active');

        $this->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<p></p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be active');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'), 'Redo icon should be disabled');

        $this->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ</p>');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'), 'Undo icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('historyRedo'), 'Redo icon should be active');


    }//end testDeleteAllClickUndoAndClickRedo()


    /**
     * Tests that after removing paragraphs and typing it creates a new paragraph.
     *
     * @return void
     */
    public function testDeleteParagraphAndType()
    {
        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.DELETE');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be enabled');
        $this->type('test123');
        sleep(1);
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p><p>test123</p>');

        $this->keyDown('Key.ENTER');
        $this->type('123test');
        sleep(1);
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p><p>test123</p><p>123test</p>');

        $this->useTest(1);
        $this->execJS('viper.setSetting("defaultBlockTag", "div")');

        $this->selectKeyword(1, 2);
        $this->keyDown('Key.DELETE');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be enabled');
        $this->type('test123');
        sleep(1);
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p><div>test123</div>');

        $this->keyDown('Key.ENTER');
        $this->type('123test');
        sleep(1);
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p><div>test123</div><div>123test</div>');

        $this->useTest(1);
        $this->execJS('viper.setSetting("defaultBlockTag", "")');

        $this->selectKeyword(1, 2);
        $this->keyDown('Key.DELETE');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be enabled');
        $this->type('test123');
        sleep(1);
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p>test123');

        $this->keyDown('Key.ENTER');
        $this->type('123test');
        sleep(1);
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p>test123<br />123test');


    }//end testDeleteParagraphAndType()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testNoBaseTagInput()
    {
        $this->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test that typing characters in a node with no block parent does not cause
        // it to be wrapped with a block tag.
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('%1% test');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>%1%</p><p>%2%</p>test');

        // Test that enter key creates a BR tag instead of creating block elements
        // if the text has no wrapping block elements.
        $this->useTest(3);
        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('%1%<br /><br /> %2%');

        // Test that removing whole content and typing does not wrap text in a block
        // element.
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // does not wrap text in a block element if there is no block element already.
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // uses the available block tag.
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('<p>test</p>');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('test');

    }//end testNoBaseTagInput()


    /**
     * Test that tabbing in to Viper from another input field works.
     *
     * @return void
     */
    public function testTabInToViper()
    {
        $this->moveToKeyword(1, 'right');

        $this->execJS('(function(){var input = document.createElement("input");dfx.insertBefore(document.body.firstChild, input);input.focus();return true;})()');
        sleep(2);
        $this->keyDown('Key.TAB');
        $this->type('123456');

        $this->assertHTMLMatch('<p>123456%1%</p><p>EIB MOZ</p>');

    }//end testTabInToViper()


    /**
     * Test that tabbing in to Viper from another input field works.
     *
     * @return void
     */
    public function testTabInToViperWithNoContent()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.DELETE');

        $this->execJS('(function(){var input = document.createElement("input");dfx.insertBefore(document.body.firstChild, input);input.focus();return true;})()');
        sleep(2);
        $this->keyDown('Key.TAB');
        $this->type('123456');

        $this->assertHTMLMatch('<p>123456</p>');

    }//end testTabInToViperWithNoContent()


    /**
     * Test embedding a youtube video.
     *
     * @return void
     */
    public function testEmbeddingVideo()
    {
        $this->click($this->findKeyword(1));
        $this->clickTopToolbarButton('sourceView');

        // Check to make sure the source editor appears.
        try {
            $image = $this->findImage('dragPopupIcon', '.Viper-popup-dragIcon');
        } catch (Exception $e) {
            $this->fail('Source editor did not appear on the screen');
        }

        // Embed the video
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.DELETE');
        $this->type('<iframe title="Roadmap" src="http://www.youtube.com/embed/PYm4Atlxe4M" allowfullscreen="" frameborder="0" height="315" width="420"></iframe>');
        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<iframe title="Roadmap" src="http://www.youtube.com/embed/PYm4Atlxe4M" allowfullscreen="" frameborder="0" height="315" width="420"></iframe>');

        

        $this->clickTopToolbarButton('sourceView');

        // Check to make sure the source editor appears.
        try {
            $image = $this->findImage('dragPopupIcon', '.Viper-popup-dragIcon');
        } catch (Exception $e) {
            $this->fail('Source editor did not appear on the screen');
        }

        // Embed the video
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.DELETE');
        $this->pasteFromURL($this->getTestURL('/Core/VideoWithObjectTags.txt'));
        $this->clickButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<object width="560" height="315"><param name="movie" value="http://www.youtube.com/v/f6ZSZbNfSpk?version=3&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/f6ZSZbNfSpk?version=3&amp;hl=en_GB" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true"></embed></object>'); 

    }//end testEmbeddingVideo()


}//end class

?>
