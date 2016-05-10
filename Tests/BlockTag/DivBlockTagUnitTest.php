<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_DivBlockTagUnitTest extends AbstractViperUnitTest
{


    /**
     * Test adding content
     *
     * @return void
     */
    public function testDivBlockTagAddingContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test adding content to the start of a section
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');
        $this->type('test ');
        $this->assertHTMLMatch('<div>test %1% Test content %2%</div>');

        // Test adding content to the middle of a section
        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<div>%1% test Test content %2%</div>');
        $this->moveToKeyword(2, 'left');
        $this->type('test again ');
        $this->assertHTMLMatch('<div>%1% test Test content test again %2%</div>');

        // Test adding content to the end of a section
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('<div>%1% Test content %2% test</div>');

        // Test adding a new section of content
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test more content');
        $this->assertHTMLMatch('<div>%1% Test content %2%</div><div>test more content</div>');

    }//end testDivBlockTagAddingContent()


    /**
     * Test splitting and joining content
     *
     * @return void
     */
    public function testDivBlockTagSplittingAndJoingContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Add a new section of content
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('%3% test more content');
        sleep(2);
        $this->assertHTMLMatch('<div>%1% Test content %2%</div><div>%3% test more content</div>');

        // Join the sections back up with forward delete
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(2);
        $this->assertHTMLMatch('<div>%1% Test content %2%%3% test more content</div>');

        // Split content again
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(2);
        $this->assertHTMLMatch('<div>%1% Test content %2%</div><div>%3% test more content</div>');

        // Join the sections back up with backspace
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(2);
        $this->assertHTMLMatch('<div>%1% Test content %2%%3% test more content</div>');

    }//end testDivBlockTagSplittingAndJoingContent()


    /**
     * Test that typing multiple spaces changes the space to a &nbsp.
     *
     * @return void
     */
    public function testDivBlockTagMultipleSpacesInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
        $this->type('   multiple    spaces between words    ');
        $this->assertHTMLMatch('<div>%1%&nbsp;&nbsp; multiple&nbsp;&nbsp;&nbsp;&nbsp;spaces between words&nbsp;&nbsp;&nbsp;&nbsp; Test content %2%</div>');

        // Check that if you add multiple spaces onto the end of the content of the page, they are not saved.
        $this->moveToKeyword(2, 'right');
        $this->type('   ');
        $this->assertHTMLMatch('<div>%1%&nbsp;&nbsp; multiple&nbsp;&nbsp;&nbsp;&nbsp;spaces between words&nbsp;&nbsp;&nbsp;&nbsp; Test content %2%</div>');

    }//end testDivBlockTagMultipleSpacesInContent()


     /**
     * Test that typing replaces the selected text.
     *
     * @return void
     */
    public function testDivBlockTagHighlightAndReplaceContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test replacing part of the content
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->type('test content');
        $this->assertHTMLMatch('<div>test content Test content %2%</div>');

        // Test replacing all of the content
        $this->useTest(2);
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->type('test content');
        $this->assertHTMLMatch('<div>test content</div>');

    }//end testDivBlockTagHighlightAndReplaceContent()


    /**
     * Test the status of the icons in the top toolbar
     *
     * @return void
     */
    public function testDivBlockTagToolbarIconStatus()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Check icons when clicking within the content
        $this->useTest(2);
        $this->clickKeyword(1, 'right');
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('linkRemove', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL));
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL));
        $this->assertTrue($this->topToolbarButtonExists('removeFormat', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL));
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', NULL));
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('listIndent', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('listOutdent', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'));
        $this->assertTrue($this->topToolbarButtonExists('headings', NULL));
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('table', NULL));
        $this->assertTrue($this->topToolbarButtonExists('image', NULL));
        $this->assertTrue($this->topToolbarButtonExists('accessAudit', NULL));
        $this->assertTrue($this->topToolbarButtonExists('sourceView', NULL));
        $this->assertTrue($this->topToolbarButtonExists('searchReplace', NULL));
        $this->assertTrue($this->topToolbarButtonExists('langtools', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('charmap', NULL));

        // Check icons when selecting content
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('link', NULL));
        $this->assertTrue($this->topToolbarButtonExists('linkRemove', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('bold', NULL));
        $this->assertTrue($this->topToolbarButtonExists('italic', NULL));
        $this->assertTrue($this->topToolbarButtonExists('removeFormat', NULL));
        $this->assertTrue($this->topToolbarButtonExists('subscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('superscript', NULL));
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', NULL));
        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', NULL));
        $this->assertTrue($this->topToolbarButtonExists('historyUndo', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('historyRedo', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('listIndent', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('listOutdent', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('formats-div', NULL));
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('anchorID', NULL));
        $this->assertTrue($this->topToolbarButtonExists('cssClass', NULL));
        $this->assertTrue($this->topToolbarButtonExists('table', NULL));
        $this->assertTrue($this->topToolbarButtonExists('image', NULL));
        $this->assertTrue($this->topToolbarButtonExists('accessAudit', NULL));
        $this->assertTrue($this->topToolbarButtonExists('sourceView', NULL));
        $this->assertTrue($this->topToolbarButtonExists('searchReplace', NULL));
        $this->assertTrue($this->topToolbarButtonExists('langtools', NULL));
        $this->assertTrue($this->topToolbarButtonExists('charmap', NULL));
        
    }//end testDivBlockTagToolbarIconStatus()


    /**
     * Test deleting part of the content
     *
     * @return void
     */
    public function testDivBlockTagDeletingPartOfContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test delete part of content with forward delete
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('<div>Test content %2%</div>');

        // Test undo and redo with top toolbar icons
        $this->clickKeyword(2);
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>%1% Test content %2%</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>Test content %2%</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>%1% Test content %2%</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>Test content %2%</div>'); 

        // Test delete part of content with backspace
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<div>%1% Test content</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>%1% Test content %2%</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>%1% Test content</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('<div>%1% Test content %2%</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>%1% Test content</div>'); 

    }//end testDivBlockTagDeletingPartOfContent()


    /**
     * Test deleting part of the content
     *
     * @return void
     */
    public function testDivBlockTagDeletingAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test delete all content with forward delete
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test delete');
        $this->assertHTMLMatch('<div>test delete</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>%1% Test content %2%</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>test delete</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->sikuli->keyDown('Key.CMD + z');
//        $this->assertHTMLMatch('<div>%1% Test content %2%</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>test delete</div>');

        // Test delete all content with backspace
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test delete');
        $this->assertHTMLMatch('<div>test delete</div>');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->clickTopToolbarButton('historyUndo');
//        $this->assertHTMLMatch('<div>%1% Test content %2%</div>');
        $this->clickTopToolbarButton('historyRedo');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>test delete</div>');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->sikuli->keyDown('Key.CMD + z');
//        $this->assertHTMLMatch('<div>%1% Test content %2%</div>');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('<div>test delete</div>'); 

    }//end testDivBlockTagDeletingAllContent()


    /**
     * Test using content with p tags when block tag is empty.
     *
     * @return void
     */
    public function testDivBlockTagWithParagraphs()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "DIV")');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(3);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p>%1%</p><p>test Test content %2%</p>');

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p>%1%</p><p>test Test content %2%</p><div>test</div>');

        // Test removing all content and typing characters uses available block tag.
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->type('test');
        $this->assertHTMLMatch('<p>test</p>');

        $this->useTest(3);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test');
        $this->assertHTMLMatch('<div>test</div>');

    }//end testDivBlockTagWithParagraphs()

}//end class
