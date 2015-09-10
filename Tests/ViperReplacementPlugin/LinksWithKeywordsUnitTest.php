<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperReplacementPlugin_LinksWithKeywordsUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that keyword can have links added and removed.
     *
     * @return void
     */
    public function testLinkOnKeyword()
    {
        // Using inline toolbar
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com.au');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p>');

        $expectedRawHTML = '<p>%1% <keyword title="((prop:productName))" data-viper-keyword="((prop:productName))" contenteditable="false"><a href="www.squizlabs.com.au">Viper</a></keyword> %2%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Removing link
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
		$this->clickInlineToolbarButton('linkRemove');
        $this->assertHTMLMatch('<p>%1% ((prop:productName)) %2%</p>');

        $expectedRawHTML = '<p>%1% <keyword title="((prop:productName))" data-viper-keyword="((prop:productName))" contenteditable="false">Viper</keyword> %2%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Using top toolbar
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('link');
        $this->type('www.squizlabs.com.au');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->assertHTMLMatch('<p>%1% <a href="www.squizlabs.com.au">((prop:productName))</a> %2%</p>');

        $expectedRawHTML = '<p>%1% <keyword title="((prop:productName))" data-viper-keyword="((prop:productName))" contenteditable="false"><a href="www.squizlabs.com.au">Viper</a></keyword> %2%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Removing link
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('linkRemove');

        $this->assertHTMLMatch('<p>%1% ((prop:productName)) %2%</p>');

        $expectedRawHTML = '<p>%1% <keyword title="((prop:productName))" data-viper-keyword="((prop:productName))" contenteditable="false">Viper</keyword> %2%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testLinkOnKeyword()
}