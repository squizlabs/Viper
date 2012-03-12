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
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link_subActive.png'), 'Toolbar button icon is not correct');

        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getInlineToolbar());
        $this->click($urlBox);

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p>');
        
        $this->selectText('dolor');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');
        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getInlineToolbar());
        $this->click($urlBox);
        $this->type('http://www.squizlabs.com');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_updateChanges.png');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM <a href="http://www.squizlabs.com">dolor</a></p><p>sit amet <strong>consectetur</strong></p>');

    }//end testCreateLinkPlainTextUsingInlineToolbar()
    

    /**
     * Test that the link icon appears in the inline toolbar after applying and deleting a link twice.
     *
     * @return void
     */
    public function testLinkIconAppearsInInlineToolbarAfterDeletingLinkTwice()
    {
        $this->selectText('Lorem', 'IPSUM');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');
        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getInlineToolbar());
        $this->click($urlBox);
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem IPSUM</a> dolor</p><p>sit amet <strong>consectetur</strong></p>');
        
        $this->click($this->find('IPSUM'));
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png');
        
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p>');
        
        $this->selectText('Lorem', 'IPSUM');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');
        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getInlineToolbar());
        $this->click($urlBox);
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem IPSUM</a> dolor</p><p>sit amet <strong>consectetur</strong></p>');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png');
        
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p>');
        
        $this->selectText('Lorem', 'IPSUM');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link_.png'), 'Toolbar button icon is not correct');

    }//end testLinkIconAppearsInInlineToolbarAfterDeletingLink()
    

    /**
     * Test that a link can be created for a selected text using the top toolbar.
     *
     * @return void
     */
    public function testCreateLinkUsingTopToolbar()
    {
        $this->selectText('Lorem');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link_subActive.png'), 'Toolbar button icon is not correct');

        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getTopToolbar());
        $this->click($urlBox);

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p>');
        
    }//end testCreateLinkUsingTopToolbar()


    /**
     * Test that a link with title can be created for a selected text.
     *
     * @return void
     */
    public function testCreateLinkPlainTextWithTitle()
    {
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link_subActive.png'), 'Toolbar button icon is not correct');

        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getInlineToolbar());
        $this->click($urlBox);

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p><a href="http://www.squizlabs.com" title="Squiz Labs">Lorem</a> IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p>',
            '<p><a title="Squiz Labs" href="http://www.squizlabs.com">Lorem</a> IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p>'
        );

    }//end testCreateLinkPlainTextWithTitle()


    /**
     * Test that selecting a link shows the correct Viper tools.
     *
     * @return void
     */
    public function testSelectLinkTag()
    {
        $this->selectText('IPSUM');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');

        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getInlineToolbar());
        $this->click($urlBox);

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>Lorem <a href="http://www.squizlabs.com" title="Squiz Labs">IPSUM</a< dolor</p><p>sit amet <strong>consectetur</strong></p>',
            '<p>Lorem <a title="Squiz Labs" href="http://www.squizlabs.com">IPSUM</a> dolor</p><p>sit amet <strong>consectetur</strong></p>'
        );

        $this->selectText('IPSUM');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link_active.png'), 'Toolbar button icon is not correct');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Link</li>', $lineage);

    }//end testSelectLinkTag()


    /**
     * Test that clicking inside a link tag will show the inline toolbar and select the whole link.
     *
     * @return void
     */
    public function testSelectPartialLink()
    {
        $text = $this->find('Lorem');
        $this->selectText($text);

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');
        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getInlineToolbar());
        $this->click($urlBox);

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($text);
        $this->keyDown('Key.SHIFT + Key.RIGHT');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link_active.png'), 'Link icon should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Remove link icon should be available.');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png');
        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testSelectPartialLink()


    /**
     * Test that selecting a whole node (e.g. strong tag) shows the correct Viper tools and link can be applied to it.
     *
     * @return void
     */
    public function testSelectNodeThenCreateLink()
    {
        $this->selectText('consectetur');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');

        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getInlineToolbar());
        $this->click($urlBox);

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>Lorem IPSUM dolor</p><p>sit amet <strong><a href="http://www.squizlabs.com" title="Squiz Labs">consectetur</a></strong></p>',
            '<p>Lorem IPSUM dolor</p><p>sit amet <strong><a title="Squiz Labs" href="http://www.squizlabs.com">consectetur</a></strong></p>'
        );

    }//end testSelectNodeThenCreateLink()


    /**
     * Test that selecting nodes with different parents will not show link icon.
     *
     * @return void
     */
    public function testSelectMultiParentNoLink()
    {
        $this->selectText('amet', 'consectetur');

        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link.png'), 'Link icon should not be available.');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Link icon should not be available.');

    }//end testSelectMultiParentNoLink()


    /**
     * Test that a link can be removed.
     *
     * @return void
     */
    public function testRemoveLink()
    {
        $text = $this->find('Lorem');
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');

        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getInlineToolbar());
        $this->click($urlBox);

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->click($text);
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png');

        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Remove link icon should not be available.');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link.png'), 'Link icon should be available.');

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testRemoveLink()


    /**
     * Test that a link is removed when you use the x button in the URL field
     *
     * @return void
     */
    public function testRemoveLinkUsingLinkIcon()
    {
        $text = $this->find('Lorem');
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');

        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getInlineToolbar());
        $this->click($urlBox);

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->click($text);
        $this->selectText('Lorem');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Remove link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Remove link icon should be available in top toolbar.');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link_active.png');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_delete_link.png');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>Lorem IPSUM dolor</p><p>sit amet <strong>consectetur</strong></p>');
        
        $this->click($text);
        $this->selectText('Lorem');
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Remove link icon should not be available.');
        $this->assertFalse($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Remove link icon should not be available in top toolbar.');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link.png'), 'Link icon should be available.');
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link.png'), 'Link icon should be available in top toolbar.');

    }//end testRemoveLinkUsingLinkIcon()
    

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

        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getInlineToolbar());
        $this->click($urlBox);

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        sleep(1);
        $this->click($text);
        sleep(1);
        $this->click($text);

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png'), 'Remove link icon should be available.');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link_active.png'), 'Link icon should be available.');

    }//end testClickShowInlineToolbar()


    /**
     * Test that the class and id tags are added to the a tag when you create a link.
     *
     * @return void
     */
    public function testClassAndIdAreAddedToLinkTag()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('dolor');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('class');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_anchor.png');
        $this->type('anchor');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>Lorem IPSUM <a href="http://www.squizlabs.com" class="class" id="anchor">dolor</a></p><p>sit amet <strong>consectetur</strong></p>', 
            '<p>Lorem IPSUM <a id="anchor" class="class" href="http://www.squizlabs.com">dolor</a></p><p>sit amet <strong>consectetur</strong></p>');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_link_active.png'), 'Link icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_link_active.png'), 'Link icon should be active in the top toolbar.');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon should be active in the top toolbar.');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_anchor_active.png'), 'Anchor icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_anchor_active.png'), 'Anchor icon should be active in the top toolbar.');

    }//end testClassAndIdAreAddedToLinkTag()


    /**
     * Test that the class and id tags are added to a span tag when you remove the link.
     *
     * @return void
     */
    public function testClassAndIdAreAddedToSpanTagWhenLinkIsRemoved()
    {
        $dir = dirname(__FILE__).'/Images/';

        $text = 'dolor';
        $this->selectText($text);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('class');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_anchor.png');
        $this->type('anchor');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>Lorem IPSUM <a href="http://www.squizlabs.com" class="class" id="anchor">dolor</a></p><p>sit amet <strong>consectetur</strong></p>', 
            '<p>Lorem IPSUM <a id="anchor" class="class" href="http://www.squizlabs.com">dolor</a></p><p>sit amet <strong>consectetur</strong></p>');

        $this->click($this->find($text));
        $this->selectText($text);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_removeLink.png');

        $this->assertHTMLMatch(
            '<p>Lorem IPSUM <span class="class" id="anchor">dolor</span></p><p>sit amet <strong>consectetur</strong></p>');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_anchor_active.png'), 'Anchor icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_anchor_active.png'), 'Anchor icon should be active in the top toolbar.');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon should be active in the top toolbar.');

    }//end testClassAndIdAreAddedToSpanTagWhenLinkIsRemoved()


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

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->type('class');
        $this->keyDown('Key.ENTER');

        $this->clickInlineToolbarButton($dir.'toolbarIcon_anchor.png');
        $this->type('anchor');
        $this->keyDown('Key.ENTER');

        $this->click($this->find($text));
        $this->selectText($text);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch(
            '<p>Lorem IPSUM <a href="http://www.squizlabs.com" class="class" id="anchor">dolor</a></p><p>sit amet <strong>consectetur</strong></p>', 
            '<p>Lorem IPSUM <a id="anchor" class="class" href="http://www.squizlabs.com">dolor</a></p><p>sit amet <strong>consectetur</strong></p>');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_link_active.png'), 'Link icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_link_active.png'), 'Link icon should be active in the top toolbar.');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon should be active in the top toolbar.');

        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_anchor_active.png'), 'Anchor icon should be active in the inline toolbar.');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_anchor_active.png'), 'Anchor icon should be active in the top toolbar.');

    }//end testClassAndIdAreAddedToLinkTagAfterReselect()


}//end class

?>
