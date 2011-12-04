<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLinkPlugin_LinkUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that a link can be created for a selected text.
     *
     * @return void
     */
    public function testCreateLinkPlainText()
    {
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link_subActive.png'), 'Toolbar button icon is not correct');

        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getInlineToolbar());
        $this->click($urlBox);

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">Lorem</a> xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testCreateLinkPlainText()


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

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs">Lorem</a> xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testCreateLinkPlainTextWithTitle()


    /**
     * Test that selecting a link shows the correct Viper tools.
     *
     * @return void
     */
    public function testSelectLinkTag()
    {
        $this->selectText('Lorem');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_link.png');

        $urlBox = $this->find(dirname(__FILE__).'/Images/toolbarInput_url.png', $this->getInlineToolbar());
        $this->click($urlBox);

        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs">Lorem</a> xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

        $this->selectText('Lorem');
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link_subActive.png'), 'Toolbar button icon is not correct');

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
        $this->selectText('Lorem');

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
        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

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

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet <strong><a href="http://www.squizlabs.com" title="Squiz Labs">consectetur</a></strong></p>');

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

        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testRemoveLink()


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
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_link.png'), 'Link icon should be available.');

    }//end testClickShowInlineToolbar()


}//end class

?>
