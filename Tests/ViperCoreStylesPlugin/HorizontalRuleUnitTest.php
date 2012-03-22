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
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('WoW');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_horizontalRule.png');

        $this->type('Key.RIGHT');
        $this->type('Key.BACKSPACE');
        $this->type('This is a new line of ConTenT');

        $this->assertHTMLMatch(
            '<h1>First Heading</h1><p>Lorem XuT dolor sit <em>amet</em> <strong>WoW</strong></p><hr /><p>This is a new line of ConTenT</p><h2>Second Heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus <u>neque</u> luctus</li><li>vel molestie arcu</li></ul>',
            '<h1>First Heading</h1><p>Lorem XuT dolor sit <em>amet</em> <strong>WoW</strong></p><hr><p>This is a new line of ConTenT</p><h2>Second Heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus <u>neque</u> luctus</li><li>vel molestie arcu</li></ul>');

    }//end testAddingHorizontalRuleAtEndOfParagraph()


    /**
     * Test that you can add a horizontal rule at the middle of a paragraph.
     *
     * @return void
     */
    public function testAddingHorizontalRuleInMiddleOfParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
        $this->type('Key.RIGHT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_horizontalRule.png');

        $this->type('New ConTenT');

        $this->assertHTMLMatch(
            '<h1>First Heading</h1><p>Lorem XuT</p><hr /><p>New ConTenTdolor sit <em>amet</em> <strong>WoW</strong></p><h2>Second Heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus <u>neque</u> luctus</li><li>vel molestie arcu</li></ul>',
            '<h1>First Heading</h1><p>Lorem XuT</p><hr><p>New ConTenTdolor sit <em>amet</em> <strong>WoW</strong></p><h2>Second Heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus <u>neque</u> luctus</li><li>vel molestie arcu</li></ul>');

    }//end testAddingHorizontalRuleInMiddleOfParagraph()


    /**
     * Test that you can add a horizontal rule at the start of a paragraph.
     *
     * @return void
     */
    public function testAddingHorizontalRuleAtStartOfParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->type('Key.LEFT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_horizontalRule.png');

        $this->type('New ConTenT');

        $this->assertHTMLMatch(
            '<h1>First Heading</h1><hr /><p>New ConTenTLorem XuT dolor sit <em>amet</em> <strong>WoW</strong></p><h2>Second Heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus <u>neque</u> luctus</li><li>vel molestie arcu</li></ul>',
            '<h1>First Heading</h1><hr><p>New ConTenTLorem XuT dolor sit <em>amet</em> <strong>WoW</strong></p><h2>Second Heading</h2><p>This is another paragraph</p><ul><li>Test removing bullet points</li><li>purus <u>neque</u> luctus</li><li>vel molestie arcu</li></ul>');

    }//end testAddingHorizontalRuleAtStartOfParagraph()


}//end class


?>



