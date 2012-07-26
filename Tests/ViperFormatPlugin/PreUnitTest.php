<?php

require_once 'AbstractFormatsUnitTest.php';

class Viper_Tests_ViperFormatPlugin_PreUnitTest extends AbstractFormatsUnitTest
{


    /**
     * Test applying the pre tag to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testApplingThePreStyleUsingInlineToolbar()
    {

        // Test selecting a word in a P to change to a pre
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Toogle formats icon should not appear in the inline toolbar');

        // Select all content in the P and change to a pre
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Toogle formats should appear in the inline toolbar');
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><pre>%4% paragraph to change to a pre</pre>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');

        // Check the state of the format icon after we have changed to a paragraph
        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'formats icon should not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Active formats icon should not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Active toogle formats icon should be active in the inline toolbar');
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');

    }//end testApplingThePreStyleUsingInlineToolbar()


    /**
     * Test applying the pre tag to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testApplingThePreStyleUsingTopToolbar()
    {

        // Test clicking in a P to change to a div
        $this->click($this->findKeyword(4));
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><pre>%4% paragraph to change to a pre</pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

        // Change it back to do more testing
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><p>%4% paragraph to change to a pre</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);

        // Test selecting a word in a P to change to a Pre
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled in the top toolbar');

        // Select all content in the P and change to a Pre
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'active P icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><pre>%4% paragraph to change to a pre</pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

        // Check the state of the format icon after we have changed to a Pre
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should disabled in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'), 'Active toogle formats icon should be active in the top toolbar');
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

    }//end testApplingThePreStyleUsingTopToolbar()


    /**
     * Test that applying styles to whole pre and selecting the PRE in lineage shows correct icons.
     *
     * @return void
     */
    public function testSelectPreAfterStylingShowsCorrectIcons()
    {

        $this->click($this->findKeyword(3));
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);

        // Make sure the correct icons are being shown in the inline toolbar.
        $this->assertTrue($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertEquals($this->replaceKeywords('%1% xtn %2%'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertEquals($this->replaceKeywords('%1% xtn %2%'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectPreAfterStylingShowsCorrectIcons()


    /**
     * Test bold works in Pre.
     *
     * @return void
     */
    public function testUsingBoldInPre()
    {

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<pre><strong>%1%</strong> xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><p>%4% paragraph to change to a pre</p>');

        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><p>%4% paragraph to change to a pre</p>');

    }//end testUsingBoldInPre()


    /**
     * Test italics works in pre.
     *
     * @return void
     */
    public function testUsingItalicInPre()
    {

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<pre><em>%1%</em> xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><p>%4% paragraph to change to a pre</p>');

        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><p>%4% paragraph to change to a pre</p>');

    }//end testUsingItalicInPre()


    /**
     * Test that when you apply bold and italic formatting to all text in a PRE, the inline toolbar stays on the screen.
     *
     * @return void
     */
    public function testInlineToolbarWhenApplyingBoldAndItalicToPre()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<pre><strong>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</strong></pre>');

        // Check that the inline toolbar is still on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }

        $this->assertTrue($inlineToolbarFound, 'The inline toolbar was not found');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<pre><em>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</em></pre>');

        // Check that the inline toolbar is still on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }

        $this->assertTrue($inlineToolbarFound, 'The inline toolbar was not found');

    }//end testInlineToolbarWhenApplyingBoldAndItalicToPre()


    /**
     * Test that the Pre icon is selected when you switch between selection and pre.
     *
     * @return void
     */
    public function testPreIconIsActiveWhenSelectingPreTag()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Active Pre icon appears in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'), 'Active Pre icon appears in the top toolbar');
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Active Pre icon does not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon does not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Disabled formats icon should appear in the top toolbar');

    }//end testPreIconIsActiveWhenSelectingPreTag()


    /**
     * Test that when you select part of a Pre that you cannot change it to another format type.
     *
     * @return void
     */
    public function testPartialSelectionOfPre()
    {
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Active Pre icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Disabled formats icon should appear in the top toolbar');

    }//end testPartialSelectionOfPre()


    /**
     * Test applying and then removing the Pre format.
     *
     * @return void
     */
    public function testApplyingAndRemovingPre()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><pre>%4% paragraph to change to a pre</pre>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('PRE', 'active', TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre> %4% paragraph to change to a pre');

    }//end testApplyingAndRemovingPre()


    /**
     * Test creating new content in pre tags.
     *
     * @return void
     */
    public function testCreatingNewContentWithAPreTag()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('New %5%');
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->selectKeyword(5);
        $this->keyDown('Key.RIGHT');
        $this->type(' on the page');
        $this->keyDown('Key.ENTER');
        $this->type('More new content');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('This should be a paragraph');


        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><p>%4% paragraph to change to a pre</p><pre>New %5% on the page More new content </pre><p>This should be a paragraph</p>');

    }//end testCreatingNewContentWithAPreTag()


    /**
     * Test changing a multi-line div section to a Pre.
     *
     * @return void
     */
    public function testChaningMultiLineDivToPre()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Pre', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('Pre', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');

    }//end testChaningMultiLineDivToPre()


    /**
     * Test applying and then removing the Pre format to a multi line pre.
     *
     * @return void
     */
    public function testRemovingAndApplyingPreToMultiLinePre()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('Pre', 'active', TRUE);
        $this->assertHTMLMatch('%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

        $this->clickTopToolbarButton('Pre', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

    }//end testRemovingAndApplyingPreToMultiLinePre()


}//end class

?>
