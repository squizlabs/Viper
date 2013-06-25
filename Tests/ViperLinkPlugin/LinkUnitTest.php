<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLinkPlugin_LinkUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that a link can be created for a selected text using the inline toolbar.
     *
     * @return void
     */
    public function testCreateLinkPlainTextUsingInlineToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test %2%</p>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test <a href="http://www.squizlabs.com">%2%</a></p>');

    }//end testCreateLinkPlainTextUsingInlineToolbar()


    /**
     * Test that the link icon appears in the inline toolbar after applying and deleting a link twice.
     *
     * @return void
     */
    public function testLinkIconAppearsInInlineToolbarAfterDeletingLinkTwice()
    {
        $this->useTest(5);

        $this->selectKeyword(1, 2);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Link test <a href="http://www.squizlabs.com">%1% <strong>%2%</strong></a></p>');

        $this->click($this->findKeyword(2));
        $this->clickInlineToolbarButton('linkRemove');

        $this->assertHTMLMatch('<p>Link test %1% <strong>%2%</strong></p>');

        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Link test <a href="http://www.squizlabs.com">%1% <strong>%2%</strong></a></p>');

        $this->click($this->findKeyword(2));
        $this->clickInlineToolbarButton('linkRemove');

        $this->assertHTMLMatch('<p>Link test %1% <strong>%2%</strong></p>');

        $this->selectKeyword(1, 2);
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Toolbar button icon is not correct');

    }//end testLinkIconAppearsInInlineToolbarAfterDeletingLink()


    /**
     * Test that a link can be created for a selected text using the top toolbar.
     *
     * @return void
     */
    public function testCreateLinkUsingTopToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test %2%</p>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test <a href="http://www.squizlabs.com">%2%</a></p>');

    }//end testCreateLinkUsingTopToolbar()


    /**
     * Test that a link with title can be created for a selected text.
     *
     * @return void
     */
    public function testCreateLinkPlainTextWithTitle()
    {
        $this->useTest(1);

        // Test inline toolbar
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> link test %2%</p>');

        // Test top toolbar
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> link test <a href="http://www.squizlabs.com" title="Squiz Labs">%2%</a></p>');

    }//end testCreateLinkPlainTextWithTitle()


    /**
     * Test that a link that will open in a new window will be created when you use the inline toolbar.
     *
     * @return void
     */
    public function testCreateLinkThatOpensInNewWindowUsingInlineToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a> link test %2%</p>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a> link test <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%2%</a></p>');

    }//end testCreateLinkThatOpensInNewWindowUsingInlineToolbar()


    /**
     * Test that a link that will open in a new window will be created when you use the top toolbar.
     *
     * @return void
     */
    public function testCreateLinkThatOpensInNewWindowUsingTopToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a> link test %2%</p>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a> link test <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%2%</a></p>');

    }//end testCreateLinkThatOpensInNewWindowUsingTopToolbar()


    /**
     * Test that selecting a link shows the correct Viper tools.
     *
     * @return void
     */
    public function testSelectLinkTag()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->selectKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be active in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> link test %2%</p>');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Link</li>', $lineage);

    }//end testSelectLinkTag()


    /**
     * Test that clicking inside a link tag will show the inline toolbar and select the whole link.
     *
     * @return void
     */
    public function testSelectPartialLinkShowsToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(2);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(2));
        $this->keyDown('Key.SHIFT + Key.RIGHT');

        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');

        $this->clickInlineToolbarButton('linkRemove');
        $this->click($this->findKeyword(1));
        $this->assertHTMLMatch('<p>%1% link test %2%</p>');

    }//end testSelectPartialLinkShowsToolbar()


    /**
     * Test that clicking inside a link tag will show the inline toolbar.
     *
     * @return void
     */
    public function testClickingInLinkShowToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(2));
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');

        $this->clickInlineToolbarButton('linkRemove');
        $this->click($this->findKeyword(1));
        $this->assertHTMLMatch('<p>%1% link test %2%</p>');

    }//end testClickingInLinkShowToolbar()


    /**
     * Test that selecting a whole node (e.g. strong tag) shows the correct Viper tools and link can be applied to it.
     *
     * @return void
     */
    public function testSelectNodeThenCreateLink()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>%1% link test <strong>%2%</strong></p>');

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% link test <strong><a href="http://www.squizlabs.com" title="Squiz Labs">%2%</a></strong></p>');

    }//end testSelectNodeThenCreateLink()


    /**
     * Test that selecting nodes with different parents but in same block parent will show link icon.
     *
     * @return void
     */
    public function testSelectMultiParentLink()
    {
        $this->useTest(5);

        $this->selectKeyword(1, 2);

        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon should be available.');

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Link test <a href="http://www.squizlabs.com" title="Squiz Labs">%1% <strong>%2%</strong></a></p>');

    }//end testSelectMultiParentLink()


    /**
     * Test that a link can be removed when you select the text.
     *
     * @return void
     */
    public function testRemoveLinkWhenSelectingText()
    {
        $this->useTest(1);

        // Normal link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);

        // Move the pointer away from link to prevent tooltip.
        $this->mouseMoveOffset(50, 50);

        $this->clickInlineToolbarButton('linkRemove');
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should not be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon should be available.');
        $this->assertHTMLMatch('<p>%1% link test %2%</p>');

        // Mail to link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should not be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon should be available.');
        $this->assertHTMLMatch('<p>%1% link test %2%</p>');

    }//end testRemoveLinkWhenSelectingText()


    /**
     * Test that a link can be removed when you click inside the link.
     *
     * @return void
     */
    public function testRemoveLinkWhenClickingInLink()
    {
        $this->useTest(1);

        // Normal link
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');
        $this->click($this->findKeyword(1));
        $this->click($this->findKeyword(2));
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'), 'Link icon should be disabled.');
        $this->assertHTMLMatch('<p>%1% link test %2%</p>');

        // Mail to link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');
        $this->click($this->findKeyword(1));
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertTrue($this->topToolbarButtonExists('link', 'disabled'), 'Link icon should be disabled.');
        $this->assertHTMLMatch('<p>%1% link test %2%</p>');

    }//end testRemoveLinkWhenClickingInLink()


    /**
     * Test that a link can be removed when have the link fields open in the inline toolbar.
     *
     * @return void
     */
    public function testRemoveLinkWhenLinkFieldsAreOpen()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        // Click in link, open fields and remove link
        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(1));
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Link icon should still be selected in the inline toolbar');
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should not be available in the inline toolbar');
        $this->assertHTMLMatch('<p>%1% link test %2%</p>');

    }//end testRemoveLinkWhenLinkFieldsAreOpen()


    /**
     * Test that a URL can be edited using the inline toolbar
     *
     * @return void
     */
    public function testEditingTheURLFieldUsingTheInlineToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available in top toolbar.');

        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p><a href="http://www.google.com">%1%</a> link test %2%</p>');

    }//end testEditingTheURLFieldUsingTheInlineToolbar()


    /**
     * Test that you cannot delete a link using the x button in the toolbar
     *
     * @return void
     */
    public function testTryingToDeleteLinkUsingLinkIcon()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available in top toolbar.');

        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test %2%</p>');

    }//end testTryingToDeleteLinkUsingLinkIcon()


    /**
     * Test that a URL can be edited using the top toolbar
     *
     * @return void
     */
    public function testEditingTheURLFieldUsingTheTopToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('link', 'selected');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p><a href="http://www.google.com">%1%</a> link test %2%</p>');

    }//end testEditingTheURLFieldUsingTheTopToolbar()


    /**
     * Test that you can add and edit a title using the inline toolbar
     *
     * @return void
     */
    public function testAddingAndEditingTheTitleUsingInlineToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available in top toolbar.');

        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('title');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="title">%1%</a> link test %2%</p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->mouseMoveOffset(50, 50);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('abc');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="titleabc">%1%</a> link test %2%</p>');

    }//end testAddingAndEditingTheTitleUsingInlineToolbar()


    /**
     * Test that you can add and edit a title using the top toolbar
     *
     * @return void
     */
    public function testAddingAndEditingTheTitleUsingTopToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('title');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="title">%1%</a> link test %2%</p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('abc');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="titleabc">%1%</a> link test %2%</p>');

    }//end testAddingAndEditingTheTitleUsingTopToolbar()


    /**
     * Test that clicking inside a link tag that has bold format will show the inline toolbar.
     *
     * @return void
     */
    public function testClickBoldLinkShowsInlineToolbar()
    {
        $this->useTest(5);

        // Test single word
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(1));
        $this->click($this->findKeyword(2));
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be available.');

        $this->clickInlineToolbarButton('linkRemove');

        // Test two words
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(1));
        $this->click($this->findKeyword(2));
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be available.');

    }//end testClickBoldLinkShowsInlineToolbar()


    /**
     * Test that clicking inside a link tag that has italic format will show the inline toolbar.
     *
     * @return void
     */
    public function testClickItalicLinkShowsInlineToolbar()
    {
        $this->useTest(5);

        $this->selectKeyword(2);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p>Link test %1% <em>%2%</em></p>');

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(1));
        $this->click($this->findKeyword(2));
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be available.');

        $this->clickInlineToolbarButton('linkRemove');

        // Test two words.
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(1));
        $this->click($this->findKeyword(2));
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be available.');

    }//end testClickItalicLinkShowsInlineToolbar()


    /**
     * Test that the class and id tags are added to the a tag when you create a link.
     *
     * @return void
     */
    public function testClassAndIdAreAddedToLinkTag()
    {
        $this->useTest(1);

        $this->selectKeyword(2);

        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton('anchorID');
        $this->type('anchor');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% link test <a href="http://www.squizlabs.com" class="class" id="anchor">%2%</a></p>');

        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Link icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar.');

        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the top toolbar.');

        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the top toolbar.');

    }//end testClassAndIdAreAddedToLinkTag()


    /**
     * Test that the class and id tags are removed when you remove the link.
     *
     * @return void
     */
    public function testClassAndIdAreRemovedWhenLinkIsRemoved()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton('anchorID');
        $this->type('anchor');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" class="class" id="anchor">%1%</a> link test %2%</p>');

        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(1));
        $this->clickInlineToolbarButton('linkRemove');

        $this->assertHTMLMatch('<p>%1% link test %2%</p>');

    }//end testClassAndIdAreRemovedWhenLinkIsRemoved()


    /**
     * Test that the class and id tags are added to the a tag when you re-select the content and create a link.
     *
     * @return void
     */
    public function testClassAndIdAreAddedToLinkTagAfterReselect()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton('anchorID');
        $this->type('anchor');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" class="class" id="anchor">%1%</a> link test %2%</p>');

        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Link icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar.');

        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the top toolbar.');

        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the top toolbar.');

    }//end testClassAndIdAreAddedToLinkTagAfterReselect()


    /**
     * Test that the text in the link is selected when you click on the link icon.
     *
     * @return void
     */
    public function testLinkIsSelectedWhenClickingOnLinkIcon()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(1));
        $this->clickInlineToolbarButton('link', 'active');
        $this->assertEquals($this->getKeyword(1), $this->getSelectedText(), 'Original selection is still not selected.');

        $this->click($this->findKeyword(2));

        $this->click($this->findKeyword(1));
        $this->clickTopToolbarButton('link', 'active');
        $this->assertEquals($this->getKeyword(1), $this->getSelectedText(), 'Original selection is still not selected.');


    }//end testLinkIsSelectedWhenClickingOnLinkIcon()


    /**
     * Test that clicking undo puts a link back correctly after you remove it.
     *
     * @return void
     */
    public function testClickingUndoPutLinkBackCorrectlyAfterItHasBeenRemoved()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test %2%</p>');

        $this->click($this->findKeyword(1));
        $this->clickInlineToolbarButton('linkRemove');
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test %2%</p>');

    }//end testClickingUndoPutLinkBackCorrectlyAfterItHasBeenRemoved()


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

        $this->click($this->findKeyword(2));

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
     * Test creating and removing links in a paragraph.
     *
     * @return void
     */
    public function testCreateAndRemoveLinksForParagraph()
    {
        $this->useTest(1);

        // Check that remove link is disabled for a paragraph without links
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should not appear in the inline toolbar.');

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.google.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test <a href="http://www.google.com">%2%</a></p>');

        // Remove links in paragraph using inline toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should appear in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should appear in the inline toolbar.');

        $this->clickInlineToolbarButton('linkRemove');
        $this->assertEquals($this->replaceKeywords('%1% link test %2%'), $this->getSelectedText(), 'Paragraph is not selected.');
        $this->assertHTMLMatch('<p>%1% link test %2%</p>');

        // Undo so we can use the remove link in the top toolbar
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test <a href="http://www.google.com">%2%</a></p>');

        // Remove links in parargraph using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertEquals($this->replaceKeywords('%1% link test %2%'), $this->getSelectedText(), 'Paragraph is not selected.');
        $this->assertHTMLMatch('<p>%1% link test %2%</p>');

    }//end testCreateLinkPlainTextUsingInlineToolbar()


    /**
     * Test link icon appears in the inline toolbar for acronym and abbreviation.
     *
     * @return void
     */
    public function testLinkIconForAcronymAndAbbreviation()
    {
        $this->useTest(2);

        $this->selectKeyword(2);
        $this->mouseMoveOffset(50, 50);
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon should appear in the inline toolbar.');
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should not appear in the inline toolbar.');
        $this->click($this->findKeyword(1));

        $this->selectKeyword(5);
        $this->mouseMoveOffset(50, 50);
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon should appear in the inline toolbar.');
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should not appear in the inline toolbar.');

    }//end testLinkIconForAcronymAndAbbreviation()


    /**
     * Test creating a mail to link without a subject using the inline toolbar.
     *
     * @return void
     */
    public function testCreatingAMailToLinkUsingTheInlineToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');

        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">%1%</a> link test %2%</p>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('mailto: labs@squiz.com.au');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">%1%</a> link test <a href="mailto:labs@squiz.com.au">%2%</a></p>');

    }//end testCreatingAMailToLinkUsingTheInlineToolbar()


    /**
     * Test creating a mail to link with a subject using the inline toolbar.
     *
     * @return void
     */
    public function testCreatingAMailToLinkWithSubjectUsingTheInlineToolbar()
    {

        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');

        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> link test %2%</p>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('mailto: labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> link test <a href="mailto:labs@squiz.com.au?subject=Subject">%2%</a></p>');

    }//end testCreatingAMailToLinkWithSubjectUsingTheInlineToolbar()


    /**
     * Test entering a mailto link, pressing enter and then adding a subject.
     *
     * @return void
     */
    public function testEnteringMailToLinkPressEnterThenEnterSubject()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->clickField('Subject');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> link test %2%</p>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->clickField('Subject');
        $this->type('Test');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> link test <a href="mailto:labs@squiz.com.au?subject=Test">%2%</a></p>');

    }//end testEnteringMailToLinkPressEnterThenEnterSubject()


    /**
     * Test creating a mail to link without a subject using the top toolbar.
     *
     * @return void
     */
    public function testCreatingAMailToLinkUsingTheTopToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');

        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">%1%</a> link test %2%</p>');
        $this->clickTopToolbarButton('link', 'selected');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('link');
        $this->type('mailto: labs@squiz.com.au');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">%1%</a> link test <a href="mailto:labs@squiz.com.au">%2%</a></p>');

    }//end testCreatingAMailToLinkUsingTheTopToolbar()


    /**
     * Test creating a mail to link with a subject using the top toolbar.
     *
     * @return void
     */
    public function testCreatingAMailToLinkWithSubjectUsingTheTopToolbar()
    {
        $this->useTest(1);

        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');

        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> link test %2%</p>');

        $this->clickTopToolbarButton('link', 'selected');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('link');
        $this->type('mailto: labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> link test <a href="mailto:labs@squiz.com.au?subject=Subject">%2%</a></p>');

    }//end testCreatingAMailToLinkWithSubjectUsingTheTopToolbar()


    /**
     * Test that the subject field only appears when you are creating a mailto link.
     *
     * @return void
     */
    public function testSubjectOnlyAppearsWhenCreatingAMailToLink()
    {

        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');

        $this->assertTrue($this->fieldExists('Subject'));
        $this->clickField('Subject');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> link test %2%</p>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->assertFalse($this->fieldExists('Subject'));

    }//end testSubjectOnlyAppearsWhenCreatingAMailToLink()


    /**
     * Test copying and pasting a mailto link.
     *
     * @return void
     */
    public function testCopyAndPasteMailtoLink()
    {
        $this->useTest(3);

        $this->click($this->findKeyword(1));
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.CMD + c');
        $this->clickTopToolbarButton('link');
        $this->keyDown('Key.CMD + v');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="mailto:%1%@squiz.com.au?subject=Subject">%1%@squiz.com.au</a></p>');

    }//end testCopyAndPasteMailtoLink()


    /**
     * Test inserting and removing a link for an image using the inline toolbar.
     *
     * @return void
     */
    public function testLinkingAnImageUsingInlineToolbar()
    {
        $this->useTest(4);

        $this->clickElement('img', 1);
        $this->clickInlineToolbarButton('link');
        $this->type('www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% XuT</p><a href="www.squizlabs.com" title="Squiz Labs"><img src="%url%/ViperImagePlugin/Images/html-codesniffer.png" alt="Alt tag" /></a><p>second paragraph</p>');

        $this->click($this->findKeyword(1));

        $this->clickElement('img', 1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>%1% XuT</p><img src="%url%/ViperImagePlugin/Images/html-codesniffer.png" alt="Alt tag" /><p>second paragraph</p>');

    }//end testLinkingAnImageUsingInlineToolbar()


    /**
     * Test inserting and removing a link for an image using the top toolbar.
     *
     * @return void
     */
    public function testLinkingAnImageUsingTopToolbar()
    {
        $this->useTest(4);

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('link');
        $this->type('www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% XuT</p><a href="www.squizlabs.com" title="Squiz Labs"><img src="%url%/ViperImagePlugin/Images/html-codesniffer.png" alt="Alt tag" /></a><p>second paragraph</p>');

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>%1% XuT</p><img src="%url%/ViperImagePlugin/Images/html-codesniffer.png" alt="Alt tag" /><p>second paragraph</p>');

    }//end testLinkingAnImageUsingTopToolbar()


    /**
     * Test undo and redo for link.
     *
     * @return void
     */
    public function testUndoAndRedoForLinks()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test %2%</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% link test %2%</p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test %2%</p>');

    }//end testUndoAndRedoForLinks()


    /**
     * Test that a link is automatically created when you type a URL in the content.
     *
     * @return void
     */
    public function testAutoCreatingLinks()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        // Press space after the link text
        $this->type('Some text http://www.squizlabs.com some text www.example.com ');
        $this->assertHTMLMatch('<p>%1% link test %2%</p><p>Some text <a href="http://www.squizlabs.com">http://www.squizlabs.com</a> some text <a href="http://www.example.com">www.example.com</a></p>');

        // Press enter after the link text
        $this->keyDown('Key.ENTER');
        $this->type('Third link http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');
        $this->type('Fourth link www.example.com');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>%1% link test %2%</p><p>Some text <a href="http://www.squizlabs.com">http://www.squizlabs.com</a> some text <a href="http://www.example.com">www.example.com</a></p><p>Third link <a href="http://www.squizlabs.com">http://www.squizlabs.com</a></p><p>Fourth link <a href="http://www.example.com">www.example.com</a></p>');

    }//end testAutoCreatingLinks()


}//end class

?>
