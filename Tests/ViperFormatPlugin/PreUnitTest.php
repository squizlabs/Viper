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
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><pre>%4% paragraph to change to a pre</pre>');
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
        // Test clicking in a P to change to a Pre
        $this->click($this->findKeyword(4));
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><pre>%4% paragraph to change to a pre</pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

        // Change it back to do more testing
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);

        // Test selecting a word in a P to change to a Pre
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'disabled'), 'Formats icon should be disabled in the top toolbar');

        // Select all content in the P and change to a Pre
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'active P icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><pre>%4% paragraph to change to a pre</pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

        // Check the state of the format icon after we have changed to a Pre
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'disabled'), 'Formats icon should disabled in the top toolbar');

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
     * Test that applying styles to multi-line pre and selecting the PRE in lineage shows correct icons.
     *
     * @return void
     */
    public function testSelectMultiLinePreAfterStylingShowsCorrectIcons()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->selectInlineToolbarLineageItem(0);

        // Make sure the correct icons are being shown in the inline toolbar.
        $this->assertTrue($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertEquals($this->replaceKeywords('%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertEquals($this->replaceKeywords('%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectMultiLinePreAfterStylingShowsCorrectIcons()


    /**
     * Test bold works in Pre.
     *
     * @return void
     */
    public function testUsingBoldInPre()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<pre><strong>%1%</strong> xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

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

        $this->assertHTMLMatch('<pre><em>%1%</em> xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

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

        $this->assertHTMLMatch('<pre><strong>%1% xtn %2%</strong></pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

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

        $this->assertHTMLMatch('<pre><em>%1% xtn %2%</em></pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

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
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'disabled'), 'Disabled formats icon should appear in the top toolbar');

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
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'disabled'), 'Disabled formats icon should appear in the top toolbar');

    }//end testPartialSelectionOfPre()


    /**
     * Test applying and then removing the Pre format using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingPreUsingTheInlineToolbar()
    {
        // Test single line
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><pre>%4% paragraph to change to a pre</pre>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('PRE', 'active', TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        // Test changing a multi-line section
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre><p>%4% paragraph to change to a pre</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');

        $this->clickInlineToolbarButton('PRE', 'active', TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><p>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p><p>%4% paragraph to change to a pre</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

    }//end testApplyingAndRemovingPreUsingTheInlineToolbar()


    /**
     * Test applying and then removing the Pre format using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingPreUsingTheTopToolbar()
    {
        // Test single line
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><pre>%4% paragraph to change to a pre</pre>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('PRE', 'active', TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // Test changing a multi-line section
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre><p>%4% paragraph to change to a pre</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

        $this->clickTopToolbarButton('PRE', 'active', TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><p>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p><p>%4% paragraph to change to a pre</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

    }//end testApplyingAndRemovingPreUsingTheTopToolbar()


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


        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p><pre>New %5% on the page More new content </pre><p>This should be a paragraph</p>');

    }//end testCreatingNewContentWithAPreTag()


    /**
     * Test changing a multi-line div section to a Pre.
     *
     * @return void
     */
    public function testChaningMultiLineDivToPre()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Pre', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre><p>%4% paragraph to change to a pre</p>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre><p>%4% paragraph to change to a pre</p>');

    }//end testChaningMultiLineDivToPre()


     /**
     * Tests that when you select a Pre and then a word in that Pre, the disabled format icon is shown in the top toolbar.
     *
     * @return void
     */
    public function testFormatIconWhenSwitchingBetweenPreAndWord()
    {
        // Highlight the content of a pre
        $this->selectKeyword(1, 2);
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'), 'Active pre icon should appear in the top toolbar');

        // Highlight a word in the selected paragraph
        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'disabled'), 'Pre icon should be disabled in the top toolbar');

    }//end testFormatIconWhenSwitchingBetweenPreAndWord()


    /**
     * Tests changing a Pre to a div and then back again using the inline toolbar.
     *
     * @return void
     */
    public function testChangingAPreToADivUsingInlineToolbar()
    {
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn %2%</div><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

    }//end testChangingAPreToADivUsingInlineToolbar()


    /**
     * Tests changing a Pre to a div and then back again using the top toolbar.
     *
     * @return void
     */
    public function testChangingAPreToADivUsingTopToolbar()
    {
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn %2%</div><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

    }//end testChangingAParagraphToADivUsingTopToolbar()


     /**
     * Tests changing a Pre to a paragraph and then back again using the inline toolbar.
     *
     * @return void
     */
    public function testChangingAPreToAPUsingTheInlineToolbar()
    {
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

    }//end testChangingAPreToAPUsingTheInlineToolbar()


     /**
     * Tests changing a Pre to a paragraph and then back again using the top toolbar.
     *
     * @return void
     */
    public function testChangingAPreToAPUsingTheTopToolbar()
    {
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn %2%</p><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

    }//end testChangingAPreToAPUsingTheTopToolbar()


     /**
     * Tests changing a Pre to a quote and then back again.
     *
     * @return void
     */
    public function testChangingAPreToAQuoteUsingTheInlineToolbar()
    {
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

    }//end testChangingAPreToAQuoteUsingTheInlineToolbar()


     /**
     * Tests changing a Pre to a quote and back again.
     *
     * @return void
     */
    public function testChangingAPreToAQuoteUsingTheTopToolbar()
    {
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn %2%</p></blockquote><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

        $this->selectKeyword(1, 2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><div>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div><p>%4% paragraph to change to a pre</p>');

    }//end testChangingAPreToAQuoteUsingTheTopToolbar()


     /**
     * Tests that the list icons are not available for a pre.
     *
     * @return void
     */
    public function testListIconsNotAvailableForPre()
    {

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');
        $this->keyDown('Key.RIGHT');

        // Change the div to a Pre
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</pre><p>%4% paragraph to change to a pre</p>');

        $this->click($this->findKeyword(3));
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

    }//end testListIconsNotAvailableForPre()


}//end class

?>
