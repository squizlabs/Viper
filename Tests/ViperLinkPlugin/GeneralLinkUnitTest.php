<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLinkPlugin_GeneralLinkUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that the link icon appears in the inline toolbar after applying and deleting a link twice.
     *
     * @return void
     */
    public function testLinkIconAppearsInInlineToolbarAfterDeletingLinkTwice()
    {
        $this->useTest(1);

        // Create a link
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p>Link test <a href="http://www.squizlabs.com">%1% test %2%</a></p>');

        // Remove the link
        $this->moveToKeyword(2);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>Link test %1% test %2%</p>');

        // Create the link again
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p>Link test <a href="http://www.squizlabs.com">%1% test %2%</a></p>');

        // Remove the link
        $this->moveToKeyword(2);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>Link test %1% test %2%</p>');

        // Check for the icon
        $this->selectKeyword(1, 2);
        $this->assertTrue($this->inlineToolbarButtonExists('link'));

    }//end testLinkIconAppearsInInlineToolbarAfterDeletingLinkTwice()


    /**
     * Test that selecting a link shows the correct Viper icons.
     *
     * @return void
     */
    public function testSelectLink()
    {
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be active in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Link</li>', $lineage);

    }//end testSelectLink()


    /**
     * Test that partially selectiing a link still shows the inline toolbar and allows you to remove the link.
     *
     * @return void
     */
    public function testSelectPartialLinkShowsToolbar()
    {
        $this->useTest(2);

        $this->moveToKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');

        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');

        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>Link test %1% test</p>');

    }//end testSelectPartialLinkShowsToolbar()


    /**
     * Test that clicking inside a link will show the inline toolbar.
     *
     * @return void
     */
    public function testClickingInLinkShowToolbar()
    {
        $this->useTest(2);

        $this->moveToKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');

        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>Link test %1% test</p>');

    }//end testClickingInLinkShowToolbar()


    /**
     * Test that clicking inside a link tag that has bold format will show the inline toolbar.
     *
     * @return void
     */
    public function testClickBoldLinkShowsInlineToolbar()
    {
        $this->useTest(3);

        // Test single word
        $this->moveToKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');

        // Test two words
        $this->moveToKeyword(2);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->moveToKeyword(3);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');

    }//end testClickBoldLinkShowsInlineToolbar()


    /**
     * Test that clicking inside a link tag that has italic format will show the inline toolbar.
     *
     * @return void
     */
    public function testClickItalicLinkShowsInlineToolbar()
    {
        $this->useTest(4);

        // Test single word
        $this->moveToKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');

        // Test two words
        $this->moveToKeyword(2);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->moveToKeyword(3);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');

    }//end testClickItalicLinkShowsInlineToolbar()


    /**
     * Test that the text in the link is selected when you click on the link icon.
     *
     * @return void
     */
    public function testLinkIsSelectedWhenClickingOnLinkIcon()
    {
        $this->useTest(2);

        $this->moveToKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->assertEquals($this->getKeyword(1), $this->getSelectedText(), 'Original selection is still not selected.');

        $this->moveToKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->assertEquals($this->getKeyword(1), $this->getSelectedText(), 'Original selection is still not selected.');


    }//end testLinkIsSelectedWhenClickingOnLinkIcon()


     /**
     * Test that the inline toolbar doesn't appear after you close the link window and click in some text in the paragraph below it.
     *
     * @return void
     */
    public function testInlineToolbarDoesNotAppearAfterClosingLinkWindow()
    {
        $this->useTest(1);

        // Open and close the link window in the top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        sleep(1);
        $this->clickTopToolbarButton('link', 'selected');

        $this->moveToKeyword(2);
        sleep(1);

        // Check that the inline toolbar doesn't appear on the screen
        $inlineToolbarFound = true;
        try
        {
            var_dump($this->getInlineToolbar());ob_flush();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }

        $this->assertFalse($inlineToolbarFound, 'The inline toolbar was found');

    }//end testInlineToolbarDoesNotAppearAfterClosingLinkWindow()


    /**
     * Test that fields that are required when adding a link appear as required.
     *
     * @return void
     */
    public function testRequiredFieldsWhenAddingALink()
    {
        // Test using inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->clickField('Title');
        sleep(1);
        $this->clickField('URL', true);
        $this->type('http://www.squizlabs.com');
        $this->clickinlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Link test <a href="http://www.squizlabs.com">%1%</a> test %2%</p>');

        // Test using top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->clickField('Title');
        sleep(1);
        $this->clickField('URL', true);
        $this->type('http://www.squizlabs.com');
        $this->clicktopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Link test <a href="http://www.squizlabs.com">%1%</a> test %2%</p>');

    }//end testRequiredFieldsWhenAddingALink()


    /**
     * Test that fields that are required when adding a link appear as required.
     *
     * @return void
     */
    public function testRequiredFieldsWhenModifyingALink()
    {
        // Test using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active'); 
        $this->clearFieldValue('Title');
        $this->clearFieldValue('URL');
        sleep(1);
        $this->clickField('Title');
        $this->type('test');
        $this->clickField('URL', true);
        $this->type('http://www.squizlabs.com');
        $this->clickinlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Link test <a href="http://www.squizlabs.com" title="test">%1%</a> test</p>');

        // Test using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('Title');
        $this->clearFieldValue('URL');
        sleep(1);
        $this->clickField('Title');
        $this->type('test');
        $this->clickField('URL', true);
        $this->type('http://www.squizlabs.com');
        $this->clicktopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Link test <a href="http://www.squizlabs.com" title="test">%1%</a> test</p>');

    }//end testRequiredFieldsWhenModifyingALink()

}//end class

?>
