<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_AnchorUnitTest extends AbstractViperUnitTest
{
    /**
     * Test that applying and removing an anchor to a word.
     *
     * @return void
     */
    public function testApplyAndRemoveAnchorToWord()
    {
        $this->useTest(1);

        // Apply anchor using the inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content <span id="test1">%1%</span> more test content %2%</p>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test2');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content <span id="test1">%1%</span> more test content <span id="test2">%2%</span></p>');

        // Remove anchor using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content %1% more test content <span id="test2">%2%</span></p>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content %1% more test content %2%</p>');

         // Apply anchor using the top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content <span id="test1">%1%</span> more test content %2%</p>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test2');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content <span id="test1">%1%</span> more test content <span id="test2">%2%</span></p>');

        // Remove anchor using inline toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content %1% more test content <span id="test2">%2%</span></p>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content %1% more test content %2%</p>');

    }//end testApplyAndRemoveAnchorToWord()


    /**
     * Test that applying and removing an anchor to a paragraph.
     *
     * @return void
     */
    public function testApplyAndRemoveAnchorToParagraph()
    {
        $this->useTest(1);

        // Apply anchor using the inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p id="test1">test content %1% more test content %2%</p>');

        // Remove anchor using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content %1% more test content %2%</p>');

        // Apply anchor using the top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p id="test1">test content %1% more test content %2%</p>');

        // Remove anchor using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content %1% more test content %2%</p>');

    }//end testApplyAndRemoveAnchorToParagraph()


    /**
     * Test applying an anchor to an image.
     *
     * @return void
     */
    public function testApplyingAnAnchorToAnImage()
    {
        $this->useTest(2);

        $this->clickElement('img', 0);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% XuT</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167" id="test" /></p><p>LABS is ORSM</p>');

        $this->sikuli->click($this->findKeyword(1));
        $this->clickElement('img', 0);
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon in VITP should not be active.');

        $this->clickTopToolbarButton('anchorID', 'active');
        $this->type('abc');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1>Viper Image Plugin Unit Tests</h1><p>%1% XuT</p><p><img src="%url%/ViperImagePlugin/Images/hero-shot.jpg" alt="" width="369" height="167" id="testabc" /></p><p>LABS is ORSM</p>');

    }//end testApplyingAnAnchorToAnImage()


    /**
     * Test undo and redo.
     *
     * @return void
     */
    public function testUndoAndRedoForAnchors()
    {
        // Test when applying an anchor to a word
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content <span id="test">%1%</span> more test content %2%</p>');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>test content %1% more test content %2%</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>test content <span id="test">%1%</span> more test content %2%</p>');

        // Test when applying an anchor to a paragraph
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p id="test">test content %1% more test content %2%</p>');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>test content %1% more test content %2%</p>');
        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p id="test">test content %1% more test content %2%</p>');
       
    }//end testUndoAndRedoForAnchors()


    /**
     * Test the state of the anchor icon in different parts of the content on a page.
     *
     * @return void
     */
    public function testStateOfAnchorIconInContent()
    {
        $this->useTest(1);

        $this->moveToKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should be disabled');

        $this->selectKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be available');
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be available');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should be available');
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be available');

        //Make sure the anchor icon is disabled when you copy and paste a paragraph.
        $this->sikuli->keyDown('Key.CMD + c');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should be disabled');

        //Select all the content on a page and check anchor icon is disabled
        $this->sikuli->keyDown('Key.CMD + c');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Anchor icon should be disabled');

    }//end testStateOfAnchorIconInContent()


}//end class

?>
