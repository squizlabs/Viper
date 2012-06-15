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
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% <a href="http://www.squizlabs.com">%3%</a></p><p>sit %4% <strong>%5%</strong></p>');

    }//end testCreateLinkPlainTextUsingInlineToolbar()


    /**
     * Test that the link icon appears in the inline toolbar after applying and deleting a link twice.
     *
     * @return void
     */
    public function testLinkIconAppearsInInlineToolbarAfterDeletingLinkTwice()
    {
        $this->selectKeyword(1, 2);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1% %2%</a> %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($this->findKeyword(3));
        $this->click($this->findKeyword(2));
        $this->clickInlineToolbarButton('linkRemove');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->selectKeyword(1);
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1% %2%</a> %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($this->findKeyword(3));
        $this->click($this->findKeyword(2));
        $this->clickInlineToolbarButton('linkRemove');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->selectKeyword(1);
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Toolbar button icon is not correct');

    }//end testLinkIconAppearsInInlineToolbarAfterDeletingLink()


    /**
     * Test that a link can be created for a selected text using the top toolbar.
     *
     * @return void
     */
    public function testCreateLinkUsingTopToolbar()
    {
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $updateChangesButton = $this->find('Update Changes', NULL, TRUE);
        $this->click($updateChangesButton);

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% <a href="http://www.squizlabs.com">%3%</a></p><p>sit %4% <strong>%5%</strong></p>');

    }//end testCreateLinkUsingTopToolbar()


    /**
     * Test that a link with title can be created for a selected text.
     *
     * @return void
     */
    public function testCreateLinkPlainTextWithTitle()
    {
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>',
            '<p><a title="Squiz Labs" href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>'
        );

    }//end testCreateLinkPlainTextWithTitle()


    /**
     * Test that a link that will open in a new window will be created when you use the inline toolbar.
     *
     * @return void
     */
    public function testCreateLinkThatOpensInNewWindowUsingInlineToolbar()
    {
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>',
            '<p><a target="_blank" title="Squiz Labs" href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>'
        );

        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $updateChangesButton = $this->find('Update Changes', NULL, TRUE);
        $this->click($updateChangesButton);

        $this->assertHTMLMatch(
            '<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a> %2% <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%3%</a></p><p>sit %4% <strong>%5%</strong></p>',
            '<p><a target="_blank" title="Squiz Labs" href="http://www.squizlabs.com">%1%</a> %2% <a target="_blank" title="Squiz Labs" href="http://www.squizlabs.com">%3%</a></p><p>sit %4% <strong>%5%</strong></p>'
        );

    }//end testCreateLinkThatOpensInNewWindowUsingInlineToolbar()


    /**
     * Test that a link that will open in a new window will be created when you use the top toolbar.
     *
     * @return void
     */
    public function testCreateLinkThatOpensInNewWindowUsingTopToolbar()
    {
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>',
            '<p><a target="_blank" title="Squiz Labs" href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>'
        );

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $updateChangesButton = $this->find('Update Changes', NULL, TRUE);
        $this->click($updateChangesButton);

        $this->assertHTMLMatch(
            '<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a> %2% <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%3%</a></p><p>sit %4% <strong>%5%</strong></p>',
            '<p><a target="_blank" title="Squiz Labs" href="http://www.squizlabs.com">%1%</a> %2% <a target="_blank" title="Squiz Labs" href="http://www.squizlabs.com">%3%</a></p><p>sit %4% <strong>%5%</strong></p>'
        );

    }//end testCreateLinkThatOpensInNewWindowUsingInlineToolbar()


    /**
     * Test that selecting a link shows the correct Viper tools.
     *
     * @return void
     */
    public function testSelectLinkTag()
    {
        $this->selectKeyword(2);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>%1% <a href="http://www.squizlabs.com" title="Squiz Labs">%2%</a> %3%</p><p>sit %4% <strong>%5%</strong></p>',
            '<p>%1% <a title="Squiz Labs" href="http://www.squizlabs.com">%2%</a> %3%</p><p>sit %4% <strong>%5%</strong></p>'
        );

        $this->selectKeyword(2);
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Toolbar button icon is not correct');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Link</li>', $lineage);

    }//end testSelectLinkTag()


    /**
     * Test that clicking inside a link tag will show the inline toolbar and select the whole link.
     *
     * @return void
     */
    public function testSelectPartialLink()
    {
        $this->selectKeyword(2);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($this->findKeyword(1));
        $this->click($this->findKeyword(2));
        $this->keyDown('Key.SHIFT + Key.RIGHT');

        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');

        $this->clickInlineToolbarButton('linkRemove');
        $this->click($this->findKeyword(1));
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

    }//end testSelectPartialLink()


    /**
     * Test that selecting a whole node (e.g. strong tag) shows the correct Viper tools and link can be applied to it.
     *
     * @return void
     */
    public function testSelectNodeThenCreateLink()
    {
        $this->selectKeyword(5);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>%1% %2% %3%</p><p>sit %4% <strong><a href="http://www.squizlabs.com" title="Squiz Labs">%5%</a></strong></p>',
            '<p>%1% %2% %3%</p><p>sit %4% <strong><a title="Squiz Labs" href="http://www.squizlabs.com">%5%</a></strong></p>'
        );

    }//end testSelectNodeThenCreateLink()


    /**
     * Test that selecting nodes with different parents will not show link icon.
     *
     * @return void
     */
    public function testSelectMultiParentNoLink()
    {
        $this->selectKeyword(4, 5);

        $this->assertFalse($this->inlineToolbarButtonExists('link'), 'Link icon should not be available.');
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Link icon should not be available.');

    }//end testSelectMultiParentNoLink()


    /**
     * Test that a link can be removed when you select the text.
     *
     * @return void
     */
    public function testRemoveLinkWhenSelectingText()
    {
        $text = $this->findKeyword(2);
        $this->selectKeyword(1);

        // Normal link
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');
        $this->click($text);
        $this->selectKeyword(1);

        // Move the pointer away from link to prevent tooltip.
        $this->mouseMoveOffset(50, 50);

        $this->clickInlineToolbarButton('linkRemove');
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should not be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon should be available.');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        // Mail to link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');
        $this->click($text);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should not be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link'), 'Link icon should be available.');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

    }//end testRemoveLinkWhenSelectingText()


    /**
     * Test that a link can be removed when you click inside the link.
     *
     * @return void
     */
    public function testRemoveLinkWhenClickingInLink()
    {
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
        $this->assertTrue($this->topToolbarButtonExists('link'), 'Link icon should be available.');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        // Mail to link
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');
        $this->click($this->findKeyword(3));
        $this->click($this->findKeyword(1));
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertTrue($this->topToolbarButtonExists('link'), 'Link icon should be available.');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

    }//end testRemoveLinkWhenClickingInLink()


    /**
     * Test that the remove link icon in the inline toolbar removes all links in a paragraph.
     *
     * @return void
     */
    public function testRemoveLinkInInlineToolbarForLinksInParagraph()
    {
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should not be available.');
        $this->assertHTMLMatch('<p>%5% %1% %3%</p><p>sit %4% test</p>');

        $this->clickTopToolbarButton('historyUndo');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should not be available.');
        $this->assertHTMLMatch('<p>%5% %1% %3%</p><p>sit %4% test</p>');

        $this->clickTopToolbarButton('historyUndo');

        $this->click($this->findKeyword(1));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should not be available.');
        $this->assertHTMLMatch('<p>%5% %1% %3%</p><p>sit %4% test</p>');


    }//end testRemoveLinkInInlineToolbarForLinksInParagraph()


    /**
     * Test that the remove link icon in the top toolbar removes all links in a paragraph.
     *
     * @return void
     */
    public function testRemoveLinkInTopToolbarForLinksInParagraph()
    {
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>%5% %1% %3%</p><p>sit %4% test</p>');

        $this->clickTopToolbarButton('historyUndo');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>%5% %1% %3%</p><p>sit %4% test</p>');

        $this->clickTopToolbarButton('historyUndo');

        $this->click($this->findKeyword(1));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>%5% %1% %3%</p><p>sit %4% test</p>');

    }//end testRemoveLinkInTopToolbarForLinksInParagraph()


    /**
     * Test that a URL can be edited using the inline toolbar
     *
     * @return void
     */
    public function testEditingTheURLFieldUsingTheInlineToolbar()
    {
        $text = $this->findKeyword(2);
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($text);
        $this->selectKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available in top toolbar.');

        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $updateChangesButton = $this->find('Update Changes', NULL, TRUE);
        $this->click($updateChangesButton);

        $this->assertHTMLMatch('<p><a href="http://www.google.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

    }//end testEditingTheURLFieldUsingTheInlineToolbar()


    /**
     * Test that you cannot delete a link using the x button in the toolbar
     *
     * @return void
     */
    public function testTryingToDeleteLinkUsingLinkIcon()
    {
        $text = $this->findKeyword(2);
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($text);
        $this->selectKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available in top toolbar.');

        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

    }//end testTryingToDeleteLinkUsingLinkIcon()


    /**
     * Test that a URL can be edited using the top toolbar
     *
     * @return void
     */
    public function testEditingTheURLFieldUsingTheTopToolbar()
    {
        $text = $this->findKeyword(2);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('link', 'selected');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($text);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $updateChangesButton = $this->find('Update Changes', NULL, TRUE);
        $this->click($updateChangesButton);

        $this->assertHTMLMatch('<p><a href="http://www.google.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

    }//end testEditingTheURLFieldUsingTheTopToolbar()


    /**
     * Test that you can add and edit a title using the inline toolbar
     *
     * @return void
     */
    public function testAddingAndEditingTheTitleUsingInlineToolbar()
    {
        $text = $this->findKeyword(2);
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($text);
        $this->selectKeyword(1);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available in top toolbar.');

        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('title');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="title">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($text);
        $this->selectKeyword(1);
        $this->mouseMoveOffset(50, 50);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('abc');
        $updateChangesButton = $this->find('Update Changes', NULL, TRUE);
        $this->click($updateChangesButton);

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="abc">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

    }//end testAddingAndEditingTheTitleUsingInlineToolbar()


    /**
     * Test that you can add and edit a title using the top toolbar
     *
     * @return void
     */
    public function testAddingAndEditingTheTitleUsingTopToolbar()
    {
        $text = $this->findKeyword(2);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('link', 'selected');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($text);
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('title');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('link', 'selected');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="title">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($text);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('abc');
        $updateChangesButton = $this->find('Update Changes', NULL, TRUE);
        $this->click($updateChangesButton);

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="abc">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

    }//end testAddingAndEditingTheTitleUsingTopToolbar()


    /**
     * Test that clicking inside a link tag will show the inline toolbar and select the whole link.
     *
     * @return void
     */
    public function testClickShowInlineToolbar()
    {
        $text = $this->findKeyword(1);
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');
        $this->click($this->findKeyword(2));

        sleep(1);
        $this->click($text);
        sleep(1);
        $this->click($text);

        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be available.');

    }//end testClickShowInlineToolbar()


    /**
     * Test that clicking inside a link tag that has bold format will show the inline toolbar.
     *
     * @return void
     */
    public function testClickBoldLinkShowsInlineToolbar()
    {
        $text = $this->findKeyword(1);
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('bold');
        $this->click($this->findKeyword(2));

        sleep(1);
        $this->click($text);

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
        $text = $this->findKeyword(1);
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('italic');
        $this->click($this->findKeyword(2));

        sleep(1);
        $this->click($text);

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
        $this->selectKeyword(3);

        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton('anchorID');
        $this->type('anchor');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>%1% %2% <a href="http://www.squizlabs.com" class="class" id="anchor">%3%</a></p><p>sit %4% <strong>%5%</strong></p>',
            '<p>%1% %2% <a id="anchor" class="class" href="http://www.squizlabs.com">%3%</a></p><p>sit %4% <strong>%5%</strong></p>');

        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be active in the inline toolbar.');
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
        $text = 3;
        $this->selectKeyword($text);

        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton('anchorID');
        $this->type('anchor');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% %2% <a href="http://www.squizlabs.com" class="class" id="anchor">%3%</a></p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($this->find($text));
        $this->selectKeyword($text);
        $this->clickInlineToolbarButton('linkRemove');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

    }//end testClassAndIdAreRemovedWhenLinkIsRemoved()


    /**
     * Test that the class and id tags are added to the a tag when you re-select the content and create a link.
     *
     * @return void
     */
    public function testClassAndIdAreAddedToLinkTagAfterReselect()
    {
        $text = 3;

        $this->selectKeyword($text);

        $this->clickInlineToolbarButton('cssClass');
        $this->type('class');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton('anchorID');
        $this->type('anchor');
        $this->keyDown('Key.ENTER');

        $this->click($this->find($text));
        $this->selectKeyword($text);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>%1% %2% <a href="http://www.squizlabs.com" class="class" id="anchor">%3%</a></p><p>sit %4% <strong>%5%</strong></p>',
            '<p>%1% %2% <a id="anchor" class="class" href="http://www.squizlabs.com">%3%</a></p><p>sit %4% <strong>%5%</strong></p>');

        $this->assertTrue($this->inlineToolbarButtonExists('link', 'active'), 'Link icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar.');

        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon should be active in the top toolbar.');

        $this->assertTrue($this->inlineToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('anchorID', 'active'), 'Anchor icon should be active in the top toolbar.');

    }//end testClassAndIdAreAddedToLinkTagAfterReselect()


    /**
     * Test that the selection is maintained when you click on the link icon.
     *
     * @return void
     */
    public function testSelectionIsMaintainedWhenYouClickOnLinkIcon()
    {
        $text = 3;

        $this->selectKeyword($text);
        $this->clickInlineToolbarButton('link');
        $this->assertEquals($this->getKeyword($text), $this->getSelectedText(), 'Original selection is still not selected.');

        $this->click($this->find($text));

        $this->selectKeyword($text);
        $this->clickTopToolbarButton('link');
        $this->assertEquals($this->getKeyword($text), $this->getSelectedText(), 'Original selection is still not selected.');


    }//end testSelectionIsMaintainedWhenYouClickOnLineIcon()


    /**
     * Test that clicking undo puts a link back correctly after you remove it.
     *
     * @return void
     */
    public function testClickingUndoPutLinkBackCorrectlyAfterItHasBeenRemoved()
    {
        $textLoc = $this->findKeyword(3);
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($textLoc);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->click($textLoc);
        sleep(1);
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($textLoc);
        $this->click($this->findKeyword(1));
        $this->clickInlineToolbarButton('linkRemove');
        $this->click($textLoc);
        sleep(1);
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

    }//end testClickingUndoPutLinkBackCorrectlyAfterItHasBeenRemoved()


    /**
     * Test creating and removing links in a paragraph.
     *
     * @return void
     */
    public function testCreateAndRemoveLinksForParagraph()
    {
        // Check that remove link is disabled for a paragraph without links
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should not appear in the inline toolbar.');

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.google.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% <a href="http://www.google.com">%3%</a></p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('linkRemove'), 'Remove link icon should appear in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should appear in the inline toolbar.');

        $this->clickInlineToolbarButton('linkRemove');
        $this->assertEquals($this->replaceKeywords('%1% %2% %3%'), $this->getSelectedText(), 'Paragraph is not selected.');
        //$this->click($this->findKeyword(2));
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        // Undo so we can use the remove link in the top toolbar
        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> %2% <a href="http://www.google.com">%3%</a></p><p>sit %4% <strong>%5%</strong></p>');

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertEquals($this->replaceKeywords('%1% %2% %3%'), $this->getSelectedText(), 'Paragraph is not selected.');
        $this->click($this->findKeyword(2));
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

    }//end testCreateLinkPlainTextUsingInlineToolbar()


    /**
     * Test link icon appears in the inline toolbar for acronym and abbreviation.
     *
     * @return void
     */
    public function testLinkIconForAcronymAndAbbreviation()
    {
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
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');

        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('link');
        $this->type('mailto: labs@squiz.com.au');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">%1%</a> %2% <a href="mailto:labs@squiz.com.au">%3%</a></p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($this->findKeyword(2));

        $this->selectKeyword(5);
        $this->clickInlineToolbarButton('link');
        $this->type('MAILTO: labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">%1%</a> %2% <a href="mailto:labs@squiz.com.au">%3%</a></p><p>sit %4% <strong><a href="mailto:labs@squiz.com.au">%5%</a></strong></p>');

    }//end testCreatingAMailToLinkUsingTheInlineToolbar()


    /**
     * Test creating a mail to link with a subject using the inline toolbar.
     *
     * @return void
     */
    public function testCreatingAMailToLinkWithSubjectUsingTheInlineToolbar()
    {
        $this->selectKeyword(1);

        $this->clickInlineToolbarButton('link');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');

        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('link');
        $this->type('mailto: labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> %2% <a href="mailto:labs@squiz.com.au?subject=Subject">%3%</a></p><p>sit %4% <strong>%5%</strong></p>');

        $this->click($this->findKeyword(2));

        $this->selectKeyword(5);
        $this->clickInlineToolbarButton('link');
        $this->type('MAILTO: labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> %2% <a href="mailto:labs@squiz.com.au?subject=Subject">%3%</a></p><p>sit %4% <strong><a href="mailto:labs@squiz.com.au?subject=Subject">%5%</a></strong></p>');

    }//end testCreatingAMailToLinkWithSubjectUsingTheInlineToolbar()


    /**
     * Test entering a mailto link, pressing enter and then adding a subject.
     *
     * @return void
     */
    public function testEnteringMailToLinkPressEnterThenEnterSubject()
    {
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('Test');sleep(1);
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);

        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> %2% <a href="mailto:labs@squiz.com.au?subject=Test">%3%</a></p><p>sit %4% <strong>%5%</strong></p>');

    }//end testEnteringMailToLinkPressEnterThenEnterSubject()


    /**
     * Test creating a mail to link without a subject using the top toolbar.
     *
     * @return void
     */
    public function testCreatingAMailToLinkUsingTheTopToolbar()
    {
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');

        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('link', 'selected');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('link');
        $this->type('mailto: labs@squiz.com.au');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">%1%</a> %2% <a href="mailto:labs@squiz.com.au">%3%</a></p><p>sit %4% <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('link', 'selected');

        $this->selectKeyword(5);
        $this->clickTopToolbarButton('link');
        $this->type('MAILTO: labs@squiz.com.au');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">%1%</a> %2% <a href="mailto:labs@squiz.com.au">%3%</a></p><p>sit %4% <strong><a href="mailto:labs@squiz.com.au">%5%</a></strong></p>');

    }//end testCreatingAMailToLinkUsingTheTopToolbar()


    /**
     * Test creating a mail to link with a subject using the top toolbar.
     *
     * @return void
     */
    public function testCreatingAMailToLinkWithSubjectUsingTheTopToolbar()
    {
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('link');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');

        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('link', 'selected');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('link');
        $this->type('mailto: labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> %2% <a href="mailto:labs@squiz.com.au?subject=Subject">%3%</a></p><p>sit %4% <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('link', 'selected');

        $this->selectKeyword(5);
        $this->clickTopToolbarButton('link');
        $this->type('MAILTO: labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->clickTopToolbarButton('Update Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> %2% <a href="mailto:labs@squiz.com.au?subject=Subject">%3%</a></p><p>sit %4% <strong><a href="mailto:labs@squiz.com.au?subject=Subject">%5%</a></strong></p>');

    }//end testCreatingAMailToLinkWithSubjectUsingTheTopToolbar()


    /**
     * Test that the subject field only appears when you are creating a mailto link.
     *
     * @return void
     */
    public function testSubjectOnlyAppearsWhenCreatingAMailToLink()
    {

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> %2% %3%</p><p>sit %4% <strong>%5%</strong></p>');

        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('link');
        $this->assertFalse($this->fieldExists('Subject'));

        $this->click($this->findKeyword(2));

        $this->selectKeyword(5);
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
        $this->click($this->find('labs'));
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.CMD + c');
        $this->clickTopToolbarButton('link');
        $this->keyDown('Key.CMD + v');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">labs@squiz.com.au</a></p>');

    }//end testCopyAndPasteMailtoLink()


    /**
     * Test inserting and removing a link for an image using the inline toolbar.
     *
     * @return void
     */
    public function testLinkingAnImageUsingInlineToolbar()
    {
        $this->clickElement('img', 1);
        $this->clickInlineToolbarButton('link');
        $this->type('www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% XuT</p><p><a href="www.squizlabs.com" title="Squiz Labs"><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></a></p><p>LABS is ORSM</p>');

        $this->click($this->findKeyword(1));

        $this->clickElement('img', 1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>%1% XuT</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>LABS is ORSM</p>');

    }//end testLinkingAnImageUsingInlineToolbar()


    /**
     * Test inserting and removing a link for an image using the top toolbar.
     *
     * @return void
     */
    public function testLinkingAnImageUsingTopToolbar()
    {
        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('link');
        $this->type('www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% XuT</p><p><a href="www.squizlabs.com" title="Squiz Labs"><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></a></p><p>LABS is ORSM</p>');

        $this->click($this->findKeyword(1));

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>%1% XuT</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>LABS is ORSM</p>');

    }//end testLinkingAnImageUsingTopToolbar()


}//end class

?>
