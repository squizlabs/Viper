<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_BlockTag_BlankBlockTagUnitTest extends AbstractViperUnitTest
{


    /**
     * Test adding content
     *
     * @return void
     */
    public function testBlankBlockTagAddingContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test adding content to the start of a section
        $this->useTest(2);
        $this->moveToKeyword(1, 'left');
        $this->type('test ');
        $this->assertHTMLMatch('test %1% Test content %2%');
        // Test adding content to the middle of a section
        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('%1% test Test content %2%');
        $this->moveToKeyword(2, 'left');
        $this->type('test again ');
        $this->assertHTMLMatch('%1% test Test content test again %2%');

        // Test adding content to the end of a section
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('%1% Test content %2% test');

        // Test adding a new section of content
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.ENTER');
        $this->type('test more content');
        $this->assertHTMLMatch('%1% Test content %2%<br />test more content');

    }//end testBlankBlockTagAddingContent()


    /**
     * Test splitting and joining content
     *
     * @return void
     */
    public function testBlankBlockTagSplittingAndJoingContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Add a new section of content
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.ENTER');
        $this->type('%3% test more content');
        $this->assertHTMLMatch('%1% Test content %2%<br />%3% test more content');

        // Join the sections back up with forward delete
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('%1% Test content %2%%3% test more content');

        // Split content again
        $this->sikuli->keyDown('Key.SHIFT + Key.ENTER');
        $this->assertHTMLMatch('%1% Test content %2%<br />%3% test more content');

        // Join the sections back up with backspace
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('%1% Test content %2%%3% test more content');

    }//end testBlankBlockTagSplittingAndJoingContent()


    /**
     * Test that typing multiple spaces changes the space to a &nbsp.
     *
     * @return void
     */
    public function testBlankBlockTagMultipleSpacesInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
        $this->type('   multiple    spaces between words    ');
        $this->assertHTMLMatch('%1%&nbsp;&nbsp; multiple&nbsp;&nbsp;&nbsp;&nbsp;spaces between words&nbsp;&nbsp;&nbsp;&nbsp; Test content %2%');

        // Check that if you add multiple spaces onto the end of the content of the page, they are not saved.
        $this->moveToKeyword(2, 'right');
        $this->type('   ');
        $this->assertHTMLMatch('%1%&nbsp;&nbsp; multiple&nbsp;&nbsp;&nbsp;&nbsp;spaces between words&nbsp;&nbsp;&nbsp;&nbsp; Test content %2%');

    }//end testBlankBlockTagMultipleSpacesInContent()


     /**
     * Test that typing replaces the selected text.
     *
     * @return void
     */
    public function testBlankBlockTagHighlightAndReplaceContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test replacing part of the content
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->type('test content');
        $this->assertHTMLMatch('test content Test content %2%');

        // Test replacing all of the content
        $this->useTest(2);
        $this->clickKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->type('test content');
        $this->assertHTMLMatch('test content');

    }//end testBlankBlockTagHighlightAndReplaceContent()


    /**
     * Test the status of the icons in the top toolbar
     *
     * @return void
     */
    public function testBlankBlockTagToolbarIconStatus()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

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
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'));
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'));
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
        $this->assertTrue($this->topToolbarButtonExists('formats', NULL));
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
        
    }//end testBlankBlockTagToolbarIconStatus()


    /**
     * Test deleting part of the content
     *
     * @return void
     */
    public function testBlankBlockTagDeletingPartOfContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test delete part of content with forward delete
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch(' Test content %2%');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('%1% Test content %2%');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch(' Test content %2%');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('%1% Test content %2%');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch(' Test content %2%'); 

        // Test delete part of content with backspace
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('%1% Test content');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('%1% Test content %2%');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('%1% Test content');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('%1% Test content %2%');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('%1% Test content'); 

    }//end testBlankBlockTagDeletingPartOfContent()


    /**
     * Test deleting part of the content
     *
     * @return void
     */
    public function testBlankBlockTagDeletingAllContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test delete all content with forward delete
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->type('test delete');
        $this->assertHTMLMatch('test delete');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('%1% Test content %2%');
        $this->clickTopToolbarButton('historyRedo');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('test delete');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('%1% Test content %2%');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('test delete');

        // Test delete all content with backspace
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('test delete');
        $this->assertHTMLMatch('test delete');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('%1% Test content %2%');
        $this->clickTopToolbarButton('historyRedo');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('test delete');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('%1% Test content %2%');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('test delete'); 

    }//end testBlankBlockTagDeletingAllContent()


    /**
     * Test using content with p tags when block tag is empty.
     *
     * @return void
     */
    public function testBlankBlockTagWithParagraphs()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Test that enter key inside a paragraph still splits the container.
        $this->useTest(3);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p>%1%</p><p>test Test content %2%</p>');

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('test');
        $this->assertHTMLMatch('<p>%1%</p><p>test Test content %2%</p>test');

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
        $this->assertHTMLMatch('test');

    }//end testBlankBlockTagWithParagraphs()


    /**
     * Test undo and redo when editing content
     *
     * @return void
     */
    public function testUndoAndRedoInContent()
    {
        $this->useTest(1);
        $this->sikuli->execJS('viper.setSetting("defaultBlockTag", "")');

        // Add content to the page
        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
        $this->type(' test');
        $this->assertHTMLMatch('%1% test Test content %2%');

        // Test undo and redo with top toolbar icons
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('%1% Test content %2%');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('%1% test Test content %2%');

        // Test undo and redo with keyboard shortcuts
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('%1% Test content %2%');
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('%1% test Test content %2%');

        // Test making multiple changes and pressing undo
        $this->selectKeyword(1);
        $this->type('abc');
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.DELETE');
        $this->assertHTMLMatch('abc test Test content');

        // Test undo and redo with top toolbar icons
        // Press once will undo the delete
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('abc test Test content %2%');
        // Press again will undo the replace
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('%1% test Test content %2%');

        // Press redo once will redo the replace
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('abc test Test content %2%');
        // Press redo once will redo the delete
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('test test Test content');

        // Test undo and redo with keyboard shortcuts
        // Press once will undo the delete
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('abc test Test content %2%');
        // Press again will undo the replace
        $this->sikuli->keyDown('Key.CMD + z');
        $this->assertHTMLMatch('%1% test Test content %2%');

        // Press redo once will redo the replace
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('abc test Test content %2%');
        // Press redo once will redo the delete
        $this->sikuli->keyDown('Key.CMD + Key.SHIFT + z');
        $this->assertHTMLMatch('test test Test content');

    }//end testUndoAndRedoInContent()

}//end class
