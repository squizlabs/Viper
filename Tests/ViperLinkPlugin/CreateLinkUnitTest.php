<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLinkPlugin_CreateLinkUnitTest extends AbstractViperUnitTest
{


    /**
     * Test creating a link.
     *
     * @return void
     */
    public function testCreateLink()
    {
        // Using the inline toolbar
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test test %2%</p>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test test <a href="http://www.squizlabs.com">%2%</a></p>');

        // Using the inline toolbar with complicated link
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->type('workspace%3A%2F%2FSpacesStore%2F861ae017%2D59a7%2D4cef%2D989d%2D279cfe6a2949');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="workspace%3A%2F%2FSpacesStore%2F861ae017%2D59a7%2D4cef%2D989d%2D279cfe6a2949">%1%</a> link test test %2%</p>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('workspace%3A%2F%2FSpacesStore%2F861ae017%2D59a7%2D4cef%2D989d%2D279cfe6a2949');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="workspace%3A%2F%2FSpacesStore%2F861ae017%2D59a7%2D4cef%2D989d%2D279cfe6a2949">%1%</a> link test test <a href="workspace%3A%2F%2FSpacesStore%2F861ae017%2D59a7%2D4cef%2D989d%2D279cfe6a2949">%2%</a></p>');

        // Using the top toolbar
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test test %2%</p>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1%</a> link test test <a href="http://www.squizlabs.com">%2%</a></p>');

        // Using the top toolbar with complicated link
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->type('workspace%3A%2F%2FSpacesStore%2F861ae017%2D59a7%2D4cef%2D989d%2D279cfe6a2949');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="workspace%3A%2F%2FSpacesStore%2F861ae017%2D59a7%2D4cef%2D989d%2D279cfe6a2949">%1%</a> link test test %2%</p>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('link');
        $this->type('workspace%3A%2F%2FSpacesStore%2F861ae017%2D59a7%2D4cef%2D989d%2D279cfe6a2949');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="workspace%3A%2F%2FSpacesStore%2F861ae017%2D59a7%2D4cef%2D989d%2D279cfe6a2949">%1%</a> link test test <a href="workspace%3A%2F%2FSpacesStore%2F861ae017%2D59a7%2D4cef%2D989d%2D279cfe6a2949">%2%</a></p>');

    }//end testCreateLink()


    /**
     * Test that a link with title can be created for a selected text.
     *
     * @return void
     */
    public function testCreateLinkWithTitle()
    {
        // Using inline toolbar
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> link test test %2%</p>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> link test test <a href="http://www.squizlabs.com" title="Squiz Labs">%2%</a></p>');

        // Using top toolbar
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> link test test %2%</p>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a> link test test <a href="http://www.squizlabs.com" title="Squiz Labs">%2%</a></p>');

    }//end testCreateLinkWithTitle()


    /**
     * Test creating a link that opens in a new window.
     *
     * @return void
     */
    public function testCreateLinkThatOpensInNewWindow()
    {
        // Using inline toolbar
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a> link test test %2%</p>');

        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a> link test test <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%2%</a></p>');

        // Using top toolbar
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a> link test test %2%</p>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%1%</a> link test test <a href="http://www.squizlabs.com" title="Squiz Labs" target="_blank">%2%</a></p>');

    }//end testCreateLinkThatOpensInNewWindow()


    /**
     * Test creating a link around a paragraph.
     *
     * @return void
     */
    public function testCreateLinkForParagraph()
    {
        // Using the top toolbar
        $this->useTest(1);

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('link');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com">%1% link test test %2%</a></p>');

        // Check icon in the top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('link', 'active'), 'Link icon should be active in the top toolbar');
        $this->assertTrue($this->topToolbarButtonExists('linkRemove'), 'Remove link icon should be available.');

    }//end testCreateLinkForParagraph()


    /**
     * Test that a link is automatically created when you type a URL in the content.
     *
     * @return void
     */
    public function testAutoCreatingLinks()
    {
        $this->useTest(1);

        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');

        // Test pressing space after the link text
        $this->type('Some text http://www.squizlabs.com some text www.example.com ');
        $this->assertHTMLMatch('<p>%1% link test test %2%</p><p>Some text <a href="http://www.squizlabs.com">http://www.squizlabs.com</a> some text <a href="http://www.example.com">www.example.com</a></p>');

        // Test pressing enter after the link text
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Third link http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('Fourth link www.example.com ');
        $this->assertHTMLMatch('<p>%1% link test test %2%</p><p>Some text <a href="http://www.squizlabs.com">http://www.squizlabs.com</a> some text <a href="http://www.example.com">www.example.com</a></p><p>Third link <a href="http://www.squizlabs.com">http://www.squizlabs.com</a></p><p>Fourth link <a href="http://www.example.com">www.example.com</a></p>');

    }//end testAutoCreatingLinks()


    /**
     * Test applying a link to a bold word.
     *
     * @return void
     */
    public function testApplyingLinkToBoldText()
    {
        // Using inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for link test <strong><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a></strong> %2%</p>');

        // Using top toolbar
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for link test <strong><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a></strong> %2%</p>');

    }//end testApplyingLinkToBoldText()


    /**
     * Test applying a link to an italics word.
     *
     * @return void
     */
    public function testApplyingLinkToItalicText()
    {
        // Using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for link test <em><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a></em> %2%</p>');

        // Using top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for link test <em><a href="http://www.squizlabs.com" title="Squiz Labs">%1%</a></em> %2%</p>');

    }//end testApplyingLinkToItalicText()


    /**
     * Test creating links with different formatted words.
     *
     * @return void
     */
    public function testApplyingLinkToDifferentFormattedWords()
    {
        // Test applying around a bold and non-formatted word using the inline toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for link test <a href="http://www.squizlabs.com" title="Squiz Labs"><strong>%1%</strong> %2%</a></p>');

        // Test applying around a bold and non-formatted word using the top toolbar
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for link test <a href="http://www.squizlabs.com" title="Squiz Labs"><strong>%1%</strong> %2%</a></p>');

        // Test applying around an italic and non-formatted word using the inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for link test <a href="http://www.squizlabs.com" title="Squiz Labs"><em>%1%</em> %2%</a></p>');

        // Test applying around an italics and non-formatted word using the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Squiz Labs');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for link test <a href="http://www.squizlabs.com" title="Squiz Labs"><em>%1%</em> %2%</a></p>');

    }//end testApplyingLinkToDifferentFormattedWords()


    /**
     * Test cancelling the creation of a link.
     *
     * @return void
     */
    public function testCancellingCreatingLink()
    {
        // Using the inline toolbar
        $this->useTest(1);

        // Check by closing the link pop up
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->clickInlineToolbarButton('link', 'selected');
        $this->assertHTMLMatch('<p>%1% link test test %2%</p>');

        // Check by clicking away from the link pop up
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->moveToKeyword(2);
        $this->assertHTMLMatch('<p>%1% link test test %2%</p>');

        // Using the top toolbar
        $this->useTest(1);

        // Check by closing the link pop up
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->clickTopToolbarButton('link', 'selected');
        $this->assertHTMLMatch('<p>%1% link test test %2%</p>');

        // Check by clicking away from the link pop up
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com');
        $this->moveToKeyword(2);
        $this->assertHTMLMatch('<p>%1% link test test %2%</p>');

    }//end testCancellingCreatingLink()

}//end class

?>
