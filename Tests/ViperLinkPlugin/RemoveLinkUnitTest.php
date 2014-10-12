<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLinkPlugin_RemoveLinkUnitTest extends AbstractViperUnitTest
{

     /**
     * Test that you cannot delete a link using the x button in the toolbar
     *
     * @return void
     */
    public function testCannotRemoveLinkWhenClearingURLField()
    {
        // Check inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content with a link <a href="http://www.squizlabs.com">%1%</a></p>');

        // Check top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content with a link <a href="http://www.squizlabs.com">%1%</a></p>');

    }//end testCannotRemoveLinkWhenClearingURLField()
    

    /**
     * Test that a link can be removed when you select the text.
     *
     * @return void
     */
    public function testRemoveLinkWhenSelectingText()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'));
        $this->assertTrue($this->inlineToolbarButtonExists('link'));
        $this->assertHTMLMatch('<p>Content with a link %1%</p>');

        // Using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertFalse($this->topToolbarButtonExists('linkRemove'));
        $this->assertTrue($this->topToolbarButtonExists('link'));
        $this->assertHTMLMatch('<p>Content with a link %1%</p>');

    }//end testRemoveLinkWhenSelectingText()


    /**
     * Test that a link can be removed when you click inside the link.
     *
     * @return void
     */
    public function testRemoveLinkWhenClickingInLink()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>Content with a link %1%</p>');

        // Using the top toolbar
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertFalse($this->topToolbarButtonExists('linkRemove'));
        $this->assertFalse($this->topToolbarButtonExists('link'));
        $this->assertHTMLMatch('<p>Content with a link %1%</p>');

    }//end testRemoveLinkWhenClickingInLink()


    /**
     * Test that a link can be removed when have the link fields open
     * @return void
     */
    public function testRemoveLinkWhenLinkFieldsAreOpen()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Link icon should still be selected in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should not be available in the inline toolbar');
        $this->assertHTMLMatch('<p>Content with a link %1%</p>');

        // Using the top toolbar
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickTopToolbarButton('linkRemove');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Link icon should still be selected in the inline toolbar');
        $this->assertFalse($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should not be available in the inline toolbar');
        $this->assertHTMLMatch('<p>Content with a link %1%</p>');

    }//end testRemoveLinkWhenLinkFieldsAreOpen()


    /**
     * Test removing link from paragraph.
     *
     * @return void
     */
    public function testRemoveLinkFromParagraph()
    {
        // Using the inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>%1% paragraph with a link test</p>');

        // Using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertEquals($this->replaceKeywords('%1% paragraph with a link test'), $this->getSelectedText(), 'Paragraph is not selected.');
        $this->assertHTMLMatch('<p>%1% paragraph with a link test</p>');

    }//end testRemoveLinkFromParagraph()

}//end class

?>