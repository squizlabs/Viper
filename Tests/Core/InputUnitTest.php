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
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');

        $this->type('`1234567890-=qwertyuiop[]asdfghjkl;zxcvbnm,.QWERTYUIOPASDFGHJKLZXCVBNM~!@#$%^&*()_+{}|:"<>?   . ');

        $this->assertHTMLMatch('<p>`1234567890-=qwertyuiop[]asdfghjkl;zxcvbnm,.QWERTYUIOPASDFGHJKLZXCVBNM~!@#$%^&amp;*()_+{}|:"&lt;&gt;?&nbsp;&nbsp; . EIB MOZ %2%</p>');

    }//end testTextType()


    /**
     * Test that typing multiple spaces changes the space to a &nbsp.
     *
     * @return void
     */
    public function testTextTypeWithMultipleSpaces()
    {
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        $this->type('   multiple    spaces between words    ');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp; multiple&nbsp;&nbsp;&nbsp;&nbsp;spaces between words</p><p>EIB MOZ %2%</p>');

        // Check that if you add multiple spaces onto the end of the content of the page, they are not saved.
        $this->moveToKeyword(2, 'right');
        $this->type('   ');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp; multiple&nbsp;&nbsp;&nbsp;&nbsp;spaces between words</p><p>EIB MOZ %2%</p>');

    }//end testTextTypeWithMultipleSpaces()


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
        $this->assertHTMLMatch('<p>Testing input</p><p>EIB MOZ %2%</p>');

    }//end testTextTypeReplaceSelection()


    /**
     * Test that you can delete all of the content and enter new content.
     *
     * @return void
     */
    public function testTextTypeReplaceAllContent()
    {
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('Testing input');

        //Check that the icons are correct in the top toolbar
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL));
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL));
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL));
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('removeFormat', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', NULL));
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('headings', NULL));
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', NULL));
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('listUL', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listOL', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listIndent', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listOutdent', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('table', NULL));
        $this->assertTrue($this->topToolbarButtonExists('image', NULL));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', NULL));
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('linkRemove', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('charmap', NULL));
        $this->assertTrue($this->topToolbarButtonExists('searchReplace', NULL));
        $this->assertTrue($this->topToolbarButtonExists('langtools', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('accessAudit', NULL));
        $this->assertTrue($this->topToolbarButtonExists('sourceView', NULL));

        $this->type(' more content');
        $this->assertHTMLMatch('<p>Testing input more content</p>');

    }//end testTextTypeReplaceAllContent()


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
        $this->assertHTMLMatch('<p>%1%</p><p>Testing input</p><p>EIB MOZ %2%</p>');

        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.UP');
        $this->type('New paragraph');
        $this->assertHTMLMatch('<p>New paragraph</p><p>%1%</p><p>Testing input</p><p>EIB MOZ %2%</p>');

    }//end testCreatingANewParagraph()


    /**
     * Test that the icons are available in the top toolbar when you create new paragraphs.
     *
     * @return void
     */
    public function testTopToolbarIcons()
    {
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL));
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL));
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL));
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('removeFormat', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', NULL));
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('headings', NULL));
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', NULL));
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('listUL', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listOL', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listIndent', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listOutdent', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('table', NULL));
        $this->assertTrue($this->topToolbarButtonExists('image', NULL));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', NULL));
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('linkRemove', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('charmap', NULL));
        $this->assertTrue($this->topToolbarButtonExists('searchReplace', NULL));
        $this->assertTrue($this->topToolbarButtonExists('langtools', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('accessAudit', NULL));
        $this->assertTrue($this->topToolbarButtonExists('sourceView', NULL));

        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.UP');
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL));
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL));
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL));
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('removeFormat', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', NULL));
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('headings', NULL));
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', NULL));
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('listUL', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listOL', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listIndent', NULL));
        $this->assertTrue($this->topToolbarButtonExists('listOutdent', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('table', NULL));
        $this->assertTrue($this->topToolbarButtonExists('image', NULL));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', NULL));
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('linkRemove', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('charmap', NULL));
        $this->assertTrue($this->topToolbarButtonExists('searchReplace', NULL));
        $this->assertTrue($this->topToolbarButtonExists('langtools', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('accessAudit', NULL));
        $this->assertTrue($this->topToolbarButtonExists('sourceView', NULL));

    }//end testTopToolbarIcons()


    /**
     * Test that using UP, DOWN, RIGHT, and LEFT arrows move caret correctly.
     *
     * @return void
     */
    public function testArrowKeyNavigation()
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

        $this->assertHTMLMatch('<p>TesUting LinRput</p><p>EIB MOZ D%2%</p>');

    }//end testArrowKeyNavigation()


    /**
     * Test that command left and right moves the caret to the start and end of the line.
     *
     * @return void
     */
    public function testCommandLeftAndCommandRight()
    {
        $this->useTest(9);
        $this->clickKeyword(1);

        if ($this->sikuli->getOS() === 'windows') {
            $this->sikuli->keyDown('Key.HOME');
            $this->type('left');
            $this->sikuli->keyDown('Key.END');
            $this->type('right');
        } else {
            $this->sikuli->keyDown('Key.CMD + Key.LEFT');
            $this->type('left');
            $this->sikuli->keyDown('Key.CMD + Key.RIGHT');
            $this->type('right');
        }

        $this->assertHTMLMatch('<p>leftLorem ipsum dolor sit XAX amet, consectetur adipiscing elit. Duis ac augue mi. rightNam risus massa, aliquam non porta vel, lacinia a sapien.</p>');

    }//end testCommandLeftAndCommandRight()


    /**
     * Test that holding down Shift + Left does select text.
     *
     * @return void
     */
    public function testShiftAndLeftArrow()
    {
        $this->useTest(1);

        $this->moveToKeyword(1, 'right');
        sleep(1);

        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'First line of text should be selected');

        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>testEIB MOZ %2%</p>');

    }//end testShiftAndLeftArrow()


    /**
     * Test that holding down Shift + Right does select text.
     *
     * @return void
     */
    public function testShiftAndRightArrow()
    {
        $this->useTest(1);

        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'First line of text should be selected');

        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<p>testIB MOZ %2%</p>');

    }//end testShiftAndRightArrow()


    /**
     * Test that using Alt + Left moves the cursor to the next word on OSX.
     *
     * @return void
     */
    public function testAltAndLeftArrow()
    {
        $this->runTestFor('osx');
        $this->useTest(1);

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ALT + Key.LEFT');
        $this->sikuli->keyDown('Key.ALT + Key.LEFT');
        $this->sikuli->keyDown('Key.ALT + Key.LEFT');

        $this->type('test ');
        $this->assertHTMLMatch('<p>%1%</p><p>test EIB MOZ %2%</p>');

    }//end testAltAndLeftArrow()


    /**
     * Test that using Alt + Right moves the cursor to the next word on OSX.
     *
     * @return void
     */
    public function testAltAndRightArrow()
    {
        $this->runTestFor('osx');
        $this->useTest(1);

        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ALT + Key.RIGHT');
        $this->sikuli->keyDown('Key.ALT + Key.RIGHT');
        $this->sikuli->keyDown('Key.ALT + Key.RIGHT');

        $this->type(' test');
        $this->assertHTMLMatch('<p>%1%</p><p>EIB MOZ test %2%</p>');

    }//end testAltAndRightArrow()


    /**
     * Test that using CTRL + Left moves the cursor to the previous word on Windows.
     *
     * @return void
     */
    public function testCtrlAndLeftArrow()
    {
        $this->runTestFor('windows');
        $this->useTest(1);

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CTRL + Key.LEFT');
        $this->sikuli->keyDown('Key.CTRL + Key.LEFT');
        $this->sikuli->keyDown('Key.CTRL + Key.LEFT');

        $this->type('test ');
        $this->assertHTMLMatch('<p>%1%</p><p>test EIB MOZ %2%</p>');

    }//end testCtrlAndLeftArrow()


    /**
     * Test that using CTRL + Right moves the cursor to the next word on Windows.
     *
     * @return void
     */
    public function testCtrlAndRightArrow()
    {
        $this->runTestFor('windows');
        $this->useTest(1);

        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.CTRL + Key.RIGHT');
        $this->sikuli->keyDown('Key.CTRL + Key.RIGHT');
        $this->sikuli->keyDown('Key.CTRL + Key.RIGHT');

        $this->type('test ');
        $this->assertHTMLMatch('<p>%1%</p><p>EIB test MOZ %2%</p>');

    }//end testAltAndRightArrow()


    /**
     * Test that using Cmd+Shift+Left and Cmd+Shift+Right highlights the line of text in OSX.
     *
     * @return void
     */
    public function testCmdShiftLeftAndCmdShiftRight()
    {
        $this->runTestFor('osx');
        $this->useTest(1);

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.CMD + Key.LEFT');
        $this->assertEquals($this->replaceKeywords('EIB MOZ %2%'), $this->getSelectedText(), 'Second line of text should be selected');
        // Check inline toolbar appears
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('headings', NULL));

        $this->sikuli->keyDown('Key.LEFT');
        $this->assertEquals($this->replaceKeywords(''), $this->getSelectedText(), 'Nothing should be selected');

        $this->sikuli->keyDown('Key.SHIFT + Key.CMD + Key.RIGHT');
        $this->assertEquals($this->replaceKeywords('EIB MOZ %2%'), $this->getSelectedText(), 'Second line of text should be selected');
        // Check inline toolbar appears
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('headings', NULL));

    }//end testCmdShiftLeftAndCmdShiftRight()


    /**
     * Test that using Shift+Home and Shift+End highlights the line of text in Windows.
     *
     * @return void
     */
    public function testShiftHomeAndShiftEnd()
    {
        $this->runTestFor('windows');
        $this->useTest(1);

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.HOME');
        $this->assertEquals($this->replaceKeywords('EIB MOZ %2%'), $this->getSelectedText(), 'Second line of text should be selected');
        // Check inline toolbar appears
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('headings', NULL));

        $this->sikuli->keyDown('Key.LEFT');
        $this->assertEquals($this->replaceKeywords(''), $this->getSelectedText(), 'Nothing should be selected');

        $this->sikuli->keyDown('Key.SHIFT + Key.END');
        $this->assertEquals($this->replaceKeywords('EIB MOZ %2%'), $this->getSelectedText(), 'Second line of text should be selected');
        // Check inline toolbar appears
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'));
        $this->assertTrue($this->inlineToolbarButtonExists('headings', NULL));

    }//end testShiftHomeAndShiftEnd()


    /**
     * Test that using Shift + Ctrl+ Left hightlights the word to the left.
     *
     * @return void
     */
    public function testShiftCtrlAndLeftArrow()
    {
        $this->useTest(1);

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.CTRL + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.CTRL + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.CTRL + Key.LEFT');
        sleep(1);
        $this->assertEquals($this->replaceKeywords('EIB MOZ %2%'), $this->getSelectedText(), 'Second line of text should be selected');

    }//end testShiftCtrlAndLeftArrow()


    /**
     * Test that using Shift + Ctrl+ Right hightlights the word to the right
     *
     * @return void
     */
    public function testShiftCtrlAndRightArrow()
    {
        $this->useTest(1);

        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.SHIFT + Key.CTRL + Key.RIGHT');
        sleep(1);
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'First line of text should be selected');

    }//end testShiftCtrlAndRightArrow()


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

        $this->type('This is the first paragraph');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('This is the second paragraph');
        $this->assertHTMLMatch('<p>This is the first paragraph</p><p>This is the second paragraph</p>');

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
     * Test that using UP, DOWN, RIGHT, and LEFT arrows move caret correctly.
     *
     * @return void
     */
    public function testSelectAllAndArrowKeyNavigation()
    {
        // Select all of the content and then press left arrow key
        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('new');
        $this->assertHTMLMatch('<p>newtest test1 test2</p><p>test3 test4 test5</p><p>%1% test6 test7</p><p>test8 test9 <strong>%2%</strong></p>');

        // Select all of the content and then press right arrow key
        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('new');
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p><p>%1% test6 test7</p><p>test8 test9 <strong>%2%new</strong></p>');

        // Select all of the content and then press up arrow key
        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.UP');
        $this->type('new');
        $this->assertHTMLMatch('<p>newtest test1 test2</p><p>test3 test4 test5</p><p>%1% test6 test7</p><p>test8 test9 <strong>%2%</strong></p>');

        // Select all of the content and then press down arrow key
        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DOWN');
        $this->type('new');
        $this->assertHTMLMatch('<p>test test1 test2</p><p>test3 test4 test5</p><p>%1% test6 test7</p><p>test8 test9 <strong>%2%new</strong></p>');

    }//end testSelectAllAndArrowKeyNavigation()


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

        $this->assertHTMLMatch('<p>XAX</p><p>testEIB MOZ %2%</p>');

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

        $this->assertHTMLMatch('<p><strong>XAX</strong></p><p>testtest</p><p>EIB MOZ %2%</p>');

    }//end testJoinParagraphsAndSplitAtEndOfTag()


    /**
     * Tests that you can split two a tags with a br tag or into two paragraphs.
     *
     * @return void
     */
    public function testSplittingTwoATags()
    {
        $this->useTest(8);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.ENTER');
        $this->assertHTMLMatch('<p><a href="#">Link %1%</a><br/><a href="#">Link %2%</a></p>');

        $this->useTest(8);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="#">Link %1%</a></p><p><a href="#">Link %2%</a></p>');

    }//end testSplittingTwoATags()


    /**
     * Test that tabbing in to Viper from another input field works.
     *
     * @return void
     */
    public function testTabInToViper()
    {
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');

        $this->sikuli->execJS('(function(){var input = document.createElement("input");Viper.Util.insertBefore(document.body.firstChild, input);input.focus();return true;})()');
        sleep(2);
        $this->sikuli->keyDown('Key.TAB');
        $this->type('123456');

        $this->assertHTMLMatch('<p>123456%1%</p><p>EIB MOZ %2%</p>');

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

        $this->sikuli->execJS('(function(){var input = document.createElement("input");Viper.Util.insertBefore(document.body.firstChild, input);input.focus();return true;})()');
        sleep(2);
        $this->sikuli->keyDown('Key.TAB');
        $this->type('123456');

        $this->assertHTMLMatch('<p>123456</p>');

    }//end testTabInToViperWithNoContent()


    /**
     * Test entering content before a br tag.
     *
     * @return void
     */
    public function testEnteringContentBeforeBrTag()
    {
        $this->useTest(7);
        $this->clickKeyword(2);
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Testing input');
        $this->assertHTMLMatch('<p>%1%</p><p>Testing input<br />%2%<br />%3%</p>');

    }//end testEnteringContentBeforeBrTag()


    /**
     * Test splitting a single p tag in to three and then merging back to one.
     *
     * @return void
     */
    public function testSplittingAndRejoiningParagraphs()
    {
        // Test rejoining using backspace key
        $this->useTest(10);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p>%1%Test content</p><p>%2% paragraph.%3%</p>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertHTMLMatch('<p>%1%Test content %2% paragraph.%3%</p>');

        // Test rejoing with delete key
        $this->useTest(10);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p>%1%Test content %2%</p><p> paragraph.%3%</p>');

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertHTMLMatch('<p>%1%Test content %2% paragraph.%3%</p>');

    }//end testSplittingAndRejoiningParagraphs()

    
    /**
     * Test splitting a single p tag in to three and then merging back to one with bold formatting.
     *
     * @return void
     */
    public function testSplittingAndRejoiningBoldParagraphs()
    {
        // Test rejoining using backspace key
        $this->useTest(10);
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('bold', NULL);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><strong>%1%Test content</strong></p><p><strong>%2% paragraph.%3%</strong></p>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertHTMLMatch('<p><strong>%1%Test content %2% paragraph.%3%</strong></p>');

        // Test rejoing with delete key
        $this->useTest(10);
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('bold', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><strong>%1%Test content %2%</strong></p><p><strong> paragraph.%3%</strong></p>');

        $this->clickKeyword(1);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertHTMLMatch('<p><strong>%1%Test content %2% paragraph.%3%</strong></p>');

    }//end testSplittingAndRejoiningBoldParagraphs()


    /**
     * Test splitting a single p tag in to three and then merging back to one with italic formatting.
     *
     * @return void
     */
    public function testSplittingAndRejoiningItalicParagraphs()
    {
        // Test rejoining using backspace key
        $this->useTest(10);
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('italic', NULL);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><em>%1%Test content</em></p><p><em>%2% paragraph.%3%</em></p>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertHTMLMatch('<p><em>%1%Test content %2% paragraph.%3%</em></p>');

        // Test rejoing with delete key
        $this->useTest(10);
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('italic', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><em>%1%Test content %2%</em></p><p><em> paragraph.%3%</em></p>');

        $this->clickKeyword(1);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertHTMLMatch('<p><em>%1%Test content %2% paragraph.%3%</em></p>');

        }//end testSplittingAndRejoiningItalicParagraphs()

    /**
     * Test splitting a single p tag in to three and then merging back to one with superscript formatting.
     *
     * @return void
     */
    public function testSplittingAndRejoiningSuperscriptParagraphs()
    {
        // Test rejoining using backspace key
        $this->useTest(10);
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><sup>%1%Test content</sup></p><p><sup>%2% paragraph.%3%</sup></p>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertHTMLMatch('<p><sup>%1%Test content %2% paragraph.%3%</sup></p>');

        // Test rejoing with delete key
        $this->useTest(10);
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><sup>%1%Test content %2%</sup></p><p><sup> paragraph.%3%</sup></p>');

        $this->clickKeyword(1);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertHTMLMatch('<p><sup>%1%Test content %2% paragraph.%3%</sup></p>');

    }//end testSplittingAndRejoiningSuperscriptParagraphs()


    /**
     * Test splitting a single p tag in to three and then merging back to one with subscript formatting.
     *
     * @return void
     */
    public function testSplittingAndRejoiningSubscriptParagraphs()
    {
        // Test rejoining using backspace key
        $this->useTest(10);
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><sub>%1%Test content</sub></p><p><sub>%2% paragraph.%3%</sub></p>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertHTMLMatch('<p><sub>%1%Test content %2% paragraph.%3%</sub></p>');

        // Test rejoing with delete key
        $this->useTest(10);
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><sub>%1%Test content %2%</sub></p><p><sub> paragraph.%3%</sub></p>');

        $this->clickKeyword(1);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertHTMLMatch('<p><sub>%1%Test content %2% paragraph.%3%</sub></p>');

    }//end testSplittingAndRejoiningSubscriptParagraphs()


    /**
     * Test splitting a single p tag in to three and then merging back to one with strikethrough formatting.
     *
     * @return void
     */
    public function testSplittingAndRejoiningStrikethroughParagraphs()
    {
        // Test rejoining using backspace key
        $this->useTest(10);
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><del>%1%Test content</del></p><p><del>%2% paragraph.%3%</del></p>');

        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);
        $this->assertHTMLMatch('<p><del>%1%Test content %2% paragraph.%3%</del></p>');

        // Test rejoing with delete key
        $this->useTest(10);
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><del>%1%Test content %2%</del></p><p><del> paragraph.%3%</del></p>');

        $this->clickKeyword(1);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->assertHTMLMatch('<p><del>%1%Test content %2% paragraph.%3%</del></p>');

    }//end testSplittingAndRejoiningStrikethroughParagraphs()

}//end class
