<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BaseTag_BlankBlockTagWithLinksUnitTest extends AbstractViperUnitTest
{

    /**
     * Test adding and removing links when base tag is blank.
     *
     * @return void
     */
    public function testAddingAndRemovingLinks()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying links without title using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        sleep(1);
        $this->clickField('URL', TRUE);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('%1% test content');

        // Test applying links with title using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        sleep(1);
        $this->clickField('URL', TRUE);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<a href="test-link" title="Squiz Labs">%1%</a> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('%1% test content');

        // Test applying links and open in a new window using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        sleep(1);
        $this->clickField('URL', TRUE);
        $this->type('test-link');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<a href="test-link" target="_blank">%1%</a> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('%1% test content');

        // Test applying links without title using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        sleep(1);
        $this->clickField('URL', TRUE);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('%1% test content');

        // Test applying links with title using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        sleep(1);
        $this->clickField('URL', TRUE);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<a href="test-link" title="Squiz Labs">%1%</a> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('%1% test content');

        // Test applying links and open in a new window using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        sleep(1);
        $this->clickField('URL', TRUE);
        $this->type('test-link');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<a href="test-link" target="_blank">%1%</a> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('%1% test content');

    }// end testAddingAndRemovingLinks()


    /**
     * Test editing links when base tag is set to blank.
     *
     * @return void
     */
    public function testEditingLinks()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test adding title using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('test <a href="test-link" title="test-title">%1%</a> content');

        // Test removing title
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('test <a href="test-link">%1%</a> content');

        // Test editing is open in a new window using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('test <a href="test-link" target="_blank">%1%</a> content');

        // Test changing it back
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('test <a href="test-link">%1%</a> content');

        // Test adding title using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('test <a href="test-link" title="test-title">%1%</a> content');

        // Test removing title
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('test <a href="test-link">%1%</a> content');

        // Test editing is open in a new window using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('test <a href="test-link" target="_blank">%1%</a> content');

        // Test changing it back
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('test <a href="test-link">%1%</a> content');

    }// end testEditingLinks()


    /**
     * Test how having no base tag effects bold and link formatting.
     *
     * @return void
     */
    public function testLinksWithBoldFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying link to bold content using inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<strong><a href="test-link">%1%</a></strong> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<strong>%1%</strong> test content');

        // Test applying bold to linked content using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<strong><a href="test-link">%1%</a></strong> test content');

        // Test removing bold from linked content
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test applying link to bold content using top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<strong><a href="test-link">%1%</a></strong> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<strong>%1%</strong> test content');

        // Test applying bold to linked content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<strong><a href="test-link">%1%</a></strong> test content');

        // Test removing bold from linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

    }// end testLinksWithBoldFormatting()


    /**
     * Test how having no base tag effects italic and link formatting.
     *
     * @return void
     */
    public function testLinksWithItalicFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying link to italic content using inline toolbar
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<em><a href="test-link">%1%</a></em> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<em>%1%</em> test content');

        // Test applying italics to linked content using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<em><a href="test-link">%1%</a></em> test content');

        // Test removing italic from linked content
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

        // Test applying link to italic content using top toolbar
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<em><a href="test-link">%1%</a></em> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<em>%1%</em> test content');

        // Test applying italic to linked content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<em><a href="test-link">%1%</a></em> test content');

        // Test removing italic from linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

    }// end testLinksWithItalicFormatting()


    /**
     * Test how having no base tag effects strikethrough and link formatting.
     *
     * @return void
     */
    public function testLinksWithStrikethroughFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying link to strikethrough content using inline toolbar
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<del><a href="test-link">%1%</a></del> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<del>%1%</del> test content');

        // Test applying link to strikethrought content using top toolbar
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<del><a href="test-link">%1%</a></del> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<del>%1%</del> test content');

        // Test applying strikethrough to linked content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<del><a href="test-link">%1%</a></del> test content');

        // Test removing strikethrough from linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

    }// end testLinksWithStrikethroughFormatting()


    /**
     * Test how having no base tag effects subscript and link formatting.
     *
     * @return void
     */
    public function testLinksWithSubscriptFormatting()
    {

        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying link to subscript content using inline toolbar
        $this->useTest(8);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sub><a href="test-link">%1%</a></sub> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<sub>%1%</sub> test content');

        // Test applying link to subscript content using top toolbar
        $this->useTest(8);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sub><a href="test-link">%1%</a></sub> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<sub>%1%</sub> test content');

        // Test applying subscript to linked content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<sub><a href="test-link">%1%</a></sub> test content');

        // Test removing strikethrough from linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

    }// end testLinksWithSubscriptFormatting()


    /**
     * Test how having no base tag effects superscript and link formatting.
     *
     * @return void
     */
    public function testLinksWithSuperscriptFormatting()
    {

        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying link to superscript content using inline toolbar
        $this->useTest(9);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sup><a href="test-link">%1%</a></sup> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<sup>%1%</sup> test content');

        // Test applying link to superscript content using top toolbar
        $this->useTest(9);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<sup><a href="test-link">%1%</a></sup> test content');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<sup>%1%</sup> test content');

        // Test applying superscript to linked content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<sup><a href="test-link">%1%</a></sup> test content');

        // Test removing superscript from linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<a href="test-link">%1%</a> test content');

    }// end testLinksWithSuperscriptFormatting()


}//end class
