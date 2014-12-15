<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLinkPlugin_MailToLinkUnitTest extends AbstractViperUnitTest
{
    /**
     * Test creating a mail to link without a subject.
     *
     * @return void
     */
    public function testCreatingAMailToLink()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->type('labs@squiz.com.au');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Content for mailto link test <a href="mailto:labs@squiz.com.au">%1%</a> more content %2%</p>');

         // Using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->type('labs@squiz.com.au');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Content for mailto link test <a href="mailto:labs@squiz.com.au">%1%</a> more content %2%</p>');

    }//end testCreatingAMailToLink()


    /**
     * Test creating a mail to link with a subject.
     *
     * @return void
     */
    public function testCreatingAMailToLinkWithSubject()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Subject');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for mailto link test <a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> more content %2%</p>');

        // Using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->sikuli->keyDown('Key.TAB');
        $this->type('Subject');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for mailto link test <a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> more content %2%</p>');

    }//end testCreatingAMailToLinkWithSubject()


    /**
     * Test entering a mailto link, pressing enter and then adding a subject.
     *
     * @return void
     */
    public function testCreateMailToLinkAndThenAddSubject()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for mailto link test <a href="mailto:labs@squiz.com.au">%1%</a> more content %2%</p>');
        $this->clickField('Subject');
        $this->type('Subject');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for mailto link test <a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> more content %2%</p>');

        // Using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for mailto link test <a href="mailto:labs@squiz.com.au">%1%</a> more content %2%</p>');
        $this->clickField('Subject');
        $this->type('Subject');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for mailto link test <a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> more content %2%</p>');

    }//end testCreateMailToLinkAndThenAddSubject()


    /**
     * Test that the subject field only appears when you are creating a mailto link.
     *
     * @return void
     */
    public function testSubjectOnlyAppearsWhenCreatingAMailToLink()
    {
        // Check inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->assertTrue($this->fieldExists('Subject'));
        $this->clickField('Subject');
        $this->type('Subject');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for mailto link test <a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> more content %2%</p>');

        // Check that field doesn't exist for another word
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link');
        $this->assertFalse($this->fieldExists('Subject'));

        // Check top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->type('labs@squiz.com.au');
        $this->assertTrue($this->fieldExists('Subject'));
        $this->clickField('Subject');
        $this->type('Subject');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Content for mailto link test <a href="mailto:labs@squiz.com.au?subject=Subject">%1%</a> more content %2%</p>');

        // Check that field doesn't exist for another word
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('link');
        $this->assertFalse($this->fieldExists('Subject'));

    }//end testSubjectOnlyAppearsWhenCreatingAMailToLink()


    /**
     * Test copying and pasting a mailto link.
     *
     * @return void
     */
    public function testCopyAndPasteMailtoLink()
    {
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);

        $this->sikuli->keyDown('Key.CMD + c');
        sleep(2);
        $this->clickTopToolbarButton('link');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
        $this->type('Subject');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);

        $this->assertHTMLMatch('<p>test</p><p><a href="mailto:%1%@squiz.com.au?subject=Subject">%1%@squiz.com.au</a></p>');

    }//end testCopyAndPasteMailtoLink()


    /**
     * Test removing a mail to link.
     *
     * @return void
     */
    public function testRemoveMailToLink()
    {
        // When clicking in the text
        $this->useTest(3);
        $this->moveToKeyword(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>Content with a mailto link %1%</p>');

        // When selecting the link and using the inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>Content with a mailto link %1%</p>');

        // When selecting the link and using the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>Content with a mailto link %1%</p>');
        
        // When you have the link fields open in the inline toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>Content with a mailto link %1%</p>');

        // When you have the link fields open in the top toolbar
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickTopToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>Content with a mailto link %1%</p>');

    }//end testRemoveLinkWhenSelectingText()


}//end class

?>