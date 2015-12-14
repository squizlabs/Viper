<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_Core_BaseTagUnitTest extends AbstractViperUnitTest
{


	/**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testNoBaseTagInputBoldFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test that typing characters in a node with no block parent does not cause
        // it to be wrapped with a block tag.
        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<strong>%1% test</strong>');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(3);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p><strong>%1%</strong></p><p><strong>test %2%</strong></p><strong>test</strong>');

        // Test that enter key creates a BR tag instead of creating block elements
        // if the text has no wrapping block elements.
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<strong>%1%<br /><br /> %2%</strong>');

        // Test that removing whole content and typing does not wrap text in a block
        // element.
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // does not wrap text in a block element if there is no block element already.
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // uses the available block tag.
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->type('test');
        sleep(1);
        $this->assertHTMLMatch('<p>test</p>');

        $this->useTest(5);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test applying bold
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->assertHTMLMatch('<strong>%1%</strong>');

        // Test applying bold to multiple tags
        $this->useTest(6);
        $this->selectKeyword(1);
        sleep(1);
        $this->getOSAltShortcut('SelectAll');
        sleep(1);
        $this->getOSAltShortcut('Bold');
        sleep(1);
        $this->assertHTMLMatch('<p><strong>%1% %2%</strong></p><strong>test</strong>');
    }// end testNoBaseTagInputBoldFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testNoBaseTagInputItalicFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test that typing characters in a node with no block parent does not cause
        // it to be wrapped with a block tag.
        $this->useTest(7);
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<em>%1% test</em>');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(8);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p><em>%1%</em></p><p><em>test %2%</em></p><em>test</em>');

        // Test that enter key creates a BR tag instead of creating block elements
        // if the text has no wrapping block elements.
        $this->useTest(9);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<em>%1%<br /><br /> %2%</em>');

        // Test that removing whole content and typing does not wrap text in a block
        // element.
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // does not wrap text in a block element if there is no block element already.
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // uses the available block tag.
        $this->useTest(10);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('<p>test</p>');

        $this->useTest(10);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test applying italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<em>%1%</em>');

        // Test applying italic to multiple tags
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p><em>%1% %2%</em></p><em>test</em>');

    }// end testNoBaseTagInputItalicFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testNoBaseTagInputStrikethroughFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test that typing characters in a node with no block parent does not cause
        // it to be wrapped with a block tag.
        $this->useTest(11);
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<del>%1% test</del>');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(12);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p><del>%1%</del></p><p><del>test %2%</del></p><del>test</del>');

        // Test that enter key creates a BR tag instead of creating block elements
        // if the text has no wrapping block elements.
        $this->useTest(13);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<del>%1%<br /><br /> %2%</del>');

        // Test that removing whole content and typing does not wrap text in a block
        // element.
        $this->useTest(11);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // does not wrap text in a block element if there is no block element already.
        $this->useTest(11);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // uses the available block tag.
        $this->useTest(14);
        $this->selectKeyword(1);
        $this->type('test');
        sleep(1);
        $this->assertHTMLMatch('<p>test</p>');

        $this->useTest(14);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test applying italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<del>%1%</del>');

        // Test applying italic to multiple tags
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p><del>%1% %2%</del></p><del>test</del>');
    }// end testNoBaseTagInputStrikethroughFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testNoBaseTagInputSubscriptFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test that typing characters in a node with no block parent does not cause
        // it to be wrapped with a block tag.
        $this->useTest(15);
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<sub>%1% test</sub>');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(16);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p><sub>%1%</sub></p><p><sub>test %2%</sub></p><sub>test</sub>');

        // Test that enter key creates a BR tag instead of creating block elements
        // if the text has no wrapping block elements.
        $this->useTest(17);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sub>%1%<br /><br /> %2%</sub>');

        // Test that removing whole content and typing does not wrap text in a block
        // element.
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // does not wrap text in a block element if there is no block element already.
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // uses the available block tag.
        $this->useTest(18);
        $this->selectKeyword(1);
        $this->type('test');
        sleep(1);
        $this->assertHTMLMatch('<p>test</p>');

        $this->useTest(18);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test applying italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('<sub>%1%</sub>');

        // Test applying italic to multiple tags
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('<p><sub>%1% %2%</sub></p><sub>test</sub>');
    }// end testNoBaseTagInputSubscriptFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testNoBaseTagInputSuperscriptFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test that typing characters in a node with no block parent does not cause
        // it to be wrapped with a block tag.
        $this->useTest(19);
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<sup>%1% test</sup>');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(20);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p><sup>%1%</sup></p><p><sup>test %2%</sup></p><sup>test</sup>');

        // Test that enter key creates a BR tag instead of creating block elements
        // if the text has no wrapping block elements.
        $this->useTest(21);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sup>%1%<br /><br /> %2%</sup>');

        // Test that removing whole content and typing does not wrap text in a block
        // element.
        $this->useTest(19);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // does not wrap text in a block element if there is no block element already.
        $this->useTest(19);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test that removing whole content by selecting all and typing characters
        // uses the available block tag.
        $this->useTest(22);
        $this->selectKeyword(1);
        $this->type('test');
        sleep(1);
        $this->assertHTMLMatch('<p>test</p>');

        $this->useTest(22);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('test');

        // Test applying italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<sup>%1%</sup>');

        // Test applying italic to multiple tags
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<p><sup>%1% %2%</sup></p><sup>test</sup>');
    }// end testNoBaseTagInputSuperscriptFormat()


}//end class