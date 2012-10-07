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
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><div>%3% is a paragraph to change to a %4%</div><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);

        // Check the state of the format icon after we have changed to a Div
        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');

        $this->selectInlineToolbarLineageItem(0);
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
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'disabled'), 'Formats icon should be disabled in the top toolbar');

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
        $this->assertTrue($this->topToolbarButtonExists('formats-div'), 'Active Div icon should appear in the top toolbar');

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
        $this->assertTrue($this->topToolbarButtonExists('formats-div'), 'Active formats icon should appear in the top toolbar');

    }//end testDivIconIsActiveWhenSelectingDivTag()


    /**
     * Test that when you only select part of a Div and apply a P, it applies a P inside a Div
     *
     * @return void
     */
    public function testApplyingPInsideDiv()
    {
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-div'), 'DIV format icon should appear in the top toolbar');

        // Apply P
        $this->clickTopToolbarButton('formats-div');
        $this->checkStatusOfFormatIconsInTheTopToolbar();
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->assertHTMLMatch('<div><p>%1%</p> xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // Remove P
        $this->clickTopToolbarButton('P', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

    }//end testApplyingPInsideDiv()


    /**
     * Test that when you only select part of a Div and apply a Pre, it applies a Pre inside a Div
     *
     * @return void
     */
    public function testApplyingPreInsideDiv()
    {
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-div'), 'DIV format icon should appear in the top toolbar');

        // Apply Pre
        $this->clickTopToolbarButton('formats-div');
        $this->checkStatusOfFormatIconsInTheTopToolbar();
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<div><pre>%1%</pre> xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');

        // Remove Pre
        $this->clickTopToolbarButton('PRE', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

    }//end testApplyingPreInsideDiv()


    /**
     * Test that when you only select part of a Div and apply a quote, it applies a quote inside a Div
     *
     * @return void
     */
    public function testApplyingQuoteInsideDiv()
    {
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-div'), 'DIV format icon should appear in the top toolbar');

        // Apply Quote
        $this->clickTopToolbarButton('formats-div');
        $this->checkStatusOfFormatIconsInTheTopToolbar();
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<div><blockquote><p>%1%</p></blockquote> xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);

        // Remove Quote
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<div><p>%1%</p> xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

    }//end testApplyingQuoteInsideDiv()


    /**
     * Test that when you only select part of a Div and apply the Div, it applies a Div inside a Div
     *
     * @return void
     */
    public function testApplyingDivInsideAnotherDiv()
    {
        $this->selectKeyword(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-div'), 'DIV format icon should appear in the top toolbar');

        // Apply Div
        $this->clickTopToolbarButton('formats-div');
        $this->checkStatusOfFormatIconsInTheTopToolbar();
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div><div>%1%</div> xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        // Remove Div
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar();

        // Do the same to a bold keyword
        $this->selectKeyword(2);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');

        // Apply Div
        $this->clickTopToolbarButton('formats-div');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong><div>%2%</div></strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        // Remove Div
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

        // Do the same to an italic keyword
        $this->selectKeyword(2);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Formats icon should not appear in the inline toolbar');

        // Apply Div
        $this->clickTopToolbarButton('formats-div');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <em><div>%2%</div></em></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);

        // Remove Div
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <em>%2%</em></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');

    }//end testApplyingDivInsideAnotherDiv()


    /**
     * Test applying and then removing the Div format using the inline toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingDivUisngInlineToolbar()
    {
        // Test single line
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><div>%3% is a paragraph to change to a %4%</div><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->selectKeyword(3 );
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

        // Test trying to remove it from multi-line div section
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><p>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active');

    }//end testApplyingAndRemovingDivUisngInlineToolbar()


    /**
     * Test applying and then removing the Div format using the top toolbar.
     *
     * @return void
     */
    public function testApplyingAndRemovingDivUisngTopToolbar()
    {
        // Test single line
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><div>%3% is a paragraph to change to a %4%</div><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->selectKeyword(3 );
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

        // Test trying to remove it from multi-line div section
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><p>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</p>');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active');

    }//end testApplyingAndRemovingDivUisngTopToolbar()


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
        $this->type('New %6%');
        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->moveToKeyword(6, 'right');
        $this->type(' on the page');
        $this->keyDown('Key.ENTER');
        $this->type('More new content');

        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>New %6% on the page</div><p>More new content</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

    }//end testCreatingNewContentWithADivTag()


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
        $this->assertTrue($this->topToolbarButtonExists('formats-div'), 'Div icon should be enabled in the top toolbar');

    }//end testFormatIconWhenSwitchingBetweenDivAndWord()


    /**
     * Tests changing a div to a paragraph and then back again using the inline toolbar.
     *
     * @return void
     */
    public function testChangingADivToAParagraphUsingInlineToolbar()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn dolor</p><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

    }//end testChangingADivToAParagraphUsingInlineToolbar()


    /**
     * Tests changing a div to a paragraph and then back again using the top toolbar.
     *
     * @return void
     */
    public function testChangingADivToAParagraphUsingTopToolbar()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% xtn dolor</p><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

    }//end testChangingADivToAParagraphUsingTopToolbar()


     /**
     * Tests changing a div to a PRE and then back again using the inline toolbar.
     *
     * @return void
     */
    public function testChangingADivToAPreUsingTheInlineToolbar()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn dolor</pre><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

    }//end testChangingADivToAPreUsingTheInlineToolbar()


     /**
     * Tests changing a div to a PRE and then back again using the top toolbar.
     *
     * @return void
     */
    public function testChangingADivToAPreUsingTheTopToolbar()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, 'active');
        $this->assertHTMLMatch('<pre>%1% xtn dolor</pre><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, 'active', NULL, NULL);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

    }//end testChangingADivToAPreUsingTheTopToolbar()


     /**
     * Test changing a quote to a div and then back again using the inline toolbar.
     *
     * @return void
     */
    public function testChangingADivToAQuoteUsingTheInlineToolbar()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-blockquote', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

    }//end testChangingADivToAQuoteUsingTheInlineToolbar()


     /**
     * Test changing a quote to a div and then back again using the top toolbar.
     *
     * @return void
     */
    public function testChangingADivToAQuoteUsingTheTopToolbar()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, 'active', NULL);
        $this->assertHTMLMatch('<blockquote><p>%1% xtn dolor</p></blockquote><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

    }//end testChangingADivToAQuoteUsingTheTopToolbar()


     /**
     * Tests that the list icons are not available for a div.
     *
     * @return void
     */
    public function testListIconsNotAvailableForDiv()
    {

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');
        $this->keyDown('Key.RIGHT');

        $this->click($this->findKeyword(5));
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(5);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('listOL', 'disabled'), 'Ordered list icon should be available in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('listUL', 'disabled'), 'Unordered list icon should be available in the top toolbar');

    }//end testListIconsNotAvailableForDiv()


    /**
     * Test undo and redo for a div.
     *
     * @return void
     */
    public function testUndoAndRedoForDiv()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><div>%3% is a paragraph to change to a %4%</div><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><p>%3% is a paragraph to change to a %4%</p><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<div>%1% xtn dolor</div><p>spacer for the tests</p><div>sit amet <strong>%2%</strong></div><div>%3% is a paragraph to change to a %4%</div><div>%5% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis ac augue mi. Nam risus massa, aliquam non porta vel, lacinia a sapien. Nam iaculis sollicitudin sem, vitae dapibus massa dignissim vitae.</div>');

    }//end testUndoAndRedoForDiv()


}//end class

?>
