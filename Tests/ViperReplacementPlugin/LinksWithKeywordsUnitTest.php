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
        $this->clickKeyword(3);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.DELETE');
        
        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2% %3%</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2% %3%</p>');
        
        // Removing link
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
		$this->clickInlineToolbarButton('linkRemove');
        $this->clickKeyword(3);
        
        $this->assertHTMLMatch('<p>%1% ((prop:productName)) %2% %3%</p>');
        $this->assertRawHTMLMatch('<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %2% %3%</p>');
        
        // Using top toolbar
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('link');
        $this->type('www.squizlabs.com.au');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->clickKeyword(3);
        
        $this->assertHTMLMatch('<p>%1% <a href="www.squizlabs.com.au">((prop:productName))</a> %2% %3%</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2% %3%</p>');
        
        // Removing link
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('linkRemove');
        $this->clickKeyword(3);
        
        $this->assertHTMLMatch('<p>%1% ((prop:productName)) %2% %3%</p>');
        $this->assertRawHTMLMatch('<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %2% %3%</p>');
        
    }//end testLinkOnKeyword()
}