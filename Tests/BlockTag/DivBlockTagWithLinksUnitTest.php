<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagWithLinksUnitTest extends AbstractViperUnitTest
{

    /**
     * Test adding and removing links when base tag is blank.
     *
     * @return void
     */
    public function testDivBlockTagAddingAndRemovingLinks()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying links without title using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        sleep(1);
        $this->clickField('URL', TRUE);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<div>%1% test content</div>');

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
        $this->assertHTMLMatch('<div><a href="test-link" title="Squiz Labs">%1%</a> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<div>%1% test content</div>');

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
        $this->assertHTMLMatch('<div><a href="test-link" target="_blank">%1%</a> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<div>%1% test content</div>');

        // Test applying links without title using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        sleep(1);
        $this->clickField('URL', TRUE);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<div>%1% test content</div>');

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
        $this->assertHTMLMatch('<div><a href="test-link" title="Squiz Labs">%1%</a> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<div>%1% test content</div>');

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
        $this->assertHTMLMatch('<div><a href="test-link" target="_blank">%1%</a> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<div>%1% test content</div>');

    }// end testDivBlockTagAddingAndRemovingLinks()


    /**
     * Test editing links when base tag is set to blank.
     *
     * @return void
     */
    public function testDivBlockTagEditingLinks()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test adding title using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
//        $this->assertHTMLMatch('<div>test <a href="test-link" title="test-title">%1%</a> content</div>');

        // Test removing title
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
//        $this->assertHTMLMatch('<div>test <a href="test-link">%1%</a> content</div>');

        // Test editing is open in a new window using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
//        $this->assertHTMLMatch('<div>test <a href="test-link" target="_blank">%1%</a> content</div>');

        // Test changing it back
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
//        $this->assertHTMLMatch('<div>test <a href="test-link">%1%</a> content</div>');

        // Test adding title using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('test-title');
        $this->sikuli->keyDown('Key.ENTER');
//        $this->assertHTMLMatch('<div>test <a href="test-link" title="test-title">%1%</a> content</div>');

        // Test removing title
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->sikuli->keyDown('Key.ENTER');
//        $this->assertHTMLMatch('<div>test <a href="test-link">%1%</a> content</div>');

        // Test editing is open in a new window using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
//        $this->assertHTMLMatch('<div>test <a href="test-link" target="_blank">%1%</a> content</div>');

        // Test changing it back
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
//        $this->assertHTMLMatch('<div>test <a href="test-link">%1%</a> content</div>');

    }// end testDivBlockTagEditingLinks()


    /**
     * Test how having no base tag effects bold and link formatting.
     *
     * @return void
     */
    public function testDivBlockTagLinksWithBoldFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying link to bold content using inline toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><strong>%1%</strong> test content</div>');

        // Test applying bold to linked content using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

        // Test removing bold from linked content
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

        // Test applying link to bold content using top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><strong>%1%</strong> test content</div>');

        // Test applying bold to linked content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', NULL);
        $this->assertHTMLMatch('<div><strong><a href="test-link">%1%</a></strong> test content</div>');

        // Test removing bold from linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

    }// end testDivBlockTagLinksWithBoldFormatting()


    /**
     * Test how having no base tag effects italic and link formatting.
     *
     * @return void
     */
    public function testDivBlockTagLinksWithItalicFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying link to italic content using inline toolbar
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><em>%1%</em> test content</div>');

        // Test applying italics to linked content using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

        // Test removing italic from linked content
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

        // Test applying link to italic content using top toolbar
        $this->useTest(6);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><em>%1%</em> test content</div>');

        // Test applying italic to linked content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<div><em><a href="test-link">%1%</a></em> test content</div>');

        // Test removing italic from linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

    }// end testDivBlockTagLinksWithItalicFormatting()


    /**
     * Test how having no base tag effects strikethrough and link formatting.
     *
     * @return void
     */
    public function testDivBlockTagLinksWithStrikethroughFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying link to strikethrough content using inline toolbar
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><del><a href="test-link">%1%</a></del> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><del>%1%</del> test content</div>');

        // Test applying link to strikethrought content using top toolbar
        $this->useTest(7);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><del><a href="test-link">%1%</a></del> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><del>%1%</del> test content</div>');

        // Test applying strikethrough to linked content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', NULL);
        $this->assertHTMLMatch('<div><del><a href="test-link">%1%</a></del> test content</div>');

        // Test removing strikethrough from linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

    }// end testDivBlockTagLinksWithStrikethroughFormatting()


    /**
     * Test how having no base tag effects subscript and link formatting.
     *
     * @return void
     */
    public function testDivBlockTagLinksWithSubscriptFormatting()
    {

        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying link to subscript content using inline toolbar
        $this->useTest(8);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><sub><a href="test-link">%1%</a></sub> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><sub>%1%</sub> test content</div>');

        // Test applying link to subscript content using top toolbar
        $this->useTest(8);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><sub><a href="test-link">%1%</a></sub> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><sub>%1%</sub> test content</div>');

        // Test applying subscript to linked content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', NULL);
        $this->assertHTMLMatch('<div><sub><a href="test-link">%1%</a></sub> test content</div>');

        // Test removing strikethrough from linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('subscript', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

    }// end testDivBlockTagLinksWithSubscriptFormatting()


    /**
     * Test how having no base tag effects superscript and link formatting.
     *
     * @return void
     */
    public function testDivBlockTagLinksWithSuperscriptFormatting()
    {

        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test applying link to superscript content using inline toolbar
        $this->useTest(9);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><sup><a href="test-link">%1%</a></sup> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><sup>%1%</sup> test content</div>');

        // Test applying link to superscript content using top toolbar
        $this->useTest(9);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><sup><a href="test-link">%1%</a></sup> test content</div>');

        // Test removing link
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove', NULL);
        $this->assertHTMLMatch('<div><sup>%1%</sup> test content</div>');

        // Test applying superscript to linked content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', NULL);
        $this->assertHTMLMatch('<div><sup><a href="test-link">%1%</a></sup> test content</div>');

        // Test removing superscript from linked content
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

    }// end testDivBlockTagLinksWithSuperscriptFormatting()

    /**
     * Test undo and redo with link.
     *
     * @return void
     */
    public function testDivBlockTagUndoAndRedoWithLinks()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Apply link
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        sleep(1);
        $this->clickField('URL', TRUE);
        $this->type('test-link');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>%1% test content</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');  

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>%1% test content</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div><a href="test-link">%1%</a> test content</div>');

    }// end testDivBlockTagUndoAndRedoWithLinks()

}//end class
