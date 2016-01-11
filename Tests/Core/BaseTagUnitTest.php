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

        // Test applying bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Bold');
        $this->assertHTMLMatch('<strong>%1%</strong>');

        // Test applying bold using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<strong>%1%</strong>');

        // Test applying bold to multiple tags using keyboard shortcuts
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        $this->getOSAltShortcut('Bold');
        $this->assertHTMLMatch('<p><strong>%1% %2%</strong></p><strong>test</strong>');

        // Test applying bold to multiple tags using the top toolbar
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        $this->clickTopToolbarButton('bold');
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

        // Test applying italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->assertHTMLMatch('<em>%1%</em>');

        // Test applying italic using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<em>%1%</em>');

        // Test applying italic to multiple tags using keyboard shortcuts
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        $this->getOSAltShortcut('Italic');
        $this->assertHTMLMatch('<p><em>%1% %2%</em></p><em>test</em>');

        // Test applying italic to multiple tags using the top toolbar
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        sleep(2);
        $this->clickTopToolbarButton('italic');
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
        sleep(1);
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

        // Test applying italic using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('<sub>%1%</sub>');

        // Test applying italic to multiple tags using the top toolbar
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
        sleep(1);
        $this->moveToKeyword(1, 'right');
        sleep(1);
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

        // Test applying italic using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<sup>%1%</sup>');

        // Test applying italic to multiple tags using the top toolbar
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<p><sup>%1% %2%</sup></p><sup>test</sup>');
    }// end testNoBaseTagInputSuperscriptFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testNoBaseTagInputLinks()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test links in top toolbar
        // Test applying links
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        sleep(1);
        $this->clickField('URL', TRUE);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test removing link without title
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('%1% test content');

        // Test removing link with title
        $this->useTest(25);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('%1% test content');

        // Test adding title
        $this->useTest(24);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<a href="test-link" title="test-title">%1%</a> test content');

        // Test removing title
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test modifying title
        $this->useTest(25);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<a href="test-link" title="modified-title">%1%</a> test content');

        // Test links in inline toolbar
        // Test applying links
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test removing link without title
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('%1% test content');

        // Test removing link with title
        $this->useTest(25);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('%1% test content');

        // Test adding title
        $this->useTest(24);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<a href="test-link" title="test-title">%1%</a> test content');

        // Test removing title
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test modifying title
        $this->useTest(25);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<a href="test-link" title="modified-title">%1%</a> test content');

    }// end testNoBaseTagInputLinks()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testNoBaseTagInputLinkBoldFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Using top toolbar 
        // Test applying link to bold formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<strong><a href="test-link">%1%</a></strong> test content');

        // Test removing bold from linked content
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test applying bold to linked content
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<strong><a href="test-link">%1%</a></strong> test content');

        // Test removing link from bold formatted content
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<strong>%1%</strong> test content');

        // Test applying link and title to bold formatted content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<strong><a href="test-link" title="test-title">%1%</a></strong> test content');

        // Test removing bold format from linked content with title
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<a href="test-link" title="test-title">%1%</a> test content');

        // Test appling bold format to linked content with title
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<strong><a href="test-link" title="test-title">%1%</a></strong> test content');

        // Test modifying title of link with bold formatting
        $this->clickTopToolbarButton('link', 'active-selected');
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<strong><a href="test-link" title="modified-title">%1%</a></strong> test content');

        // Test removing title of link from bold formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<strong><a href="test-link">%1%</a></strong> test content');

        // Using inline toolbar 
        // Test applying link to bold formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold', NULL);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<strong><a href="test-link">%1%</a></strong> test content');

        // Test removing bold from linked content
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test applying bold to linked content
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold', NULL);
        sleep(1);
        $this->assertHTMLMatch('<strong><a href="test-link">%1%</a></strong> test content');

        // Test removing link from bold formatted content
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<strong>%1%</strong> test content');

        // Test applying link and title to bold formatted content
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<strong><a href="test-link" title="test-title">%1%</a></strong> test content');

        // Test removing bold format from linked content with title
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<a href="test-link" title="test-title">%1%</a> test content');

        // Test appling bold format to linked content with title
        $this->clickInlineToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<strong><a href="test-link" title="test-title">%1%</a></strong> test content');

        // Test modifying title of link with bold formatting
        $this->clickInlineToolbarButton('link', 'active-selected');
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<strong><a href="test-link" title="modified-title">%1%</a></strong> test content');

        // Test removing title of link from bold formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<strong><a href="test-link">%1%</a></strong> test content');

    }// end testNoBaseTagInputLinkBoldFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testNoBaseTagInputLinkItalicFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Using top toolbar 
        // Test applying link to italic formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<em><a href="test-link">%1%</a></em> test content');

        // Test removing italic from linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test applying italic to linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<em><a href="test-link">%1%</a></em> test content');

        // Test removing link from italic formatted content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<em>%1%</em> test content');

        // Test applying link and title to italic formatted content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<em><a href="test-link" title="test-title">%1%</a></em> test content');

        // Test removing italic format from linked content with title
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<a href="test-link" title="test-title">%1%</a> test content');

        // Test appling italic format to linked content with title
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<em><a href="test-link" title="test-title">%1%</a></em> test content');

        // Test modifying title of link with italic formatting
        $this->clickTopToolbarButton('link', 'active-selected');
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<em><a href="test-link" title="modified-title">%1%</a></em> test content');

        // Test removing title of link from italic formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<em><a href="test-link">%1%</a></em> test content');

        // Using inline toolbar 
        // Test applying link to italic formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickInlineToolbarButton('italic', NULL);
        sleep(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<em><a href="test-link">%1%</a></em> test content');

        // Test removing italic from linked content
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test applying italic to linked content
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<em><a href="test-link">%1%</a></em> test content');

        // Test removing link from italic formatted content
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<em>%1%</em> test content');

        // Test applying link and title to italic formatted content
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<em><a href="test-link" title="test-title">%1%</a></em> test content');

        // Test removing italic format from linked content with title
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<a href="test-link" title="test-title">%1%</a> test content');

        // Test appling italic format to linked content with title
        $this->clickInlineToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<em><a href="test-link" title="test-title">%1%</a></em> test content');

        // Test modifying title of link with italic formatting
        $this->clickInlineToolbarButton('link', 'active-selected');
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<em><a href="test-link" title="modified-title">%1%</a></em> test content');

        // Test removing title of link from italic formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<em><a href="test-link">%1%</a></em> test content');

    }// end testNoBaseTagInputLinkItalicFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testNoBaseTagInputLinkStrikethroughFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Using top toolbar 
        // Test applying link to strikethrough formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<del><a href="test-link">%1%</a></del> test content');

        // Test removing strikethrough from linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test applying strikethrough to linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<del><a href="test-link">%1%</a></del> test content');

        // Test removing link from strikethrough formatted content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<del>%1%</del> test content');

        // Test applying link and title to strikethrough formatted content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        sleep(1);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<del><a href="test-link" title="test-title">%1%</a></del> test content');

        // Test removing strikethrough format from linked content with title
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<a href="test-link" title="test-title">%1%</a> test content');

        // Test appling strikethrough format to linked content with title
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<del><a href="test-link" title="test-title">%1%</a></del> test content');

        // Test modifying title of link with strikethrough formatting
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<del><a href="test-link" title="modified-title">%1%</a></del> test content');

        // Test removing title of link from strikethrough formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<del><a href="test-link">%1%</a></del> test content');

    }// end testNoBaseTagInputLinkStrikethroughFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testNoBaseTagInputLinkSubscriptFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Using top toolbar 
        // Test applying link to subscript formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sub><a href="test-link">%1%</a></sub> test content');

        // Test removing subscript from linked content
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test applying subscript to linked content
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<sub><a href="test-link">%1%</a></sub> test content');

        // Test removing link from subscript formatted content
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<sub>%1%</sub> test content');

        // Test applying link and title to subscript formatted content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sub><a href="test-link" title="test-title">%1%</a></sub> test content');

        // Test removing subscript format from linked content with title
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('<a href="test-link" title="test-title">%1%</a> test content');

        // Test appling subscript format to linked content with title
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<sub><a href="test-link" title="test-title">%1%</a></sub> test content');

        // Test modifying title of link with subscript formatting
        $this->clickTopToolbarButton('link', 'active-selected');
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sub><a href="test-link" title="modified-title">%1%</a></sub> test content');

        // Test removing title of link from subscript formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sub><a href="test-link">%1%</a></sub> test content');

    }// end testNoBaseTagInputLinkSubscriptFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testNoBaseTagInputLinkSuperscriptFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Using top toolbar 
        // Test applying link to superscript formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sup><a href="test-link">%1%</a></sup> test content');

        // Test removing superscript from linked content
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test applying superscript to linked content
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<sup><a href="test-link">%1%</a></sup> test content');

        // Test removing link from superscript formatted content
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<sup>%1%</sup> test content');

        // Test applying link and title to superscript formatted content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sup><a href="test-link" title="test-title">%1%</a></sup> test content');

        // Test removing superscript format from linked content with title
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<a href="test-link" title="test-title">%1%</a> test content');

        // Test appling superscript format to linked content with title
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<sup><a href="test-link" title="test-title">%1%</a></sup> test content');

        // Test modifying title of link with superscript formatting
        $this->clickTopToolbarButton('link', 'active-selected');
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        sleep(1);
        $this->clickField('Title');
        $this->type('modified-title');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sup><a href="test-link" title="modified-title">%1%</a></sup> test content');

        // Test removing title of link from superscript formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sup><a href="test-link">%1%</a></sup> test content');

    }// end testNoBaseTagInputLinkSuperscriptFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when a div base tag is set.
     *
     * @return void
     */
    public function testDivBaseTagInputBoldFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(3);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p><strong>%1%</strong></p><p><strong>test %2%</strong></p><div><strong>test</strong></div>');

        // Test that typing characters in a node with a block parent remain in
        // the block tag.
        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<div><strong>%1% test</strong></div>');

        // Test that removing whole content and typing does wrap text in a block
        // element.
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

        // Test that removing whole content by selecting all and typing characters
        // does wrap text in a block element if there is a block element already.
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

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
        $this->assertHTMLMatch('<div>test</div>');

        // Test applying bold using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<div><strong>%1%</strong></div>');

        // Test applying bold using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<div><strong>%1%</strong></div>');

        // Test applying bold to multiple tags using keyboard shortcuts
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + b');
        sleep(1);
        $this->assertHTMLMatch('<p><strong>%1% %2%</strong></p><div><strong>test</strong></div>');

        // Test applying bold to multiple tags using the top toolbar
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        $this->clickTopToolbarButton('bold');
        $this->assertHTMLMatch('<p><strong>%1% %2%</strong></p><div><strong>test</strong></div>');

    }// end testDivBaseTagInputBoldFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when a div base tag is set.
     *
     * @return void
     */
    public function testDivBaseTagInputItalicFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test that typing characters in a node with a block parent remain in
        // the block tag.
        $this->useTest(7);
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<div><em>%1% test</em></div>');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(8);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p><em>%1%</em></p><p><em>test %2%</em></p><div><em>test</em></div>');

        // Test that removing whole content and typing does wrap text in a block
        // element.
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

        // Test that removing whole content by selecting all and typing characters
        // does wrap text in a block element if there is a block element already.
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

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
        $this->assertHTMLMatch('<div>test</div>');

        // Test applying italic using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('Italic');
        $this->assertHTMLMatch('<div><em>%1%</em></div>');

        // Test applying italic using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<div><em>%1%</em></div>');

        // Test applying italic to multiple tags using keyboard shortcuts
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        $this->getOSAltShortcut('Italic');
        $this->assertHTMLMatch('<p><em>%1% %2%</em></p><div><em>test</em></div>');

        // Test applying italic to multiple tags using the top toolbar
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        $this->clickTopToolbarButton('italic');
        $this->assertHTMLMatch('<p><em>%1% %2%</em></p><div><em>test</em></div>');

    }// end testDivBaseTagInputItalicFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when a div base tag is set.
     *
     * @return void
     */
    public function testDivBaseTagInputStrikethroughFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test that typing characters in a node with a block parent remain in
        // the block tag.
        $this->useTest(11);
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<div><del>%1% test</del></div>');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(12);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p><del>%1%</del></p><p><del>test %2%</del></p><div><del>test</del></div>');


        // Test that removing whole content and typing does wrap text in a block
        // element.
        $this->useTest(11);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

        // Test that removing whole content by selecting all and typing characters
        // does wrap text in a block element if there is a block element already.
        $this->useTest(11);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

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
        $this->assertHTMLMatch('<div>test</div>');

        // Test applying italic
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<div><del>%1%</del></div>');

        // Test applying italic to multiple tags
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p><del>%1% %2%</del></p><div><del>test</del></div>');
    }// end testDivBaseTagInputStrikethroughFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when a div base tag is set.
     *
     * @return void
     */
    public function testDivBaseTagInputSubscriptFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test that typing characters in a node with a block parent remain in
        // the block tag.
        $this->useTest(15);
        sleep(1);
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->type(' test');
        $this->assertHTMLMatch('<div><sub>%1% test</sub></div>');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(16);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p><sub>%1%</sub></p><p><sub>test %2%</sub></p><div><sub>test</sub></div>');

        // Test that removing whole content and typing does wrap text in a block
        // element.
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

        // Test that removing whole content by selecting all and typing characters
        // does wrap text in a block element if there is a block element already.
        $this->useTest(15);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

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
        $this->assertHTMLMatch('<div>test</div>');

        // Test applying italic using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('<div><sub>%1%</sub></div>');

        // Test applying italic to multiple tags using the top toolbar
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        $this->clickTopToolbarButton('subscript');
        $this->assertHTMLMatch('<p><sub>%1% %2%</sub></p><div><sub>test</sub></div>');
    }// end testDivBaseTagInputSubscriptFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when a div base tag is set.
     *
     * @return void
     */
    public function testDivBaseTagInputSuperscriptFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test that typing characters in a node with a block parent remain in
        // the block tag.
        $this->useTest(19);
        $this->moveToKeyword(1, 'right');
        sleep(1);
        $this->type(' test');
        $this->assertHTMLMatch('<div><sup>%1% test</sup></div>');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(20);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p><sup>%1%</sup></p><p><sup>test %2%</sup></p><div><sup>test</sup></div>');

        // Test that removing whole content and typing does wrap text in a block
        // element.
        $this->useTest(19);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

        // Test that removing whole content by selecting all and typing characters
        // does wrap text in a block element if there is a block element already.
        $this->useTest(19);
        $this->selectKeyword(1);
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

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
        $this->assertHTMLMatch('<div>test</div>');

        // Test applying italic using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<div><sup>%1%</sup></div>');

        // Test applying italic to multiple tags using the top toolbar
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->getOSAltShortcut('SelectAll');
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<p><sup>%1% %2%</sup></p><div><sup>test</sup></div>');
    }// end testDivBaseTagInputSuperscriptFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testDivBaseTagInputLinks()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test links in top toolbar
        // Test applying links
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');
        $this->clickTopToolbarButton('link', 'active-selected');

        // Test removing link without title
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<div>%1% test content</div>');

        // Test removing link with title
        $this->useTest(25);
        sleep(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<div>%1%test content</div>');

        // Test adding title
        $this->useTest(24);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a>test content</div>');

        // Test removing title
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a>test content</div>');

        // Test modifying title
        $this->useTest(25);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><a href="test-link" title="modified-title">%1%</a>test content</div>');

        // Test links in inline toolbar
        // Test applying links
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

        // Test removing link without title
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<div>%1% test content</div>');

        // Test removing link with title
        $this->useTest(25);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<div>%1%test content</div>');

        // Test adding title
        $this->useTest(24);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a>test content</div>');

        // Test removing title
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a>test content</div>');

        // Test modifying title
        $this->useTest(25);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><a href="test-link" title="modified-title">%1%</a>test content</div>');

    }// end testDivBaseTagInputLinks()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testDivBaseTagInputLinkBoldFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Using top toolbar 
        // Test applying link to bold formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

        // Test removing bold from linked content
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

        // Test applying bold to linked content
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

        // Test removing link from bold formatted content
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><strong>%1%</strong> test content</div>');

        // Test applying link and title to bold formatted content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><strong><a href="test-link" title="test-title">%1%</a></strong> test content</div>');

        // Test removing bold format from linked content with title
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

        // Test appling bold format to linked content with title
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<div><strong><a href="test-link" title="test-title">%1%</a></strong> test content</div>');

        // Test modifying title of link with bold formatting
        $this->clickTopToolbarButton('link', 'active-selected');
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><strong><a href="test-link" title="modified-title">%1%</a></strong> test content</div>');

        // Test removing title of link from bold formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

        // Using inline toolbar 
        // Test applying link to bold formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold', NULL);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

        // Test removing bold from linked content
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

        // Test applying bold to linked content
        $this->clickInlineToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

        // Test removing link from bold formatted content
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><strong>%1%</strong> test content</div>');

        // Test applying link and title to bold formatted content
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><strong><a href="test-link" title="test-title">%1%</a></strong> test content</div>');

        // Test removing bold format from linked content with title
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

        // Test appling bold format to linked content with title
        $this->clickInlineToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<div><strong><a href="test-link" title="test-title">%1%</a></strong> test content</div>');

        // Test modifying title of link with bold formatting
        $this->clickInlineToolbarButton('link', 'active-selected');
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        sleep(1);
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><strong><a href="test-link" title="modified-title">%1%</a></strong> test content</div>');

        // Test removing title of link from bold formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

    }// end testDivBaseTagInputLinkBoldFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testDivBaseTagInputLinkItalicFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Using top toolbar 
        // Test applying link to italic formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

        // Test removing italic from linked content
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

        // Test applying italic to linked content
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

        // Test removing link from italic formatted content
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><em>%1%</em> test content</div>');

        // Test applying link and title to italic formatted content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><em><a href="test-link" title="test-title">%1%</a></em> test content</div>');

        // Test removing italic format from linked content with title
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

        // Test appling italic format to linked content with title
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<div><em><a href="test-link" title="test-title">%1%</a></em> test content</div>');

        // Test modifying title of link with italic formatting
        $this->clickTopToolbarButton('link', 'active-selected');
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><em><a href="test-link" title="modified-title">%1%</a></em> test content</div>');

        // Test removing title of link from italic formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

        // Using inline toolbar 
        // Test applying link to italic formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic', NULL);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

        // Test removing italic from linked content
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

        // Test applying italic to linked content
        $this->clickInlineToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

        // Test removing link from italic formatted content
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><em>%1%</em> test content</div>');

        // Test applying link and title to italic formatted content
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><em><a href="test-link" title="test-title">%1%</a></em> test content</div>');

        // Test removing italic format from linked content with title
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

        // Test appling italic format to linked content with title
        $this->clickInlineToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<div><em><a href="test-link" title="test-title">%1%</a></em> test content</div>');

        // Test modifying title of link with italic formatting
        $this->clickInlineToolbarButton('link', 'active-selected');
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><em><a href="test-link" title="modified-title">%1%</a></em> test content</div>');

        // Test removing title of link from italic formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

    }// end testDivBaseTagInputLinkItalicFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testDivBaseTagInputLinkStrikethroughFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Using top toolbar 
        // Test applying link to strikethrough formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><del><a href="test-link">%1%</a></del> test content</div>');

        // Test removing strikethrough from linked content
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

        // Test applying strikethrough to linked content
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<div><del><a href="test-link">%1%</a></del> test content</div>');

        // Test removing link from strikethrough formatted content
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><del>%1%</del> test content</div>');

        // Test applying link and title to strikethrough formatted content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><del><a href="test-link" title="test-title">%1%</a></del> test content</div>');

        // Test removing strikethrough format from linked content with title
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

        // Test appling strikethrough format to linked content with title
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<div><del><a href="test-link" title="test-title">%1%</a></del> test content</div>');

        // Test modifying title of link with strikethrough formatting
        $this->clickTopToolbarButton('link', 'active-selected');
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><del><a href="test-link" title="modified-title">%1%</a></del> test content</div>');

        // Test removing title of link from strikethrough formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><del><a href="test-link">%1%</a></del> test content</div>');

    }// end testDivBaseTagInputLinkStrikethroughFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testDivBaseTagInputLinkSubscriptFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Using top toolbar 
        // Test applying link to subscript formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><sub><a href="test-link">%1%</a></sub> test content</div>');

        // Test removing subscript from linked content
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

        // Test applying subscript to linked content
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<div><sub><a href="test-link">%1%</a></sub> test content</div>');

        // Test removing link from subscript formatted content
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><sub>%1%</sub> test content</div>');

        // Test applying link and title to subscript formatted content
        $this->selectKeyword(1);
        sleep(2);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(2);
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><sub><a href="test-link" title="test-title">%1%</a></sub> test content</div>');

        // Test removing subscript format from linked content with title
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

        // Test appling subscript format to linked content with title
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<div><sub><a href="test-link" title="test-title">%1%</a></sub> test content</div>');

        // Test modifying title of link with subscript formatting
        $this->clickTopToolbarButton('link', 'active-selected');
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clickField('Title');
        $this->type('modified-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><sub><a href="test-link" title="modified-title">%1%</a></sub> test content</div>');

        // Test removing title of link from subscript formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><sub><a href="test-link">%1%</a></sub> test content</div>');

    }// end testDivBaseTagInputLinkSubscriptFormat()


    /**
     * Test that inputting text, creating new paragraphs etc work when no base tag is set.
     *
     * @return void
     */
    public function testDivBaseTagInputLinkSuperscriptFormat()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Using top toolbar 
        // Test applying link to superscript formatted content
        $this->useTest(23);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><sup><a href="test-link">%1%</a></sup> test content</div>');

        // Test removing superscript from linked content
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

        // Test applying superscript to linked content
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<div><sup><a href="test-link">%1%</a></sup> test content</div>');

        // Test removing link from superscript formatted content
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><sup>%1%</sup> test content</div>');

        // Test applying link and title to superscript formatted content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><sup><a href="test-link" title="test-title">%1%</a></sup> test content</div>');

        // Test removing superscript format from linked content with title
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<div><a href="test-link" title="test-title">%1%</a> test content</div>');

        // Test appling superscript format to linked content with title
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<div><sup><a href="test-link" title="test-title">%1%</a></sup> test content</div>');

        // Test modifying title of link with superscript formatting
        $this->clickTopToolbarButton('link', 'active-selected');
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        sleep(1);
        $this->clickField('Title');
        $this->type('modified-title');
        sleep(2);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><sup><a href="test-link" title="modified-title">%1%</a></sup> test content</div>');

        // Test removing title of link from superscript formatted content
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><sup><a href="test-link">%1%</a></sup> test content</div>');

    }// end testDivBaseTagInputLinkSuperscriptFormat()

}//end class