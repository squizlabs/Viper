<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_HeadingsUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that heading formats work.
     *
     * @return void
     */
    public function testAHeading()
    {
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('headings', 'active');
        $this->clickInlineToolbarButton('H2', NULL, TRUE);
        $this->assertHTMLMatch('<h2>%1% %2%</h2><p>%3% xtn dolor</p><p>sit amet <strong>%4%</strong></p><p>%5% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

        $this->clickInlineToolbarButton('H3', NULL, TRUE);
        $this->assertHTMLMatch('<h3>%1% %2%</h3><p>%3% xtn dolor</p><p>sit amet <strong>%4%</strong></p><p>%5% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

        $this->clickInlineToolbarButton('H4', NULL, TRUE);
        $this->assertHTMLMatch('<h4>%1% %2%</h4><p>%3% xtn dolor</p><p>sit amet <strong>%4%</strong></p><p>%5% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

        $this->clickInlineToolbarButton('H5', NULL, TRUE);
        $this->assertHTMLMatch('<h5>%1% %2%</h5><p>%3% xtn dolor</p><p>sit amet <strong>%4%</strong></p><p>%5% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

        $this->clickInlineToolbarButton('H1', NULL, TRUE);
        $this->assertHTMLMatch('<h1>%1% %2%</h1><p>%3% xtn dolor</p><p>sit amet <strong>%4%</strong></p><p>%5% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

    }//end testHeading()


    /**
     * Test that removing a heading works.
     *
     * @return void
     */
    public function testRemovingAHeadingStyle()
    {
        $this->click($this->findKeyword(3));
        $this->selectKeyword(1, 2);

        $this->assertTrue($this->inlineToolbarButtonExists('headings', 'active'), 'Headings icon is not highlighted in the inline toolbar');
        $this->assertTrue($this->topToolbarButtonExists('headings', 'active'), 'Headings icon is not highlighted in the top toolbar');

        $this->clickInlineToolbarButton('headings', 'active');
        $this->clickInlineToolbarButton('H1', 'active', TRUE);

        $this->assertTrue($this->inlineToolbarButtonExists('headings', 'selected'), 'Headings icon is still highlighted in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('H1', NULL, TRUE), 'H1 icon is still selected');
        $this->assertTrue($this->inlineToolbarButtonExists('formats-p', 'active'), 'Formats icon is not highlighted in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings'), 'Headings icon is still highlighted in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'), 'Formats icon is not highlighted in the top toolbar');

        $this->assertHTMLMatch('<p>%1% %2%</p><p>%3% xtn dolor</p><p>sit amet <strong>%4%</strong></p><p>%5% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

    }//end testRemovingAHeadingStyle()


    /**
     * Test applying a heading style
     *
     * @return void
     */
    public function testApplyingAHeadingStyle()
    {

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->inlineToolbarButtonExists('headings'), 'Headings icon is active in the toolbar');

        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H3', NULL, TRUE);

        $this->assertHTMLMatch('<h1>%1% %2%</h1><h3>%3% xtn dolor</h3><p>sit amet <strong>%4%</strong></p><p>%5% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

        $this->assertTrue($this->inlineToolbarButtonExists('headings', 'active'), 'Headings icon is not active in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('H2', NULL, TRUE), 'H2 icon is not active in the inline toolbar');

        $this->assertTrue($this->topToolbarButtonExists('headings', 'active'), 'Headings icon is not active in the inline toolbar');

    }//end testApplyingAHeadingStyle()


    /**
     * Test that the heading icon does not appear in the inline toolbar when you select a paragraph that goes over mulitple lines.
     *
     * @return void
     */
    public function testHeadingIconDoesNotAppear()
    {
        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertFalse($this->inlineToolbarButtonExists('headings'), 'Heading icon appears in the toolbar');

    }//end testHeadingIconDoesNotAppear()


    /**
     * Test applying headings to new content.
     *
     * @return void
     */
    public function testApplyingHeadingsToNewContent()
    {
        $this->selectKeyword(2);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('New line of content %6%');

        $this->assertHTMLMatch('<h1>%1% %2%</h1><p>New line of content %6%</p><p>%3% xtn dolor</p><p>sit amet <strong>%4%</strong></p><p>%5% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('headings');
        $this->clickInlineToolbarButton('H3', NULL, TRUE);
        $this->selectKeyword(6);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('Another new line of content');

        $this->assertHTMLMatch('<h1>%1% %2%</h1><h3>New line of content %6%</h3><p>Another new line of content</p><p>%3% xtn dolor</p><p>sit amet <strong>%4%</strong></p><p>%5% long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar. Extra long paragraph for testing that the heading icon does not appear in the inline toolbar.</p>');

    }//end testApplyingHeadingsToNewContent()

}//end class

?>
