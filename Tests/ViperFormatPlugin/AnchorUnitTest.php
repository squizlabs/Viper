<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_AnchorUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that creating anchor works.
     *
     * @return void
     */
    public function testCreateAnchorUsingTheInlineToolbar()
    {
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span id="test">%1%</span> %2% %3%</p><p id="test">sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">%5%</span> is %6%</p>');

        $this->sikuli->click($this->findKeyword(3));
        sleep(1);
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon in the inline toolbar should be active');

        $this->selectKeyword(6);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p><span id="test">%1%</span> %2% %3%</p><p id="test">sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">%5%</span> is <span id="test">%6%</span></p>');

        $this->sikuli->click($this->findKeyword(3));
        sleep(1);
        $this->selectKeyword(6);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon in the inline toolbar should be active');

    }//end testCreateAnchorUsingTheInlineToolbar()


    /**
     * Test that creating anchor works.
     *
     * @return void
     */
    public function testCreateAnchorUsingTheTopToolbar()
    {
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span id="test">%1%</span> %2% %3%</p><p id="test">sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">%5%</span> is %6%</p>');

        $this->sikuli->click($this->findKeyword(3));
        sleep(1);
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon in the inline toolbar should be active');

        $this->selectKeyword(6);
        $this->clickTopToolbarButton('anchorID');
        $this->type('test');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p><span id="test">%1%</span> %2% %3%</p><p id="test">sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">%5%</span> is <span id="test">%6%</span></p>');

        $this->sikuli->click($this->findKeyword(3));
        sleep(1);
        $this->selectKeyword(6);
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon in the inline toolbar should be active');

    }//end testCreateAnchorUsingTheTopToolbar()


    /**
     * Test that the anchor icon appears in the inline toolbar for the last word in a paragraph.
     *
     * @return void
     */
    public function testAnchorIconAppearsInTheInlineToolbar()
    {
        $this->moveToKeyword(6, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('This is a new line of CONTENT');

        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');

        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should appear in the inline toolbar.');

    }//end testAnchorIconAppearsInTheInlineToolbar()


    /**
     * Test selecting anchors.
     *
     * @return void
     */
    public function testSelectingAnchors()
    {
        $this->selectKeyword(4);
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID'), 'Anchor icon should appear in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID'), 'Anchor icon should be available in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Active anchor icon should appear in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Active anchor icon should be available in the top toolbar');

        $this->sikuli->click($this->findKeyword(2));

        $this->selectKeyword(5);
        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Active anchor icon should appear in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Active anchor icon should be available in the top toolbar');

    }//end testSelectingAnchors()


    /**
     * Test deleting anchors using the inline toolbar.
     *
     * @return void
     */
    public function testDeletingAnchorsUsingTheInlineToolbar()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">%5%</span> is %6%</p>');

        $this->selectKeyword(5);
        sleep(1);
        $this->clickInlineToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz %5% is %6%</p>');

    }//end testDeletingAnchorsUsingTheInlineToolbar()


    /**
     * Test deleting anchors using the top toolbar.
     *
     * @return void
     */
    public function testDeletingAnchorsUsingTheTopToolbar()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">%5%</span> is %6%</p>');

        $this->selectKeyword(5);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz %5% is %6%</p>');

    }//end testDeletingAnchorsUsingTheInlineToolbar()


    /**
     * Test applying an anchor to an image.
     *
     * @return void
     */
    public function testApplyingAnAnchorToAnImage()
    {
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
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('anchorID');
        $this->type('test');
        $this->sikuli->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span id="test">%1%</span> %2% %3%</p><p id="test">sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">%5%</span> is %6%</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p id="test">sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">%5%</span> is %6%</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p><span id="test">%1%</span> %2% %3%</p><p id="test">sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">%5%</span> is %6%</p>');

        $this->sikuli->click($this->findKeyword(3));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('anchorID', 'active');
        $this->clearFieldValue('ID');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><span id="test">%1%</span> %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">%5%</span> is %6%</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p><span id="test">%1%</span> %2% %3%</p><p id="test">sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">%5%</span> is %6%</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p><span id="test">%1%</span> %2% %3%</p><p>sit amet <strong>%4%</strong></p><p>Test AbC</p><p>Squiz <span id="myclass">%5%</span> is %6%</p>');

    }//end testUndoAndRedoForAnchors()


}//end class

?>
