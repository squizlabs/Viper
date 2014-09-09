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
     * Test that applying and removing an anchor to a heading.
     *
     * @return void
     */
    public function testApplyAndRemoveAnchorToHeading()
    {
        $this->useTest(3);

        // Apply anchor using the inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1 id="test1">Heading One %1%</h1><p>Test content</p>');

        // Remove anchor using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1>Heading One %1%</h1><p>Test content</p>');

        // Apply anchor using the top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test1');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1 id="test1">Heading One %1%</h1><p>Test content</p>');

        // Remove anchor using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<h1>Heading One %1%</h1><p>Test content</p>');

    }//end testApplyAndRemoveAnchorToHeading()


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
     * Test inserting an image and applying an anchor.
     *
     * @return void
     */
    public function testInsertImageAndApplyAnchor()
    {
        $this->useTest(5);

        // Insert an image
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('image');
        $this->type($this->getTestURL('/ViperImagePlugin/Images/html-codesniffer.png'));
        $this->clickField('Image is decorative');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->moveToKeyword(2, 'right');
        $this->assertHTMLMatch('<p>Content to test insert an image and add an anchor %1%</p><p><img src="%url%/ViperImagePlugin/Images/html-codesniffer.png" alt="" /></p><p>Another paragraph</p><p>Another paragraph</p><p>End of content %2%</p>');

        // Add an anchor to the image
        $this->clickElement('img');
        sleep(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');
        $this->moveToKeyword(2, 'right');
        $this->assertHTMLMatch('<p>Content to test insert an image and add an anchor %1%</p><p><img src="%url%/ViperImagePlugin/Images/html-codesniffer.png" alt="" id="test" /></p><p>Another paragraph</p><p>Another paragraph</p><p>End of content %2%</p>');

        // Check that anchor icon is active for image
        $this->clickElement('img');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon in VITP should be active.');

    }//end testInsertImageAndApplyAnchor()


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


    /**
     * Test that reverting the value in the anchor field.
     *
     * @return void
     */
    public function testRevertAnchorValueIcon()
    {
        $this->useTest(4);

        // Remove anchor value and revert using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        sleep(2);
        $this->clearFieldValue('ID');
        sleep(2);
        $this->revertFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content <span id="test1">%1%</span> more test content %2%</p>');

        // Remove anchor value and revert using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->revertFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content <span id="test1">%1%</span> more test content %2%</p>');

        // Apply anchor value, cleaar field and revert using inline toolbar
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clearFieldValue('ID');
        $this->revertFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content <span id="test1">%1%</span> more test content <span id="test">%2%</span></p>');

        // Apply anchor value and revert using top toolbar
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->revertFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content <span id="test1">%1%</span> more test content <span id="test">%2%</span></p>');

    }//end testRevertAnchorValueIcon()


    /**
     * Test blank value is not added into the source code when you clear the anchor field.
     *
     * @return void
     */
    public function testClearAnchorFieldIcon()
    {
        $this->useTest(1);

        // Using inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content %1% more test content %2%</p>');

        // Using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>test content %1% more test content %2%</p>');

    }//end testClearAnchorFieldIcon()


    /**
     * Test that the anchor icon is disabled when you copy and paste a paragraph
     *
     * @return void
     */
    public function testAnchorIconDisabledWhenCopyParagraph()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'disabled'), 'Class icon should be disabled in the top toolbar.');

    }//end testAnchorIconDisabledWhenCopyParagraph()


    /**
     * Test that the Apply Changes button is inactive for a new selection after you click away from a previous selection.
     *
     * @return void
     */
    public function testApplyChangesButtonWhenClickingAwayFromAnchorPopUp()
    {
        // Using the inline toolbar
        $this->useTest(1);

        // Start creating the anchor for the first selection
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('id');

        // Click away from the anchor by selecting a new selection
        $this->selectKeyword(2);

        // Make sure the anchor was not created
        $this->assertHTMLMatch('<p>test content %1% more test content %2%</p>');
        $this->clickInlineToolbarButton('anchorID');

        // Check apply change button
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>test content %1% more test content <span id="test">%2%</span></p>');

        // Using the top toolbar
        $this->useTest(1);

        // Start creating the anchor for the first selection
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('id');

        // Click away from the anchor by selecting a new selection
        $this->selectKeyword(2);

        // Make sure the anchor was not created
        $this->assertHTMLMatch('<p>test content %1% more test content %2%</p>');
        $this->clickTopToolbarButton('anchorID');

        // Check apply change button
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>test content %1% more test content <span id="test">%2%</span></p>');

    }//end testApplyChangesButtonWhenClickingAwayFromAnchorPopUp()


    /**
     * Test that the Apply Changes button is inactive for a new selection after you close the anchor pop without saving the changes.
     *
     * @return void
     */
    public function testApplyChangesButtonWhenClosingTheAnchorPopUp()
    {
        // Using the inline toolbar
        $this->useTest(1);

        // Start creating the anchor for the first selection
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('id');

        // Close pop up without saving changes and make new select
        $this->clickInlineToolbarButton('anchorID', 'selected');
        $this->selectKeyword(2);

        // Make sure the anchor was not created
        $this->assertHTMLMatch('<p>test content %1% more test content %2%</p>');
        $this->clickInlineToolbarButton('anchorID');

        // Check icons
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->type('test');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>test content %1% more test content <span id="test">%2%</span></p>');

        // Using the top toolbar
        $this->useTest(1);

        // Start creating the anchor for the first selection
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('id');

        // Close pop up without saving changes and make new select
        $this->clickTopToolbarButton('anchorID', 'selected');
        $this->selectKeyword(2);

        // Make sure the anchor was not created
        $this->assertHTMLMatch('<p>test content %1% more test content %2%</p>');
        $this->clickTopToolbarButton('anchorID');

        // Check icons
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE));
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>test content %1% more test content <span id="test">%2%</span></p>');

    }//end testApplyChangesButtonWhenClosingTheAnchorPopUp()


    /**
     * Test that the Apply Changes button is inactive after you cancel changes to a anchor.
     *
     * @return void
     */
    public function testApplyChangesButtonIsDisabledAfterCancellingChangesToALink()
    {
        // Using the inline toolbar
        $this->useTest(4);

        // Select anchor and make changes without saving
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->type('222');
        $this->selectKeyword(2);

        // Check to make sure the HTML did not change.
        $this->assertHTMLMatch('<p>test content <span id="test1">%1%</span> more test content %2%</p>');

        // Select the anchor again and make sure the Apply Changes button is inactive
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE));

        // Edit the anchor and make sure the Apply Changes button still works.
        $this->type('234');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>test content <span id="test1234">%1%</span> more test content %2%</p>');

        // Using the top toolbar
        $this->useTest(4);

        // Select anchor and make changes without saving
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->type('333');
        $this->selectKeyword(2);

        // Check to make sure the HTML did not change.
        $this->assertHTMLMatch('<p>test content <span id="test1">%1%</span> more test content %2%</p>');

        // Select the anchor again and make sure the Apply Changes button is inactive
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE));

        // Edit the anchor and make sure the Apply Changes button still works.
        $this->type('234');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>test content <span id="test1234">%1%</span> more test content %2%</p>');

    }//end testApplyChangesButtonIsDisabledAfterCancellingChangesToALink()

}//end class

?>
