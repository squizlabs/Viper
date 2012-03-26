<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_HeadingsUnitTest extends AbstractViperUnitTest
{


   /**
     * Test that heading formats work.
     *
     * @return void
     */
    public function testChangingAHeadingStyle()
    {
        $dir  = dirname(__FILE__).'/Images/';

       $this->selectText('HEADINGS', 'Test');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_heading_subActive.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_h3.png');

        $this->assertHTMLMatch('<h3>HEADINGS Test</h3><p>Lorem xtn dolor</p><p>sit amet <strong>WoW</strong></p><p>Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

    }//end testChangingAHeadingStyle()


    /**
     * Test that removing a heading works.
     *
     * @return void
     */
    public function testRemovingAHeadingStyle()
    {
        $dir  = dirname(__FILE__).'/Images/';

       $this->selectText('HEADINGS', 'Test');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_heading_subHighlighted.png'), 'Headings icon is not highlighted in the inline toolbar');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_p.png');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_heading.png'), 'Headings icon is still highlighted in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Formats icon is not highlighted in the inline toolbar');
        $this->assertHTMLMatch('<p>HEADINGS Test</p><p>Lorem xtn dolor</p><p>sit amet <strong>WoW</strong></p><p>Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

    }//end testRemovingAHeadingStyle()


    /**
     * Test applying a heading style
     *
     * @return void
     */
    public function testApplyingAHeadingStyle()
    {
        $dir  = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_heading.png'), 'Headings icon is active in the toolbar');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_heading.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_h2.png');

        $this->assertHTMLMatch('<h1>HEADINGS Test</h1><h2>Lorem xtn dolor</h2><p>sit amet <strong>WoW</strong></p><p>Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_heading_subActive.png'), 'Headings icon is not active in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_h2_active.png'), 'H2 icon is not active in the inline toolbar');

    }//end testApplyingAHeadingStyle()


    /**
     * Test that the heading icon does not appear in the inline toolbar when you select a paragraph that goes over mulitple lines.
     *
     * @return void
     */
    public function testHeadingIconDoesNotAppear()
    {
        $dir  = dirname(__FILE__).'/Images/';

        $this->selectText('Extra');
        $this->selectInlineToolbarLineageItem(0);

        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_heading.png'), 'Heading icon appears in the toolbar');

    }//end testHeadingIconDoesNotAppear()


    /**
     * Test applying headings to new content.
     *
     * @return void
     */
    public function testApplyingHeadingsToNewContent()
    {
        $dir  = dirname(__FILE__).'/Images/';

        $this->selectText('Test');
        $this->type('Key.RIGHT');
        $this->type('Key.ENTER');
        $this->type('New line of content');

        $this->assertHTMLMatch('<h1>HEADINGS Test</h1><p>New line of content</p><p>Lorem xtn dolor</p><p>sit amet <strong>WoW</strong></p><p>Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

        $this->selectText('WoW');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_heading.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_h6.png');
        $this->type('Key.RIGHT');
        $this->type('Key.ENTER');
        $this->type('Another new line of content');

        $this->assertHTMLMatch('<h1>HEADINGS Test</h1><p>New line of content</p><p>Lorem xtn dolor</p><h6>sit amet <strong>WoW</strong></h6><p>Another new line of content</p><p>Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

    }//end testApplyingHeadingsToNewContent()

}//end class

?>
