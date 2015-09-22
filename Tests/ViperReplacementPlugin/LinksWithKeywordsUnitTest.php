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


    /**
     * Test that keyword can have links added and deleted.
     *
     * @return void
     */
    public function testAddingAndDeletingLinkedKeywords()
    {
        // Middle of a paragraph using inline toolbar
        $this->useTest(2);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com.au');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->clickKeyword(3);
        
        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p>((prop:productName)) %3%</p><p>%4% ((prop:productName))</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');
        
        // Deleting after keyword
        $this->moveToKeyword(2 , 'right');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        
        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>((prop:productName)) %3%</p><p>%4% ((prop:productName))</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');

        $this->type('%2%');

        // Deleting before keyword
        $this->moveToKeyword(1 , 'left');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p>((prop:productName)) %3%</p><p>%4% ((prop:productName))</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');

        $this->type('%1%');

        // Beginning of a paragraph using inline toolbar
        $this->moveToKeyword(3 , 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        sleep(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com.au');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %3%</p><p>%4% ((prop:productName))</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');

        // Deleting after keyword
        $this->moveToKeyword(3 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>%4% ((prop:productName))</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');

        $this->type('%3%');

        // End of paragraph using inline toolbar
        $this->moveToKeyword(4 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickInlineToolbarButton('link');
        $this->type('http://www.squizlabs.com.au');
        $this->clickInlineToolbarButton('Apply Changes', NULL, TRUE);
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %3%</p><p>%4% <a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');

        // Deleting after keyword
        $this->moveToKeyword(4 , 'left');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %3%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p> <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>Test content.</p>');

        $this->type('%4%');

        // Deleting linked keywords in middle of paragraph
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1%&nbsp;%2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %3%</p><p>4% <a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;%2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p>4% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>Test content.</p>');

        // Deleting linked keywords at beginning of paragraph
        $this->moveToKeyword(3 , 'left');
        $this->sikuli->keyDown('Key.LEFT');
        sleep(1);
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1%&nbsp;%2%</p><p>%3%</p><p>4% <a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;%2%</p><p>%3%</p><p>4% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>Test content.</p>');

        // Deleting linked keywords at end of paragraph
        $this->moveToKeyword(4 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1%&nbsp;%2%</p><p>%3%</p><p>4%</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;%2%</p><p>%3%</p><p>4%</p><p>Test content.</p>');

        // Middle of a paragraph using top toolbar
        $this->useTest(2);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com.au');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->clickKeyword(3);
        
        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p>((prop:productName)) %3%</p><p>%4% ((prop:productName))</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');
        
        // Deleting after keyword
        $this->moveToKeyword(2 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        
        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>((prop:productName)) %3%</p><p>%4% ((prop:productName))</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');

        $this->type('%2%');

        // Deleting before keyword
        $this->moveToKeyword(1 , 'left');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p>((prop:productName)) %3%</p><p>%4% ((prop:productName))</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');

        $this->type('%1%');

        // Beginning of a paragraph using inline toolbar
        $this->moveToKeyword(3 , 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        sleep(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com.au');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %3%</p><p>%4% ((prop:productName))</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');

        // Deleting after keyword
        $this->moveToKeyword(3 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>%4% ((prop:productName))</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');

        $this->type('%3%');

        // End of paragraph using inline toolbar
        $this->moveToKeyword(4 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com.au');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->clickKeyword(1);

        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %3%</p><p>%4% <a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');

        // Deleting after keyword
        $this->moveToKeyword(4 , 'left');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %3%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>Test content.</p>');

        $this->type('%4%');

        // Deleting linked keywords in middle of paragraph
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1%&nbsp;%2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %3%</p><p>%4% <a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;%2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p>%4% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>Test content.</p>');

        // Deleting linked keywords at beginning of paragraph
        $this->moveToKeyword(3 , 'left');
        $this->sikuli->keyDown('Key.LEFT');
        sleep(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1%&nbsp;%2%</p><p>%3%</p><p>%4% <a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;%2%</p><p>%3%</p><p>%4% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>Test content.</p>');

        // Deleting linked keywords at end of paragraph
        $this->moveToKeyword(4 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1%&nbsp;%2%</p><p>%3%</p><p>%4%</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;%2%</p><p>%3%</p><p>%4%</p><p>Test content.</p>');
        
    }//end testAddingAndDeletingLinkedKeywords()
}