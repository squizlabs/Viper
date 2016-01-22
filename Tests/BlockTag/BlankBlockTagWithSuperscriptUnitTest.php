<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BaseTag_BlankBlockTagWithSuperscriptUnitTest extends AbstractViperUnitTest
{
    /**
     * Test adding superscript formatting to content
     *
     * @return void
     */
    public function testAddingSuperscriptFormattingToContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test applying superscript formatting to one word using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('This is <sup>%1%</sup> %2% some content');

        // Test applying superscript formatting to multiple words using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('This is <sup>%1% %2%</sup> some content');

    }//end testAddingSuperscriptFormattingToContent()


    /**
     * Test removing superscript formatting from content
     *
     * @return void
     */
    public function testRemovingSuperscriptFormatting()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test removing superscript formatting from one word using the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('This is %1% some content');

        // Test removing superscript formatting from multiple words using the top toolbar
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('Some superscript %1% %2% content to test');

        // Test removing superscript formatting from all content using top toolbar
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('Superscript %1% content');

    }//end testRemovingSuperscriptFormatting()


    /**
     * Test editing superscript content
     *
     * @return void
     */
    public function testEditingSuperscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test adding content to the start of the superscript formatting
        $this->useTest(4);
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('test');
        $this->assertHTMLMatch('Some superscript test<sup>%1% %2%</sup> content to test');

        // Test adding content in the middle of superscript formatting
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('Some superscript test<sup>%1% test %2%</sup> content to test');

        // Test adding content to the end of superscript formatting
        $this->clickKeyword(2);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type(' test');
        $this->assertHTMLMatch('Some superscript test<sup>%1% test %2% test</sup> content to test');

        // Test highlighting some content in the sup[] tags and replacing it
        $this->selectKeyword(2);
        $this->type('abc');
        $this->assertHTMLMatch('Some superscript test<sup>%1% test abc test</sup> content to test');

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('abc');
        $this->assertHTMLMatch('Some superscript test<sup>abc test abc test</sup> content to test');

    }//end testEditingSuperscriptContent()


    /**
     * Test deleting superscript content
     *
     * @return void
     */
    public function testDeletingSuperscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test replacing superscript content with new content with highlighting
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->type('test');
        $this->assertHTMLMatch('Some superscript <sup>test</sup> content to test');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some superscript test content to test');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some superscript test content to test');

        // Test replacing superscript content with new content when selecting one keyword and using the lineage
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('Some superscript <sup>test</sup> content to test');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('Some superscript test content to test');

        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test');
        $this->assertHTMLMatch('Some superscript test content to test');

        // Test replacing all content
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->type('test');
        $this->assertHTMLMatch('test');

    }//end testDeletingSuperscriptContent()


    /**
     * Test splitting a superscript section in content
     *
     * @return void
     */
    public function testSplittingSuperscriptContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test pressing enter in the middle of superscript content
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('Some superscript <sup>%1%<br />test %2%</sup> content to test');

        // Test pressing enter at the start of superscript content
        $this->useTest(4);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('Some superscript <br />test <sup>%1% %2%</sup> content to test');

        // Test pressing enter at the end of superscript content
        $this->useTest(4);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test ');
        $this->assertHTMLMatch('Some superscript <sup>%1% %2%</sup><br />test content to test');

    }//end testSplittingSuperscriptContent()


}//end class