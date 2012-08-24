<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_HorizontalRuleUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that you can add and delete a horizontal rule at the end of a paragraph.
     *
     * @return void
     */
    public function testAddingAndDeletingAHorizontalRuleAtEndOfParagraph()
    {
        $this->useTest(1);

        $this->selectKeyword(3);
        $this->keyDown('Key.RIGHT');

        $this->clickTopToolbarButton('insertHr');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.BACKSPACE');
        $this->type('%4% new line of content');

        $this->assertHTMLMatch('<p>%1% %2% dolor sit <em>amet</em> <strong>%3%</strong></p><hr /><p>%4% new line of content</p>');

        $this->selectKeyword(4);
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1% %2% dolor sit <em>amet</em> <strong>%3%</strong></p><p>%4% new line of content</p>');

    }//end testAddingAndDeletingAHorizontalRuleAtEndOfParagraph()


    /**
     * Test that you can add a horizontal rule at the middle of a paragraph.
     *
     * @return void
     */
    public function testAddingHorizontalRuleInMiddleOfParagraph()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('insertHr');

        $this->type('New Content');

        $this->assertHTMLMatch('<p>%1% %2%</p><hr /><p>New Contentdolor sit <em>amet</em> <strong>%3%</strong></p>');

    }//end testAddingHorizontalRuleInMiddleOfParagraph()


    /**
     * Test that you can add a horizontal rule at the start of a paragraph.
     *
     * @return void
     */
    public function testAddingHorizontalRuleAtStartOfParagraph()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->keyDown('Key.LEFT');

        $this->clickTopToolbarButton('insertHr');

        $this->type('New Content');

        $this->assertHTMLMatch('<hr /><p>New Content%1% %2% dolor sit <em>amet</em> <strong>%3%</strong></p>');

    }//end testAddingHorizontalRuleAtStartOfParagraph()


    /**
     * Test that you can add a horizontal rule after a heading.
     *
     * @return void
     */
    public function testAddingAndDeletingHorizontalRuleAfterHeading()
    {
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');

        $this->clickTopToolbarButton('insertHr');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.BACKSPACE');
        $this->type('%2% Content');

        $this->assertHTMLMatch('<h1>Heading %1%</h1><hr /><p>%2% Content</p><p>Paragraph after heading</p>');

        $this->selectKeyword(2);
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<h1>Heading %1%</h1><p>%2% Content</p><p>Paragraph after heading</p>');

    }//end testAddingAndDeletingHorizontalRuleAfterHeading()


    /**
     * Test adding a horizontal rule after formatted text.
     *
     * @return void
     */
    public function testAddingHorizontalRuleAfterFormattedText()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('subscript');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('insertHr');

        $this->assertHTMLMatch('<p>%1% <sub>%2%</sub> dolor sit <em>amet</em> <strong><del>%3%</del></strong></p><p></p><hr /><p></p>');

    }//end testAddingHorizontalRuleAfterFormattedText()


    /** Test adding a horizontal rule after removing a list item.
     *
     * @return void
     */
    public function testAddingHorizontalRuleAfterRemovingListItem()
    {
        $this->useTest(3);

        $this->selectKeyword(2);

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->clickTopToolbarButton('insertHr');

        $this->assertHTMLMatch('<p>This is a list:</p><ul><li>Test removing bullet points</li><li>purus %1% luctus</li><li>vel molestie %2%</li></ul><p></p><hr /><p></p>');

    }//end testAddingHorizontalRuleAfterRemovingListItem()


    /**
     * Test that the horizontal icon is not available for a list.
     *
     * @return void
     */
    public function testHorizontalIconForAList()
    {
        $this->useTest(3);

        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be active in the top toolbar.');

        $this->keyDown('Key.TAB');
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not active in the top toolbar.');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->keyDown('Key.ENTER');
        $this->type('New parra');
        $this->assertTrue($this->topToolbarButtonExists('insertHr'), 'HR icon should appear in the top toolbar.');

    }//end testHorizontalIconForAList()


    /**
     * Test horizontal rule icon is disabled in a table.
     *
     * @return void
     */
    public function testHorizontalRuleIconInTable()
    {
        $this->useTest(4);

        // Test icon in a caption
        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        // Test icon in a header cells
        $this->click($this->findKeyword(2));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        // Test icon in a footer cells
        $this->click($this->findKeyword(3));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        // Test icon in a body cells
        $this->click($this->findKeyword(4));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectKeyword(4);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(3);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(2);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

    }//end testAddingHorizontalRuleAfterRemovingListItem()


}//end class


?>
