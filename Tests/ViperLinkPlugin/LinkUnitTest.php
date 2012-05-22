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
        $dir = dirname(__FILE__).'/Images/';
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_link_subActive.png'), 'Toolbar button icon is not correct');

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->selectText('dolor');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM <a href="http://www.squizlabs.com">dolor</a></p><p>sit amet <strong>WoW</strong></p>');

    }//end testCreateLinkPlainTextUsingInlineToolbar()


    /**
     * Test that the link icon appears in the inline toolbar after applying and deleting a link twice.
     *
     * @return void
     */
    public function testLinkIconAppearsInInlineToolbarAfterDeletingLinkTwice()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem', 'IPSUM');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem IPSUM</a> dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->click($this->find('dolor'));
        $this->click($this->find('IPSUM'));
        $this->clickInlineToolbarButton($dir.'toolbarIcon_removeLink.png');

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->selectText('Lorem');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem IPSUM</a> dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->click($this->find('dolor'));
        $this->click($this->find('IPSUM'));
        $this->clickInlineToolbarButton($dir.'toolbarIcon_removeLink.png');

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->selectText('Lorem');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->keyDown('Key.SHIFT + Key.RIGHT');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_link.png'), 'Toolbar button icon is not correct');

    }//end testLinkIconAppearsInInlineToolbarAfterDeletingLink()


    /**
     * Test that a link can be created for a selected text using the top toolbar.
     *
     * @return void
     */
    public function testCreateLinkUsingTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');

        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_link_subActive.png'), 'Toolbar button icon is not correct');

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->selectText('dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $updateChangesButton = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChangesButton);

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM <a href="http://www.squizlabs.com">dolor</a></p><p>sit amet <strong>WoW</strong></p>');

    }//end testCreateLinkUsingTopToolbar()


    /**
     * Test that a link with title can be created for a selected text.
     *
     * @return void
     */
    public function testCreateLinkPlainTextWithTitle()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p><a href="http://www.squizlabs.com" title="Squiz Labs">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>',
            '<p><a title="Squiz Labs" href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>'
        );

    }//end testCreateLinkPlainTextWithTitle()


    /**
     * Test that a link that will open in a new window will be created when you use the inline toolbar.
     *
     * @return void
     */
    public function testCreateLinkThatOpensInNewWindowUsingInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_openInNewWindow.png');
        sleep(1);
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>',
            '<p><a target="_blank" title="Squiz Labs" href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>'
        );

        $this->selectText('dolor');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_openInNewWindow.png');
        sleep(1);
        $updateChangesButton = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChangesButton);

        $this->assertHTMLMatch(
            '<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">Lorem</a> IPSUM <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">dolor</a></p><p>sit amet <strong>WoW</strong></p>',
            '<p><a target="_blank" title="Squiz Labs" href="http://www.squizlabs.com">Lorem</a> IPSUM <a target="_blank" title="Squiz Labs" href="http://www.squizlabs.com">dolor</a></p><p>sit amet <strong>WoW</strong></p>'
        );

    }//end testCreateLinkThatOpensInNewWindowUsingInlineToolbar()


    /**
     * Test that a link that will open in a new window will be created when you use the top toolbar.
     *
     * @return void
     */
    public function testCreateLinkThatOpensInNewWindowUsingTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');

        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickTopToolbarButton($dir.'toolbarIcon_openInNewWindow.png');
        sleep(1);
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>',
            '<p><a target="_blank" title="Squiz Labs" href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>'
        );

        $this->selectText('dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickTopToolbarButton($dir.'toolbarIcon_openInNewWindow.png');
        sleep(1);
        $updateChangesButton = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChangesButton);

        $this->assertHTMLMatch(
            '<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">Lorem</a> IPSUM <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">dolor</a></p><p>sit amet <strong>WoW</strong></p>',
            '<p><a target="_blank" title="Squiz Labs" href="http://www.squizlabs.com">Lorem</a> IPSUM <a target="_blank" title="Squiz Labs" href="http://www.squizlabs.com">dolor</a></p><p>sit amet <strong>WoW</strong></p>'
        );

    }//end testCreateLinkThatOpensInNewWindowUsingInlineToolbar()


    /**
     * Test that selecting a link shows the correct Viper tools.
     *
     * @return void
     */
    public function testSelectLinkTag()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('IPSUM');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>Lorem <a href="http://www.squizlabs.com" title="Squiz Labs">IPSUM</a> dolor</p><p>sit amet <strong>WoW</strong></p>',
            '<p>Lorem <a title="Squiz Labs" href="http://www.squizlabs.com">IPSUM</a> dolor</p><p>sit amet <strong>WoW</strong></p>'
        );

        $this->selectText('IPSUM');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_link_active.png'), 'Toolbar button icon is not correct');

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
        $this->selectText('IPSUM');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($this->find('Lorem'));
        $this->click($this->find('IPSUM'));
        $this->keyDown('Key.SHIFT + Key.RIGHT');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link_active.png'), 'Link icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Remove link icon should be available.');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png');
        $this->click($this->find('Lorem'));
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testSelectPartialLink()


    /**
     * Test that selecting a whole node (e.g. strong tag) shows the correct Viper tools and link can be applied to it.
     *
     * @return void
     */
    public function testSelectNodeThenCreateLink()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('WoW');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>Lorem IPSUM dolor</p><p>sit amet <strong><a href="http://www.squizlabs.com" title="Squiz Labs">WoW</a></strong></p>',
            '<p>Lorem IPSUM dolor</p><p>sit amet <strong><a title="Squiz Labs" href="http://www.squizlabs.com">WoW</a></strong></p>'
        );

    }//end testSelectNodeThenCreateLink()


    /**
     * Test that selecting nodes with different parents will not show link icon.
     *
     * @return void
     */
    public function testSelectMultiParentNoLink()
    {
        $this->selectText('amet', 'WoW');

        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link.png'), 'Link icon should not be available.');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Link icon should not be available.');

    }//end testSelectMultiParentNoLink()


    /**
     * Test that a link can be removed when you select the text.
     *
     * @return void
     */
    public function testRemoveLinkWhenSelectingText()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = $this->find('IPSUM');
        $this->selectText('Lorem');

        // Normal link
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');
        $this->click($text);
        $this->selectText('Lorem');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_removeLink.png');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_removeLink.png'), 'Remove link icon should not be available.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_link.png'), 'Link icon should be available.');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        // Mail to link
        $this->selectText('Lorem');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');
        $this->click($text);
        $this->selectText('Lorem');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_removeLink.png');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_removeLink.png'), 'Remove link icon should not be available.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_link.png'), 'Link icon should be available.');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testRemoveLinkWhenSelectingText()


    /**
     * Test that a link can be removed when you click inside the link.
     *
     * @return void
     */
    public function testRemoveLinkWhenClickingInLink()
    {
        $dir = dirname(__FILE__).'/Images/';

        // Normal link
        $this->selectText('IPSUM');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');
        $this->click($this->find('Lorem'));
        $this->click('IPSUM');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_removeLink.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_link.png'), 'Link icon should be available.');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        // Mail to link
        $this->selectText('Lorem');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');
        $this->click($this->find('dolor'));
        $this->click('Lorem');
        $this->clickInlineToolbarButton($dir.'/toolbarIcon_removeLink.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_link.png'), 'Link icon should be available.');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testRemoveLinkWhenClickingInLink()


    /**
     * Test that the remove link icon in the inline toolbar removes all links in a paragraph.
     *
     * @return void
     */
    public function testRemoveLinkInInlineToolbarForLinksInParagraph()
    {
        $this->selectText('WoW');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Remove link icon should not be available.');
        $this->assertHTMLMatch('<p>WoW IPSUM dolor</p><p>sit amet test</p>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');

        $this->selectText('dolor');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Remove link icon should not be available.');
        $this->assertHTMLMatch('<p>WoW IPSUM dolor</p><p>sit amet test</p>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');

        $this->selectText('IPSUM');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Remove link icon should not be available.');
        $this->assertHTMLMatch('<p>WoW IPSUM dolor</p><p>sit amet test</p>');


    }//end testRemoveLinkInInlineToolbarForLinksInParagraph()


    /**
     * Test that the remove link icon in the top toolbar removes all links in a paragraph.
     *
     * @return void
     */
    public function testRemoveLinkInTopToolbarForLinksInParagraph()
    {
        $this->selectText('WoW');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png');
        $this->assertHTMLMatch('<p>WoW IPSUM dolor</p><p>sit amet test</p>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');

        $this->selectText('dolor');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png');
        $this->assertHTMLMatch('<p>WoW IPSUM dolor</p><p>sit amet test</p>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');

        $this->selectText('IPSUM');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png');
        $this->assertHTMLMatch('<p>WoW IPSUM dolor</p><p>sit amet test</p>');

    }//end testRemoveLinkInTopToolbarForLinksInParagraph()


    /**
     * Test that a URL can be edited using the inline toolbar
     *
     * @return void
     */
    public function testEditingTheURLFieldUsingTheInlineToolbar()
    {
        $dir  = dirname(__FILE__).'/Images/';

        $text = $this->find('IPSUM');
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->click($text);
        $this->selectText('Lorem');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_removeLink.png'), 'Remove link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_removeLink.png'), 'Remove link icon should be available in top toolbar.');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_link.png');
        $this->type('http://www.google.com');
        $updateChangesButton = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChangesButton);

        $this->assertHTMLMatch('<p><a href="http://www.google.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testEditingTheURLFieldUsingTheInlineToolbar()


    /**
     * Test that you cannot delete a link using the x button in the toolbar
     *
     * @return void
     */
    public function testTryingToDeleteLinkUsingLinkIcon()
    {
        $dir  = dirname(__FILE__).'/Images/';

        $text = $this->find('IPSUM');
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->click($text);
        $this->selectText('Lorem');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_removeLink.png'), 'Remove link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_removeLink.png'), 'Remove link icon should be available in top toolbar.');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link_active.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_delete_link.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testTryingToDeleteLinkUsingLinkIcon()


    /**
     * Test that a URL can be edited using the top toolbar
     *
     * @return void
     */
    public function testEditingTheURLFieldUsingTheTopToolbar()
    {
        $dir  = dirname(__FILE__).'/Images/';

        $text = $this->find('IPSUM');
        $this->selectText('Lorem');

        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->click($text);
        $this->selectText('Lorem');

        $this->clickTopToolbarButton($dir.'toolbarIcon_link_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_delete_link.png');
        $this->type('http://www.google.com');
        $updateChangesButton = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChangesButton);

        $this->assertHTMLMatch('<p><a href="http://www.google.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testEditingTheURLFieldUsingTheTopToolbar()


    /**
     * Test that you can add and edit a title using the inline toolbar
     *
     * @return void
     */
    public function testAddingAndEditingTheTitleUsingInlineToolbar()
    {
        $dir  = dirname(__FILE__).'/Images/';

        $text = $this->find('IPSUM');
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->click($text);
        $this->selectText('Lorem');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_removeLink.png'), 'Remove link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_removeLink.png'), 'Remove link icon should be available in top toolbar.');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link_active.png');
        $titleField = $this->find($dir.'input_title.png', $this->getInlineToolbar());
        $this->click($titleField);
        $this->type('title');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="title">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->click($text);
        $this->selectText('Lorem');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link_active.png');
        $this->click($titleField);
        $this->type('abc');
        $updateChangesButton = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChangesButton);

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="titleabc">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testAddingAndEditingTheTitleUsingInlineToolbar()


    /**
     * Test that you can add and edit a title using the top toolbar
     *
     * @return void
     */
    public function testAddingAndEditingTheTitleUsingTopToolbar()
    {
        $dir  = dirname(__FILE__).'/Images/';

        $text = $this->find('IPSUM');
        $this->selectText('Lorem');

        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->click($text);
        $this->selectText('Lorem');

        $this->clickTopToolbarButton($dir.'toolbarIcon_link_active.png');
        $titleField = $this->find($dir.'input_title.png');
        $this->click($titleField);
        $this->type('title');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="title">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->click($text);
        $this->selectText('Lorem');
        $this->clickTopToolbarButton($dir.'toolbarIcon_link_active.png');
        $this->click($titleField);
        $this->type('abc');
        $updateChangesButton = $this->find($dir.'toolbarIcon_updateChanges.png');
        $this->click($updateChangesButton);

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="titleabc">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testAddingAndEditingTheTitleUsingTopToolbar()


    /**
     * Test that clicking inside a link tag will show the inline toolbar and select the whole link.
     *
     * @return void
     */
    public function testClickShowInlineToolbar()
    {
        $text = $this->find('Lorem');
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');
        $this->click($this->find('IPSUM'));

        sleep(1);
        $this->click($text);
        sleep(1);
        $this->click($text);

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link_active.png'), 'Link icon should be available.');

    }//end testClickShowInlineToolbar()


    /**
     * Test that clicking inside a link tag that has bold format will show the inline toolbar.
     *
     * @return void
     */
    public function testClickBoldLinkShowsInlineToolbar()
    {
        $text = $this->find('Lorem');
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('bold');
        $this->click($this->find('IPSUM'));

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
        $text = $this->find('Lorem');
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('italic');
        $this->click($this->find('IPSUM'));

        sleep(1);
        $this->click($text);

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link_active.png'), 'Link icon should be available.');

    }//end testClickItalicLinkShowsInlineToolbar()


    /**
     * Test that the class and id tags are added to the a tag when you create a link.
     *
     * @return void
     */
    public function testClassAndIdAreAddedToLinkTag()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');

        $this->clickInlineToolbarButton(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class.png');
        $this->type('class');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton('anchorID');
        $this->type('anchor');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>Lorem IPSUM <a href="http://www.squizlabs.com" class="class" id="anchor">dolor</a></p><p>sit amet <strong>WoW</strong></p>',
            '<p>Lorem IPSUM <a id="anchor" class="class" href="http://www.squizlabs.com">dolor</a></p><p>sit amet <strong>WoW</strong></p>');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_link_active.png'), 'Link icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_link_active.png'), 'Link icon should be active in the top toolbar.');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class_active.png'), 'Class icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class_active.png'), 'Class icon should be active in the top toolbar.');

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
        $dir = dirname(__FILE__).'/Images/';

        $text = 'dolor';
        $this->selectText($text);

        $this->clickInlineToolbarButton(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class.png');
        $this->type('class');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton('anchorID');
        $this->type('anchor');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>Lorem IPSUM <a href="http://www.squizlabs.com" class="class" id="anchor">dolor</a></p><p>sit amet <strong>WoW</strong></p>',
            '<p>Lorem IPSUM <a id="anchor" class="class" href="http://www.squizlabs.com">dolor</a></p><p>sit amet <strong>WoW</strong></p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png');

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testClassAndIdAreRemovedWhenLinkIsRemoved()


    /**
     * Test that the class and id tags are added to the a tag when you re-select the content and create a link.
     *
     * @return void
     */
    public function testClassAndIdAreAddedToLinkTagAfterReselect()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'dolor';

        $this->selectText($text);

        $this->clickInlineToolbarButton(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class.png');
        $this->type('class');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton('anchorID');
        $this->type('anchor');
        $this->keyDown('Key.ENTER');

        $this->click($this->find($text));
        $this->selectText($text);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>Lorem IPSUM <a href="http://www.squizlabs.com" class="class" id="anchor">dolor</a></p><p>sit amet <strong>WoW</strong></p>',
            '<p>Lorem IPSUM <a id="anchor" class="class" href="http://www.squizlabs.com">dolor</a></p><p>sit amet <strong>WoW</strong></p>');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_link_active.png'), 'Link icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_link_active.png'), 'Link icon should be active in the top toolbar.');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class_active.png'), 'Class icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_class_active.png'), 'Class icon should be active in the top toolbar.');

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
        $dir = dirname(__FILE__).'/Images/';

        $text = 'dolor';

        $this->selectText($text);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->assertEquals($text, $this->getSelectedText(), 'Original selection is still not selected.');

        $this->click($this->find($text));

        $this->selectText($text);
        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->assertEquals($text, $this->getSelectedText(), 'Original selection is still not selected.');


    }//end testSelectionIsMaintainedWhenYouClickOnLineIcon()


    /**
     * Test that clicking undo puts a link back correctly after you remove it.
     *
     * @return void
     */
    public function testClickingUndoPutLinkBackCorrectlyAfterItHasBeenRemoved()
    {
        $dir = dirname(__FILE__).'/Images/';

        $textLoc = $this->find('dolor');
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->click($textLoc);
        $this->selectText('Lorem');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_removelink.png');
        $this->click($textLoc);
        sleep(1);
        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->click($textLoc);
        $this->click($this->find('Lorem'));
        $this->clickInlineToolbarButton($dir.'toolbarIcon_removelink.png');
        $this->click($textLoc);
        sleep(1);
        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testClickingUndoPutLinkBackCorrectlyAfterItHasBeenRemoved()


    /**
     * Test creating and removing links in a paragraph.
     *
     * @return void
     */
    public function testCreateAndRemoveLinksForParagraph()
    {
        $dir = dirname(__FILE__).'/Images/';

        // Check that remove link is disabled for a paragraph without links
        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_removeLink.png'), 'Remove link icon should not appear in the inline toolbar.');

        $this->selectText('Lorem');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->selectText('dolor');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.google.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM <a href="http://www.google.com">dolor</a></p><p>sit amet <strong>WoW</strong></p>');

        $this->click($this->find('IPSUM'));
        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_removeLink.png'), 'Remove link icon should appear in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_removeLink.png'), 'Remove link icon should appear in the inline toolbar.');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_removeLink.png');
        $this->assertEquals('Lorem IPSUM dolor', $this->getSelectedText(), 'Paragraph is not selected.');
        //$this->click($this->find('IPSUM'));
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        // Undo so we can use the remove link in the top toolbar
        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM <a href="http://www.google.com">dolor</a></p><p>sit amet <strong>WoW</strong></p>');

        $this->selectText('Lorem');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton($dir.'toolbarIcon_removeLink.png');
        $this->assertEquals('Lorem IPSUM dolor', $this->getSelectedText(), 'Paragraph is not selected.');
        $this->click($this->find('IPSUM'));
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

    }//end testCreateLinkPlainTextUsingInlineToolbar()


    /**
     * Test link icon appears in the inline toolbar for acronym and abbreviation.
     *
     * @return void
     */
    public function testLinkIconForAcronymAndAbbreviation()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('IPSUM');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_link.png'), 'Link icon should appear in the inline toolbar.');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_removeLink.png'), 'Remove link icon should not appear in the inline toolbar.');
        $this->click($this->find('Lorem'));

        $this->selectText('WoW');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_link.png'), 'Link icon should appear in the inline toolbar.');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_removeLink.png'), 'Remove link icon should not appear in the inline toolbar.');

    }//end testLinkIconForAcronymAndAbbreviation()


    /**
     * Test creating a mail to link without a subject using the inline toolbar.
     *
     * @return void
     */
    public function testCreatingAMailToLinkUsingTheInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_link_subActive.png'), 'Toolbar button icon is not correct');

        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->selectText('dolor');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('mailto: labs@squiz.com.au');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_updateChanges.png');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">Lorem</a> IPSUM <a href="mailto:labs@squiz.com.au">dolor</a></p><p>sit amet <strong>WoW</strong></p>');

        $this->click($this->find('IPSUM'));

        $this->selectText('WoW');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('MAILTO: labs@squiz.com.au');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_updateChanges.png');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">Lorem</a> IPSUM <a href="mailto:labs@squiz.com.au">dolor</a></p><p>sit amet <strong><a href="mailto:labs@squiz.com.au">WoW</a></strong></p>');

    }//end testCreatingAMailToLinkUsingTheInlineToolbar()


    /**
     * Test creating a mail to link with a subject using the inline toolbar.
     *
     * @return void
     */
    public function testCreatingAMailToLinkWithSubjectUsingTheInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_link_subActive.png'), 'Toolbar button icon is not correct');

        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->selectText('dolor');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('mailto: labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_updateChanges.png');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">Lorem</a> IPSUM <a href="mailto:labs@squiz.com.au?subject=Subject">dolor</a></p><p>sit amet <strong>WoW</strong></p>');

        $this->click($this->find('IPSUM'));

        $this->selectText('WoW');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('MAILTO: labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_updateChanges.png');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">Lorem</a> IPSUM <a href="mailto:labs@squiz.com.au?subject=Subject">dolor</a></p><p>sit amet <strong><a href="mailto:labs@squiz.com.au?subject=Subject">WoW</a></strong></p>');

    }//end testCreatingAMailToLinkWithSubjectUsingTheInlineToolbar()


    /**
     * Test entering a mailto link, pressing enter and then adding a subject.
     *
     * @return void
     */
    public function testEnteringMailToLinkPressEnterThenEnterSubject()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->selectText('dolor');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('Test');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">Lorem</a> IPSUM <a href="mailto:labs@squiz.com.au?subject=Test">dolor</a></p><p>sit amet <strong>WoW</strong></p>');

    }//end testEnteringMailToLinkPressEnterThenEnterSubject()


    /**
     * Test creating a mail to link without a subject using the top toolbar.
     *
     * @return void
     */
    public function testCreatingAMailToLinkUsingTheTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';
        $this->selectText('Lorem');

        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_link_subActive.png'), 'Toolbar button icon is not correct');

        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->clickTopToolbarButton($dir.'toolbarIcon_link_subActive.png');

        $this->selectText('dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('mailto: labs@squiz.com.au');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">Lorem</a> IPSUM <a href="mailto:labs@squiz.com.au">dolor</a></p><p>sit amet <strong>WoW</strong></p>');

        $this->clickTopToolbarButton($dir.'toolbarIcon_link_subActive.png');

        $this->selectText('WoW');
        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('MAILTO: labs@squiz.com.au');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au">Lorem</a> IPSUM <a href="mailto:labs@squiz.com.au">dolor</a></p><p>sit amet <strong><a href="mailto:labs@squiz.com.au">WoW</a></strong></p>');

    }//end testCreatingAMailToLinkUsingTheTopToolbar()


    /**
     * Test creating a mail to link with a subject using the top toolbar.
     *
     * @return void
     */
    public function testCreatingAMailToLinkWithSubjectUsingTheTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';
        $this->selectText('Lorem');

        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_link_subActive.png'), 'Toolbar button icon is not correct');

        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->clickTopToolbarButton($dir.'toolbarIcon_link_subActive.png');

        $this->selectText('dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('mailto: labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">Lorem</a> IPSUM <a href="mailto:labs@squiz.com.au?subject=Subject">dolor</a></p><p>sit amet <strong>WoW</strong></p>');

        $this->clickTopToolbarButton($dir.'toolbarIcon_link_subActive.png');

        $this->selectText('WoW');
        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('MAILTO: labs@squiz.com.au');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->clickTopToolbarButton($dir.'toolbarIcon_updateChanges.png');
        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">Lorem</a> IPSUM <a href="mailto:labs@squiz.com.au?subject=Subject">dolor</a></p><p>sit amet <strong><a href="mailto:labs@squiz.com.au?subject=Subject">WoW</a></strong></p>');

    }//end testCreatingAMailToLinkWithSubjectUsingTheTopToolbar()


    /**
     * Test that the subject field only appears when you are creating a mailto link.
     *
     * @return void
     */
    public function testSubjectOnlyAppearsWhenCreatingAMailToLink()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('labs@squiz.com.au');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('Subject');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="mailto:labs@squiz.com.au?subject=Subject">Lorem</a> IPSUM dolor</p><p>sit amet <strong>WoW</strong></p>');

        $this->selectText('dolor');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->assertTrue($this->exists($dir.'input_link_fields.png'));

        $this->click($this->find('IPSUM'));

        $this->selectText('WoW');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->assertTrue($this->exists($dir.'input_link_fields.png'));

    }//end testSubjectOnlyAppearsWhenCreatingAMailToLink()


    /**
     * Test copying and pasting a mailto link.
     *
     * @return void
     */
    public function testCopyAndPasteMailtoLink()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->click($this->find('labs'));
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.CMD + c');
        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
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
        $dir = dirname(__FILE__).'/Images/';

        $this->clickElement('img', 1);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT</p><p><a href="www.squizlabs.com" title="Squiz Labs"><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></a></p><p>LABS is ORSM</p>');

        $this->click($this->find('LOREM'));

        $this->clickElement('img', 1);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_removelink.png');
        $this->assertHTMLMatch('<p>LOREM XuT</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>LABS is ORSM</p>');

    }//end testLinkingAnImageUsingInlineToolbar()


    /**
     * Test inserting and removing a link for an image using the top toolbar.
     *
     * @return void
     */
    public function testLinkingAnImageUsingTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>LOREM XuT</p><p><a href="www.squizlabs.com" title="Squiz Labs"><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></a></p><p>LABS is ORSM</p>');

        $this->click($this->find('LOREM'));

        $this->clickElement('img', 1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_removelink.png');
        $this->assertHTMLMatch('<p>LOREM XuT</p><p><img src="http://cms.squizsuite.net/__images/homepage-images/hero-shot.jpg" alt="Alt tag" /></p><p>LABS is ORSM</p>');

    }//end testLinkingAnImageUsingTopToolbar()


}//end class

?>
