<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperLinkPlugin_LangToolsWithLinkUnitTest extends AbstractViperUnitTest
{

    /**
     * Test creating a link for an abbreviation.
     *
     * @return void
     */
    public function testLinkIconForAbbreviation()
    {
        // Using the inline toolbar
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is a paragraph <abbr title="abc"><a href="http://www.squizlabs.com">%1%</a></abbr> with an abbr</p>');

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertTrue($this->inlineToolbarButtonExists('link'));
        $this->assertHTMLMatch('<p>This is a paragraph <abbr title="abc">%1%</abbr> with an abbr</p>');

        // Using the top toolbar
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is a paragraph <abbr title="abc"><a href="http://www.squizlabs.com">%1%</a></abbr> with an abbr</p>');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertTrue($this->topToolbarButtonExists('link'));
        $this->assertHTMLMatch('<p>This is a paragraph <abbr title="abc">%1%</abbr> with an abbr</p>');

    }//end testLinkIconForAbbreviation()


    /**
     * Test creating a link for an acronym.
     *
     * @return void
     */
    public function testLinkIconForAcronym()
    {
        // Using the inline toolbar
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is a paragraph <acronym title="abc"><a href="http://www.squizlabs.com">%1%</a></acronym> with an acronym</p>');

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertTrue($this->inlineToolbarButtonExists('link'));
        $this->assertHTMLMatch('<p>This is a paragraph <acronym title="abc">%1%</acronym> with an acronym</p>');

        // Using the top toolbar
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is a paragraph <acronym title="abc"><a href="http://www.squizlabs.com">%1%</a></acronym> with an acronym</p>');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertTrue($this->topToolbarButtonExists('link'));
        $this->assertHTMLMatch('<p>This is a paragraph <acronym title="abc">%1%</acronym> with an acronym</p>');

    }//end testLinkIconForAcronym()


    /**
     * Test creating a link for a language.
     *
     * @return void
     */
    public function testLinkIconForLanguage()
    {
        // Using the inline toolbar
        $this->useTest(3);

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link');
        $this->assertTrue($this->inlineToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is a paragraph <a lang="en" href="http://www.squizlabs.com">%1%</a> with a language</p>');

        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('linkRemove');
        $this->assertTrue($this->inlineToolbarButtonExists('link'));
        $this->assertHTMLMatch('<p>This is a paragraph %1% with a language</p>');

        // Using the top toolbar
        $this->useTest(3);

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link');
        $this->assertTrue($this->topToolbarButtonExists('link', 'selected'), 'Toolbar button icon is not correct');
        $this->type('http://www.squizlabs.com');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p>This is a paragraph <a lang="en" href="http://www.squizlabs.com">%1%</a> with a language</p>');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('linkRemove');
        $this->assertTrue($this->topToolbarButtonExists('link'));
        $this->assertHTMLMatch('<p>This is a paragraph %1% with a language</p>');

    }//end testLinkIconForLanguage()


}//end class

?>