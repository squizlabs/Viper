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
    public function testAddingAndDeletingLinkedKeywordsUsingInlineToolbar()
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
        $this->clickKeyword(2);

        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p>((prop:productName)) %3%</p><p>%4% ((prop:productName))</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');

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
        $this->assertRawHTMLMatch('<p>%1%<a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p>%4%<a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>Test content.</p>');

        // Deleting linked keywords in middle of paragraph
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %3%</p><p>%4% <a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p>%4% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>Test content.</p>');

        // Deleting linked keywords at beginning of paragraph
        $this->moveToKeyword(3 , 'left');
        $this->sikuli->keyDown('Key.LEFT');
        sleep(1);
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3%</p><p>%4% <a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3%</p><p>%4% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>Test content.</p>');

        // Deleting linked keywords at end of paragraph
        $this->moveToKeyword(4 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3%</p><p>%4%</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3%</p><p>%4%</p><p>Test content.</p>');

    }//end testAddingAndDeletingLinkedKeywordsUsingInlineToolbar()


    /**
     * Test that keyword can have links added and deleted.
     *
     * @return void
     */
    public function testAddingAndDeletingLinkedKeywordsUsingTopToolbar()
    {
        // Middle of a paragraph using inline toolbar
        $this->useTest(2);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com.au');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->clickKeyword(4);

        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p>((prop:productName)) %3%</p><p>%4% ((prop:productName))</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');

        // Beginning of a paragraph using inline toolbar
        $this->moveToKeyword(3 , 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        sleep(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com.au');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->clickKeyword(4);

        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %3%</p><p>%4% ((prop:productName))</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>Test content.</p>');

        // End of paragraph using inline toolbar
        $this->moveToKeyword(4 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('link');
        $this->type('http://www.squizlabs.com.au');
        $this->clickTopToolbarButton('Apply Changes', NULL, TRUE);
        $this->clickKeyword(4);

        $this->assertHTMLMatch('<p>%1% <a href="http://www.squizlabs.com.au">((prop:productName))</a> %2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %3%</p><p>%4% <a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1%<a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p>%4%<a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>Test content.</p>');

        // Deleting linked keywords in middle of paragraph
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p><a href="http://www.squizlabs.com.au">((prop:productName))</a> %3%</p><p>%4% <a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p><a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p>%4% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>Test content.</p>');

        // Deleting linked keywords at beginning of paragraph
        $this->moveToKeyword(3 , 'left');
        $this->sikuli->keyDown('Key.LEFT');
        sleep(1);
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3%</p><p>%4% <a href="http://www.squizlabs.com.au">((prop:productName))</a></p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3%</p><p>%4% <a href="http://www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>Test content.</p>');

        // Deleting linked keywords at end of paragraph
        $this->moveToKeyword(4 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3%</p><p>%4%</p><p>Test content.</p>');
        $this->assertRawHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3%</p><p>%4%</p><p>Test content.</p>');

    }//end testAddingAndDeletingLinkedKeywordsUsingTopToolbar()


    /**
     * Test that basic content can have a keyword url added.
     *
     * @return void
     */
    public function testAddingKeywordLinksToBasicContent()
    {
        // Test using top toolbar
        // Test beginning of a paragraph
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('((lookup:url:1))');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">%1%</a> %2% %3%</p>');

        // Test middle of paragraph
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('((lookup:url:2))');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">%1%</a> <a href="((lookup:url:2))">%2%</a> %3%</p>');

        // Test end of paragraph
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('link', NULL);
        $this->type('((lookup:url:3))');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">%1%</a> <a href="((lookup:url:2))">%2%</a> <a href="((lookup:url:3))">%3%</a></p>');

        // Test using inline toolbar
        // Test beginning of a paragraph
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('((lookup:url:1))');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">%1%</a> %2% %3%</p>');

        // Test middle of paragraph
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('((lookup:url:2))');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">%1%</a> <a href="((lookup:url:2))">%2%</a> %3%</p>');

        // Test end of paragraph
        $this->selectKeyword(3);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('((lookup:url:3))');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">%1%</a> <a href="((lookup:url:2))">%2%</a> <a href="((lookup:url:3))">%3%</a></p>');

    }//end testAddingKeywordLinksToBasicContent()


    /**
     * Test that keyword content can have a keyword url added.
     *
     * @return void
     */
    public function testAddingKeywordLinksToKeywordContent()
    {
        // Test using top toolbar
        // Test beginning of a paragraph
        $this->useTest(5);
        $this->clickKeyword(1);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->clickTopToolbarButton('link', NULL);
        $this->type('((lookup:url:1))');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">((prop:productName))</a> %1% ((prop:productName)) %2% ((prop:productName))</p><p>((prop:productName)) %3% ((prop:productName)) %4% ((prop:productName))</p>');

        // Test middle of paragraph
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->clickTopToolbarButton('link', NULL);
        $this->type('((lookup:url:2))');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">((prop:productName))</a> %1%<a href="((lookup:url:2))">((prop:productName))</a> %2% ((prop:productName))</p><p>((prop:productName)) %3% ((prop:productName)) %4% ((prop:productName))</p>');

        // Test end of paragraph
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('link', NULL);
        $this->type('((lookup:url:3))');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">((prop:productName))</a> %1%<a href="((lookup:url:2))">((prop:productName))</a> %2% <a href="((lookup:url:3))">((prop:productName))</a></p><p>((prop:productName)) %3% ((prop:productName)) %4% ((prop:productName))</p>');

        // Test using inline toolbar
        // Test beginning of a paragraph
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('((lookup:url:4))');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">((prop:productName))</a> %1%<a href="((lookup:url:2))">((prop:productName))</a> %2%<a href="((lookup:url:3))">((prop:productName))</a></p><p><a href="((lookup:url:4))">((prop:productName))</a> %3% ((prop:productName)) %4% ((prop:productName))</p>');

        // Test middle of paragraph
        $this->moveToKeyword(4, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('((lookup:url:5))');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">((prop:productName))</a> %1%<a href="((lookup:url:2))">((prop:productName))</a> %2%<a href="((lookup:url:3))">((prop:productName))</a></p><p><a href="((lookup:url:4))">((prop:productName))</a> %3% <a href="((lookup:url:5))">((prop:productName))</a> %4% ((prop:productName))</p>');

        // Test end of paragraph
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('((lookup:url:6))');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">((prop:productName))</a> %1%<a href="((lookup:url:2))">((prop:productName))</a> %2%<a href="((lookup:url:3))">((prop:productName))</a></p><p><a href="((lookup:url:4))">((prop:productName))</a> %3% <a href="((lookup:url:5))">((prop:productName))</a> %4% <a href="((lookup:url:6))">((prop:productName))</a></p>');

    }//end testAddingKeywordLinksToBasicContent()


    /**
     * Test that content with a keyword url can be edited.
     *
     * @return void
     */
    public function testEditingKeywordLinkedContent()
    {
        // Test that content can be edited without changing the url
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');
        $this->type('additional content ');
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">Test content additional content %1%</a></p><p>%2% More test %3% content. %4%</p>');

        // Test that url can be applied to another piece of content
        $this->selectKeyword(2, 4);
        $this->clickInlineToolbarButton('link', NULL);
        $this->type('((lookup:url:1))');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">Test content additional content %1%</a></p><p><a href="((lookup:url:1))">%2% More test %3% content. %4%</a></p>');

        // Test that second content can also be edited without chaging url
        $this->moveToKeyword(3, 'left');
        $this->type('more content ');
        $this->assertHTMLMatch('<p><a href="((lookup:url:1))">Test content additional content %1%</a></p><p><a href="((lookup:url:1))">%2% More test more content %3% content. %4%</a></p>');

    }//end testEditingKeywordLinkedContent()
}
