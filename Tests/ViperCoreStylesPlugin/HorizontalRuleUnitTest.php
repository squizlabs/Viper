<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_HorizontalRuleUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that you can add a horizontal rule at the end of a paragraph.
     *
     * @return void
     */
    public function testAddingHorizontalRuleAtEndOfParagraph()
    {
        $this->selectKeyword(4);
        $this->keyDown('Key.RIGHT');

        $this->clickTopToolbarButton('insertHr');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.BACKSPACE');
        $this->type('This is a new line of ConTenT');

        $this->assertHTMLMatch('<h1>First %1%</h1><p>%2% %3% dolor sit <em>amet</em> <strong>%4%</strong></p><hr /><p>This is a new line of ConTenT</p><h2>Second heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus %5% luctus</li><li>vel molestie %6%</li></ul>');

    }//end testAddingHorizontalRuleAtEndOfParagraph()


    /**
     * Test that you can add and delete a horizontal rule at the end of a paragraph.
     *
     * @return void
     */
    public function testAddingAndDeletingAHorizontalRuleAtEndOfParagraph()
    {
        $this->selectKeyword(4);
        $this->keyDown('Key.RIGHT');

        $this->clickTopToolbarButton('insertHr');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.BACKSPACE');
        $this->type('%6% new line of content');

        $this->assertHTMLMatch('<h1>First %1%</h1><p>%2% %3% dolor sit <em>amet</em> <strong>%4%</strong></p><hr /><p>%6% new line of content</p><h2>Second heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus %5% luctus</li><li>vel molestie %6%</li></ul>');

        $this->selectKeyword(6);
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<h1>First %1%</h1><p>%2% %3% dolor sit <em>amet</em> <strong>%4%</strong></p><p>%6% new line of content</p><h2>Second heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus %5% luctus</li><li>vel molestie %6%</li></ul>');

    }//end testAddingAndDeletingAHorizontalRuleAtEndOfParagraph()


    /**
     * Test that you can add a horizontal rule at the middle of a paragraph.
     *
     * @return void
     */
    public function testAddingHorizontalRuleInMiddleOfParagraph()
    {
        $this->selectKeyword(3);
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton('insertHr');

        $this->type('New Content');

        $this->assertHTMLMatch('<h1>First %1%</h1><p>%2% %3%</p><hr /><p>New Contentdolor sit <em>amet</em> <strong>%4%</strong></p><h2>Second heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus %5% luctus</li><li>vel molestie %6%</li></ul>');

    }//end testAddingHorizontalRuleInMiddleOfParagraph()


    /**
     * Test that you can add a horizontal rule at the start of a paragraph.
     *
     * @return void
     */
    public function testAddingHorizontalRuleAtStartOfParagraph()
    {
        $this->selectKeyword(2);
        $this->keyDown('Key.LEFT');

        $this->clickTopToolbarButton('insertHr');

        $this->type('New Content');

        $this->assertHTMLMatch('<h1>First %1%</h1><hr /><p>New Content%2% %3% dolor sit <em>amet</em> <strong>%4%</strong></p><h2>Second heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus %5% luctus</li><li>vel molestie %6%</li></ul>');

    }//end testAddingHorizontalRuleAtStartOfParagraph()


    /**
     * Test that you can add a horizontal rule after a heading.
     *
     * @return void
     */
    public function testAddingAndDeletingHorizontalRuleAfterHeading()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');

        $this->clickTopToolbarButton('insertHr');

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.BACKSPACE');
        $this->type('%6% Content');

        $this->assertHTMLMatch('<h1>First %1%</h1><hr /><p>%6% Content</p><p>%2% %3% dolor sit <em>amet</em> <strong>%4%</strong></p><h2>Second heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus %5% luctus</li><li>vel molestie %6%</li></ul>');

        $this->selectKeyword(6);
        $this->keyDown('Key.LEFT');
        $this->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<h1>First %1%</h1><p>%6% Content</p><p>%2% %3% dolor sit <em>amet</em> <strong>%4%</strong></p><h2>Second heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus %5% luctus</li><li>vel molestie %6%</li></ul>');

    }//end testAddingAndDeletingHorizontalRuleAfterHeading()


    /**
     * Test adding a horizontal rule after formatted text.
     *
     * @return void
     */
    public function testAddingHorizontalRuleAfterFormattedText()
    {
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('subscript');

        $this->selectKeyword(4);
        $this->clickTopToolbarButton('strikethrough');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('insertHr');

        $this->assertHTMLMatch('<h1>First %1%</h1><p>%2% <sub>%3%</sub> dolor sit <em>amet</em> <strong><del>%4%</del></strong></p><p>&nbsp;</p><hr /><p>&nbsp;</p><h2>Second heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus %5% luctus</li><li>vel molestie %6%</li></ul>');

    }//end testAddingHorizontalRuleAfterFormattedText()


    /**
     * Test adding a horizontal rule after removing a list item.
     *
     * @return void
     */
    public function testAddingHorizontalRuleAfterRemovingListItem()
    {
        $this->selectKeyword(6);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->clickTopToolbarButton('insertHr');

        $this->assertHTMLMatch('<h1>First %1%</h1><p>%2% %3% dolor sit <em>amet</em> <strong>%4%</strong></p><h2>Second heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus %5% luctus</li><li>vel molestie %6%</li></ul><p></p><hr /><p></p>');

    }//end testAddingHorizontalRuleAfterRemovingListItem()


}//end class


?>
