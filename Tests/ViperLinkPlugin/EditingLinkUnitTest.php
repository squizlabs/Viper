<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLinkPlugin_EditingLinkUnitTest extends AbstractViperUnitTest
{

    /**
     * Test editing the URL of the link
     *
     * @return void
     */
    public function testEditingTheURLOfTheLink()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Link in the content <a href="http://www.google.com">%1%</a> for testing</p>');

        // Using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clearFieldValue('URL');
        $this->type('http://www.google.com');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Link in the content <a href="http://www.google.com">%1%</a> for testing</p>');

    }//end testEditingTheURLOfTheLink()


    /**
     * Test that you can add and edit a title to an existing link
     *
     * @return void
     */
    public function testAddingAndEditingTheTitleOfLink()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Link in the content <a href="http://www.squizlabs.com" title="title">%1%</a> for testing</p>');

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('abc');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Link in the content <a href="http://www.squizlabs.com" title="titleabc">%1%</a> for testing</p>');

        // Using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('title');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Link in the content <a href="http://www.squizlabs.com" title="title">%1%</a> for testing</p>');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('abc');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>Link in the content <a href="http://www.squizlabs.com" title="titleabc">%1%</a> for testing</p>');

    }//end testAddingAndEditingTheTitleOfLink()


    /**
     * Test updating the new window value for a link
     *
     * @return void
     */
    public function testEditingTheNewWindowValue()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Link in the content <a href="http://www.squizlabs.com" target="_blank">%1%</a> for testing</p>');

        // Using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Link in the content <a href="http://www.squizlabs.com" target="_blank">%1%</a> for testing</p>');

    }//end testEditingTheNewWindowValue()


    /**
     * Test that you can edit the title and new window value for a link
     *
     * @return void
     */
    public function testEditingTheTitleAndNewWindowOfLink()
    {
        // Using the inline toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('title');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Link in the content <a href="http://www.squizlabs.com" title="title" target="_blank">%1%</a> for testing</p>');

        // Using the top toolbar
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', 'active');
        $this->clickField('Title');
        $this->type('title');
        $this->clickField('Open a New Window');
        sleep(1);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>Link in the content <a href="http://www.squizlabs.com" title="title" target="_blank">%1%</a> for testing</p>');

    }//end testEditingTheTitleAndNewWindowOfLink()


}//end class

?>