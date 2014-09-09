<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLinkPlugin_UpdateChangesButtonForLinkUnitTest extends AbstractViperUnitTest
{
    /**
     * Test that the Apply Changes button is inactive for a new selection after you click away from a previous selection.
     *
     * @return void
     */
    public function testApplyChangesButtonWhenClickingAwayFromLinkPopUp()
    {
        // Using the inline toolbar
        $this->useTest(1);

        // Start creating the link for the first selection
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');

        // Click away from the link by selecting a new selection
        $this->selectKeyword(2);

        // Make sure the link was not created
        $this->assertHTMLMatch('<p>Link test %1%</p><p>test</p><p>test again</p><p>test yet again</p><p>another paragraph</p><p>The last paragraph in this content on the page %2%</p>');

        $this->clickInlineToolbarButton('link');

        // Check icons
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE));

        $this->type('http://www.squizlabs.com');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Link test %1%</p><p>test</p><p>test again</p><p>test yet again</p><p>another paragraph</p><p>The last paragraph in this content on the page <a href="http://www.squizlabs.com">%2%</a></p>');

        // Using the top toolbar
        $this->useTest(1);

        // Start creating the link for the first selection
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');

        // Click away from the link by selecting a new selection
        $this->selectKeyword(2);

        // Make sure the link was not created
        $this->assertHTMLMatch('<p>Link test %1%</p><p>test</p><p>test again</p><p>test yet again</p><p>another paragraph</p><p>The last paragraph in this content on the page %2%</p>');

        $this->clickTopToolbarButton('link');

        // Check icons
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'));
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE));

        $this->type('http://www.squizlabs.com');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Link test %1%</p><p>test</p><p>test again</p><p>test yet again</p><p>another paragraph</p><p>The last paragraph in this content on the page <a href="http://www.squizlabs.com">%2%</a></p>');

    }//end testApplyChangesButtonWhenClickingAwayFromLinkPopUp()


    /**
     * Test that the Apply Changes button is inactive for a new selection after you close the link pop without saving the changes.
     *
     * @return void
     */
    public function testApplyChangesButtonWhenClosingTheLinkPopUp()
    {
        // Using the inline toolbar
        $this->useTest(1);

        // Start creating the link for the first selection
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');

        // Close pop up without saving changes and make new select
        $this->clickInlineToolbarButton('link', 'selected');
        $this->selectKeyword(2);

        // Make sure the link was not created
        $this->assertHTMLMatch('<p>Link test %1%</p><p>test</p><p>test again</p><p>test yet again</p><p>another paragraph</p><p>The last paragraph in this content on the page %2%</p>');

        $this->clickInlineToolbarButton('link');

        // Check icons
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE));

        $this->type('http://www.squizlabs.com');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Link test %1%</p><p>test</p><p>test again</p><p>test yet again</p><p>another paragraph</p><p>The last paragraph in this content on the page <a href="http://www.squizlabs.com">%2%</a></p>');

        // Using the top toolbar
        $this->useTest(1);

        // Start creating the link for the first selection
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');

        // Close pop up without saving changes and make new select
        $this->clickTopToolbarButton('link', 'selected');
        $this->selectKeyword(2);

        // Make sure the link was not created
        $this->assertHTMLMatch('<p>Link test %1%</p><p>test</p><p>test again</p><p>test yet again</p><p>another paragraph</p><p>The last paragraph in this content on the page %2%</p>');

        $this->clickTopToolbarButton('link');

        // Check icons
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'));
        $this->assertTrue($this->topToolbarButtonExists('Apply Changes', 'disabled', TRUE));

        $this->type('http://www.squizlabs.com');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p>Link test %1%</p><p>test</p><p>test again</p><p>test yet again</p><p>another paragraph</p><p>The last paragraph in this content on the page <a href="http://www.squizlabs.com">%2%</a></p>');

    }//end testApplyChangesButtonWhenClickingAwayFromLinkPopUp()


    /**
     * Test that the Apply Changes button is inactive iafter you cancel changes to a link.
     *
     * @return void
     */
    public function testApplyChangesButtonIsDisabledAfterCancellingChangesToALink()
    {
        // Using the inline toolbar
        $this->useTest(2);

        // Select link and make changes without saving
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->type('.com');
        $this->selectKeyword(2);

        // Check to make sure the HTML did not change.
        $this->assertHTMLMatch('<p>Link test <a href="http://www.squizlabs">%1%</a></p><p>test</p><p>test again</p><p>test yet again</p><p>another paragraph</p><p>The last paragraph in this content on the page %2%</p>');

        // Select the link again and make sure the Apply Changes button is inactive
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE), 'Update changes button should be disabled');

        // Edit the link and make sure the Apply Changes button still works.
        $this->type('.com');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Link test <a href="http://www.squizlabs.com">%1%</a></p><p>test</p><p>test again</p><p>test yet again</p><p>another paragraph</p><p>The last paragraph in this content on the page %2%</p>');

        // Using the top toolbar
        $this->useTest(2);

        // Select link and make changes without saving
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->type('.com');
        $this->selectKeyword(2);

        // Check to make sure the HTML did not change.
        $this->assertHTMLMatch('<p>Link test <a href="http://www.squizlabs">%1%</a></p><p>test</p><p>test again</p><p>test yet again</p><p>another paragraph</p><p>The last paragraph in this content on the page %2%</p>');

        // Select the link again and make sure the Apply Changes button is inactive
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('Apply Changes', 'disabled', TRUE), 'Update changes button should be disabled');

        // Edit the link and make sure the Apply Changes button still works.
        $this->type('.com');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Link test <a href="http://www.squizlabs.com">%1%</a></p><p>test</p><p>test again</p><p>test yet again</p><p>another paragraph</p><p>The last paragraph in this content on the page %2%</p>');

    }//end testApplyChangesButtonIsDisabledAfterCancellingChangesToALink()

}//end class

?>