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

        // Add hr
        $this->moveToKeyword(3, 'right');
        $this->clickTopToolbarButton('insertHr');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('%4% new line of content');
        $this->assertHTMLMatch('<p>%1% %2% dolor sit <em>amet</em> <strong>%3%</strong></p><hr /><p>%4% new line of content</p>');

        // Delete hr
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%1% %2% dolor sit <em>amet</em> <strong>%3%</strong></p><p>%4% new line of content</p>');

    }//end testAddingAndDeletingAHorizontalRuleAtEndOfParagraph()


    /**
     * Test that you can add a horizontal rule at the middle of a paragraph.
     *
     * @return void
     */
    public function testAddingAndDeletingHorizontalRuleInMiddleOfParagraph()
    {
        $this->useTest(1);

        // Add hr
        $this->moveToKeyword(2, 'right');
        $this->clickTopToolbarButton('insertHr');
        $this->type('%4% new content');

        if ($this->sikuli->getBrowserid() === 'safari') {
            $this->assertHTMLMatch('<p>%1% %2%</p><hr /><p>%4% new contentdolor sit <em>amet</em> <strong>%3%</strong></p>');
        } else {
            $this->assertHTMLMatch('<p>%1% %2%</p><hr /><p>%4% new content dolor sit <em>amet</em> <strong>%3%</strong></p>');
        }

        // Delete hr
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');

        if ($this->sikuli->getBrowserid() === 'safari') {
            $this->assertHTMLMatch('<p>%1% %2%</p><p>%4% new contentdolor sit <em>amet</em> <strong>%3%</strong></p>');
        } else {
            $this->assertHTMLMatch('<p>%1% %2%</p><p>%4% new content dolor sit <em>amet</em> <strong>%3%</strong></p>');
        }

    }//end testAddingAndDeletingHorizontalRuleInMiddleOfParagraph()


    /**
     * Test that you can add a horizontal rule at the start of a paragraph.
     *
     * @return void
     */
    public function testAddingAndDeletingHorizontalRuleAtStartOfParagraph()
    {
        $this->useTest(1);

        // Add hr
        $this->moveToKeyword(1, 'left');
        sleep(2);
        $this->clickTopToolbarButton('insertHr');
        $this->type('%4% new content');
        $this->assertHTMLMatch('<hr /><p>%4% new content%1% %2% dolor sit <em>amet</em> <strong>%3%</strong></p>');

        // Delete hr
        $this->moveToKeyword(4, 'left');
        sleep(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->assertHTMLMatch('<p>%4% new content%1% %2% dolor sit <em>amet</em> <strong>%3%</strong></p>');

    }//end testAddingHorizontalRuleAtStartOfParagraph()


    /**
     * Test that you can add a horizontal rule after a heading.
     *
     * @return void
     */
    public function testAddingAndDeletingHorizontalRuleAfterHeading()
    {
        $this->useTest(2);

        $this->moveToKeyword(1, 'right');

        $this->clickTopToolbarButton('insertHr');

        //$this->sikuli->keyDown('Key.RIGHT');
        //$this->sikuli->keyDown('Key.BACKSPACE');
        $this->type('%3% Content');

        $this->assertHTMLMatch('<h1>Heading %1%</h1><hr /><p>%3% ContentParagraph after heading %2%</p><p>Another paragraph</p>');

        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<h1>Heading %1%</h1><p>%3% ContentParagraph after heading %2%</p><p>Another paragraph</p>');

    }//end testAddingAndDeletingHorizontalRuleAfterHeading()


    /**
     * Test that you can add a horizontal rule in between two paragraphs.
     *
     * @return void
     */
    public function testAddingAndDeletingHorizontalRuleBetweenParagraphs()
    {
        $this->useTest(2);

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('insertHr');
        $this->assertHTMLMatch('<h1>Heading %1%</h1><p>Paragraph after heading %2%</p><hr /><p>Another paragraph</p>');

    }//end testAddingAndDeletingHorizontalRuleBetweenParagraphs()


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
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('insertHr');

        $this->assertHTMLMatch('<p>%1% <sub>%2%</sub> dolor sit <em>amet</em> <del><strong>%3%</strong></del></p><hr />');

    }//end testAddingHorizontalRuleAfterFormattedText()


    /** Test adding a horizontal rule after removing a list item.
     *
     * @return void
     */
    public function testAddingHorizontalRuleAfterRemovingListItem()
    {
        $this->useTest(3);

        // Test ul list
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->clickTopToolbarButton('insertHr');

        $this->assertHTMLMatch('<p>This is ul list:</p><ul><li>List item 1</li><li>List item 2 %1%</li><li>List item 3 %2%</li></ul><hr /><p>This is ol list:</p><ol><li>List item 1</li><li>List item 2 %3%</li><li>List item 3 %4%</li></ol>');

        // Test ol list
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->clickTopToolbarButton('insertHr');

        $this->assertHTMLMatch('<p>This is ul list:</p><ul><li>List item 1</li><li>List item 2 %1%</li><li>List item 3 %2%</li></ul><hr /><p>This is ol list:</p><ol><li>List item 1</li><li>List item 2 %3%</li><li>List item 3 %4%</li></ol><hr />');

    }//end testAddingHorizontalRuleAfterRemovingListItem()


    /**
     * Test that the horizontal icon is not available for a list.
     *
     * @return void
     */
    public function testHorizontalIconForAList()
    {
        $this->useTest(3);

        // Test ul list
        $this->sikuli->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be active in the top toolbar.');

        $this->sikuli->keyDown('Key.TAB');
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not active in the top toolbar.');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New parra');
        $this->assertTrue($this->topToolbarButtonExists('insertHr'), 'HR icon should appear in the top toolbar.');

        // Test ol list
        $this->sikuli->click($this->findKeyword(3));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be active in the top toolbar.');

        $this->sikuli->keyDown('Key.TAB');
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not active in the top toolbar.');

        $this->selectKeyword(3);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should not appear in the top toolbar.');

        $this->sikuli->keyDown('Key.ENTER');
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
        $this->sikuli->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('insertHr', 'disabled'), 'HR icon should be disabled');

        // Test icon in a header cells
        $this->sikuli->click($this->findKeyword(2));
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
        $this->sikuli->click($this->findKeyword(3));
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
        $this->sikuli->click($this->findKeyword(4));
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
