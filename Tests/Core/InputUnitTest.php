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
        $this->useTest(1);
        $text = $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');

        $chars  = '`1234567890-=qwertyuiop[]asdfghjkl;zxcvbnm,.';
        $chars .= 'QWERTYUIOPASDFGHJKLZXCVBNM';
        $chars .= '~!@#$%^&*()_+{}|:"<>?   . ';

        $this->type($chars);

        $expected  = '`1234567890-=qwertyuiop[]asdfghjkl;zxcvbnm,.';
        $expected .= 'QWERTYUIOPASDFGHJKLZXCVBNM';
        $expected .= '~!@#$%^&amp;*()_+{}|:"&lt;&gt;? &nbsp; .';

        $this->assertHTMLMatch('<p>'.$expected.'</p><p>EIB MOZ</p>');

    }//end testTextType()


    /**
     * Test that typing replaces the selected text.
     *
     * @return void
     */
    public function testTextTypeReplaceSelection()
    {
        $this->useTest(1);
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
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Testing input');

        $this->assertHTMLMatch('<p>%1%</p><p>Testing input</p><p>EIB MOZ</p>');

    }//end testCreatingANewParagraph()


    /**
     * Test that using UP, DOWN, RIGHT, and LEFT arrows move caret correctly.
     *
     * @return void
     */
    public function testKeyboradNavigation()
    {
        $this->useTest(1);
        $text = $this->selectKeyword(1);
        $this->type('Testing input');

        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('L');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('R');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.DOWN');
        $this->type('D');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.UP');
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
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->type('test');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->type(' input...');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Testing...');

        $this->assertHTMLMatch('<p>XAX<strong>test</strong> input...</p><p>Testing...</p><p>EIB MOZ</p>');

        for ($i = 0; $i < 30; $i++) {
            $this->sikuli->keyDown('Key.BACKSPACE');
        }

        $this->assertHTMLMatch('<p>EIB MOZ</p>');

    }//end testBackspace()


    /**
     * Test that command left and right does nothing in the browser.
     *
     * @return void
     */
    public function testCommandLeftAndCommandRight()
    {
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + Key.LEFT');
        $this->type(' test');
        $this->assertHTMLMatch('<p>%1% test</p><p>EIB MOZ</p>');

        $this->sikuli->keyDown('Key.CMD + Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('<p>%1% test test</p><p>EIB MOZ</p>');

    }//end testCommandLeftAndCommandRight()


    /**
     * Test that removing characters using DELETE works.
     *
     * @return void
     */
    public function testDelete()
    {
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->type('test');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->type(' input...');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Testing...');

        for ($i = 0; $i < 27; $i++) {
            $this->sikuli->keyDown('Key.LEFT');
        }

        for ($i = 0; $i < 28; $i++) {
            $this->sikuli->keyDown('Key.DELETE');
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
        $this->useTest(1);
        $text = $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.DELETE');
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
        $this->useTest(1);
        $text = $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.DELETE');
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
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');

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
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');

        sleep(1);
        $this->type('abc');
        $this->assertHTMLMatch('<p>abc</p>');

    }//end testSelectAllAndReplace()


    /**
     * Tests changing the defailt block tags and entering content.
     *
     * @return void
     */
    public function testDifferentDefaultBlockTags()
    {
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be enabled');
        $this->type('test123');
        sleep(1);
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p><p>test123</p>');

        $this->sikuli->keyDown('Key.ENTER');
        $this->type('123test');
        sleep(1);
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p><p>test123</p><p>123test</p>');

        $this->useTest(2);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "div")');

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be enabled');
        $this->type('test123');
        sleep(1);
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p><div>test123</div>');

        $this->sikuli->keyDown('Key.ENTER');
        $this->type('123test');
        sleep(1);
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p><div>test123</div><div>123test</div>');

        $this->useTest(2);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertTrue($this->topToolbarButtonExists('historyUndo'), 'Undo icon should be enabled');
        $this->type('test123');
        sleep(1);
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p>test123');

        $this->sikuli->keyDown('Key.ENTER');
        $this->type('123test');
        sleep(1);
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p>test123<br />123test');


    }//end testDifferentDefaultBlockTags()


    /**
     * Tests that after joining paragraphs splitting them again works.
     *
     * @return void
     */
    public function testJoinParagraphsAndSplit()
    {
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');

        $this->assertHTMLMatch('<p>XAX</p><p>testEIB MOZ</p>');

    }//end testJoinParagraphsAndSplit()


    /**
     * Tests that after joining paragraphs splitting them again works when caret is at the end of a tag.
     *
     * @return void
     */
    public function testJoinParagraphsAndSplitAtEndOfTag()
    {
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        $this->type('test');
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');

        $this->assertHTMLMatch('<p><strong>XAX</strong></p><p>testtest</p><p>EIB MOZ</p>');

    }//end testJoinParagraphsAndSplitAtEndOfTag()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testNoBaseTagInput()
    {
        $this->useTest(3);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test that typing characters in a node with no block parent does not cause
        // it to be wrapped with a block tag.
        $this->useTest(3);
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('%1% test');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>%1%</p><p> %2%</p>test');

        // Test that enter key creates a BR tag instead of creating block elements
        // if the text has no wrapping block elements.
        $this->useTest(5);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('%1%<br /><br /> %2%');

        // Test that removing whole content and typing does not wrap text in a block
        // element.
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // does not wrap text in a block element if there is no block element already.
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // uses the available block tag.
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('<p>test</p>');

        $this->useTest(6);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
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
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');

        $this->sikuli->execJS('(function(){var input = document.createElement("input");ViperUtil.insertBefore(document.body.firstChild, input);input.focus();return true;})()');
        sleep(2);
        $this->sikuli->keyDown('Key.TAB');
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
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');

        $this->sikuli->execJS('(function(){var input = document.createElement("input");ViperUtil.insertBefore(document.body.firstChild, input);input.focus();return true;})()');
        sleep(2);
        $this->sikuli->keyDown('Key.TAB');
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
        $this->useTest(1);
        $this->sikuli->click($this->findKeyword(1));
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

        $this->assertHTMLMatch('<iframe title="Roadmap" src="http://www.youtube.com/embed/PYm4Atlxe4M" allowfullscreen="" frameborder="0" height="315" width="420"></iframe>');

        $this->clickTopToolbarButton('sourceView');

        // Check to make sure the source editor appears.
        try {
            $image = $this->findImage('dragPopupIcon', '.Viper-popup-dragIcon');
        } catch (Exception $e) {
            $this->fail('Source editor did not appear on the screen');
        }

        // Embed the video using object tags
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('<object width="560" height="315"><param name="movie" value="http://www.youtube.com/v/f6ZSZbNfSpk?version=3&amp;hl=en_GB"></param><param name="allowFullScreen" value="true"></param><param name="allowscriptaccess" value="always"></param><embed src="http://www.youtube.com/v/f6ZSZbNfSpk?version=3&amp;hl=en_GB" type="application/x-shockwave-flash" width="560" height="315" allowscriptaccess="always" allowfullscreen="true"></embed></object>');
        $this->clickButton('Apply Changes', NULL, TRUE);


    }//end testEmbeddingVideo()


}//end class

?>
