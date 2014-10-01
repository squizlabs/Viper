<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyPasteLinksUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that copying/pasting links works from another document works.
     *
     * @return void
     */
    public function testCopyPasteLinksFromTextDoc()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->pasteFromURL($this->getTestURL('/ViperCopyPastePlugin/CopyPasteFiles/ExampleLinks.txt'));
        $this->assertHTMLMatch('<p>link with http - <a href="http://www.squizlabs.com">http://www.squizlabs.com</a></p><p>link with https - <a href="https://www.squizlabs.com">https://www.squizlabs.com</a></p><p>blocked link with http - <a href="http://www.squizlabs.com">blocked::http://www.squizlabs.com</a></p><p>blocked link with https - <a href="https://www.squizlabs.com">blocked::https://www.squizlabs.com</a></p>');

    }//end testCopyPasteLinksFromTextDoc()


    /**
     * Test copy and paste a link in the content of the page.
     *
     * @return void
     */
    public function testCopyAndPasteLinkInContent()
    {
        
        // Test copy and paste link only
        $this->useTest(2);
        $this->selectKeyword(1);
        sleep(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(2);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.SPACE');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<h1>Copy Link Test</h1><p>This is a paragraph <a href="http://www.squizlabs.com">%1%</a> in the content of my page.</p><p>This is another paragraph %2% <a href="http://www.squizlabs.com">%1%</a>&nbsp;in the content of my page. %3%</p>');

        // Test copy and paste paragraph containing the link
        $this->useTest(2);
        $this->selectKeyword(1);
        sleep(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(2);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<h1>Copy Link Test</h1><p>This is a paragraph <a href="http://www.squizlabs.com">%1%</a> in the content of my page.</p><p>This is another paragraph %2% in the content of my page. %3%</p><p>This is a paragraph <a href="http://www.squizlabs.com">%1%</a> in the content of my page.</p>');


    }//end testCopyAndPasteLinkInContent()

}//end class

?>
