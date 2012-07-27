<?php

require_once 'AbstractFormatsUnitTest.php';

class Viper_Tests_ViperFormatPlugin_DivUnitTest extends AbstractFormatsUnitTest
{


    /**
     * Test applying the div tag to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testApplingTheDivStyleUsingInlineToolbar()
    {
        // Test selecting a word in a P to change to a Div
        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Toogle formats icon should not appear in the inline toolbar');

        // Select all content in the P and change to a Div
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Toogle formats should appear in the inline toolbar');
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><div>%3% is a paragraph to change to a %4%</div><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);

        // Check the state of the format icon after we have changed to a Div
        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Active div icon should be active in the inline toolbar');
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);

    }//end testApplingTheDivStyleUsingInlineToolbar()


    /**
     * Test applying the div tag to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testApplingTheDivStyleUsingTopToolbar()
    {
        // Test clicking in a P to change to a div
        $this->click($this->findKeyword(4));
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><div>%3% is a paragraph to change to a %4%</div><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        // Change it back to do more testing
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);

        // Test selecting a word in a P to change to a Div
        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->assertFalse($this->topToolbarButtonExists('formats-p', 'disabled'), 'Formats icon should be disabled in the top toolbar');

        // Select all content in the P and change to a Div
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'active P icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><div>%3% is a paragraph to change to a %4%</div><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        // Check the state of the format icon after we have changed to a Div
        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'Active Div icon should appear in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'Active Div icon should appear in the top toolbar');
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

    }//end testApplingTheDivStyleUsingTopToolbar()


    /**
     * Test that applying styles to whole div and selecting the Div in lineage shows correct icons.
     *
     * @return void
     */
    public function testSelectDivAfterStylingShowsCorrectIcons()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);

        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->selectInlineToolbarLineageItem(0);

        // Make sure the correct icons are being shown in the inline toolbar.
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->assertEquals($this->replaceKeywords('%1% xtn dolor'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertEquals($this->replaceKeywords('%1% xtn dolor'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectDivAfterStylingShowsCorrectIcons()


    /**
     * Test that applying styles to a multi-line div and selecting the Div in lineage shows correct icons.
     *
     * @return void
     */
    public function testSelectMultiLineDivAfterStylingShowsCorrectIcons()
    {
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);

        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->selectInlineToolbarLineageItem(0);

        // Make sure the correct icons are being shown in the inline toolbar.
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->assertEquals($this->replaceKeywords('%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertEquals($this->replaceKeywords('%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.'), $this->getSelectedText(), 'Original selection is not selected');

    }//end testSelectMultiLineDivAfterStylingShowsCorrectIcons()


    /**
     * Test bold works in Div.
     *
     * @return void
     */
    public function testUsingBoldInDiv()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<div><strong>%1%</strong> xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

    }//end testUsingBoldInDiv()


    /**
     * Test italics works in Div.
     *
     * @return void
     */
    public function testUsingItalicInDiv()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<div><em>%1%</em> xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

    }//end testUsingItalicInDiv()


    /**
     * Test that the div icon still appears in the inline toolbar when you switch between selection and div.
     *
     * @return void
     */
    public function testDivIconIsActiveWhenSelectingDivTag()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-div', 'active'), 'Active Div icon should appear in the inline toolbar');
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'active'), 'Active formats icon should appear in the top toolbar');

    }//end testDivIconIsActiveWhenSelectingDivTag()


    /**
     * Test that when you only select part of a Div and apply the Div, it applies a Div inside a Div
     *
     * @return void
     */
    public function testApplyingDivInsideAnotherDiv()
    {
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'active'), 'Active formats icon should appear in the top toolbar');

        // Apply Div
        $this->clickTopToolbarButton('formats', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div><div>%1%</div> xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');

        // Remove Div
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Do the same to a formatted keyword
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'active'), 'Active formats icon should appear in the top toolbar');

        // Apply Div
        $this->clickTopToolbarButton('formats', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <div><strong>%2%</strong></div></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', 'active', 'disabled', 'disabled');

        // Remove Div
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingDivInsideAnotherDiv()


    /**
     * Test applying and then removing the Div format.
     *
     * @return void
     */
    public function testApplyingAndRemovingDiv()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><div>%3% is a paragraph to change to a %4%</div><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->selectKeyword(3 );
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div> %3% is a paragraph to change to a %4% <div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->assertFalse($this->topToolbarButtonExists('DIV', 'active', TRUE));

    }//end testApplyingAndRemovingDiv()


    /**
     * Test creating new content in div's.
     *
     * @return void
     */
    public function testCreatingNewContentWithADivTag()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('New %5%');
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->selectKeyword(5);
        $this->keyDown('Key.RIGHT');
        $this->type(' on the page');
        $this->keyDown('Key.ENTER');
        $this->type('More new content');

        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>New %5% on the page</div><p>More new content</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

    }//end testCreatingNewContentWithADivTag()


    /**
     * Test applying and then removing the Div format to a multi line Div.
     *
     * @return void
     */
    public function testRemovingAndApplyingDivToMultiLineDiv()
    {

        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p> %5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

    }//end testRemovingAndApplyingDivToMultiLineDiv()


     /**
     * Tests that when you select a Div and then a word in that Div, the format icon is active in the top toolbar.
     *
     * @return void
     */
    public function testFormatIconWhenSwitchingBetweenDivAndWord()
    {

        // Highlight the content of a div
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'), 'Active div icon should appear in the top toolbar');

        // Highlight a word in the selected div
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('formats', 'active'), 'Active formats icon should appear in the top toolbar');

    }//end testFormatIconWhenSwitchingBetweenDivAndWord()


}//end class

?>
