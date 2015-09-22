<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperReplacementPlugin_ViperReplacementUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that you can open and close the source editor.
     *
     * @return void
     */
    public function testKeywordsReplaced()
    {
        $this->useTest(7);
        $this->clickKeyword(1);
        sleep(1);
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p><em>%1%Test content</em> <a href="http://www.squizlabs.com" title="Squiz Labs">%3%</a> <em>more&nbsp;test content.%2%</em></p><p>%4%Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%6%</a> more&nbsp;test content.%5%</p><p>%7%Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%9%</a> more&nbsp;test content.%8%</p>');

        // Test for italic within a created italic paragraph using inline toolbar
        $this->selectKeyword(4,5);
        $this->clickinLineToolbarButton('italic', NULL);
        $this->assertHTMLMatch('<p><em>%1%Test content</em> <a href="http://www.squizlabs.com" title="Squiz Labs">%3%</a> <em>more&nbsp;test content.%2%</em></p><p><em>%4%Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%6%</a> more&nbsp;test content.%5%</em></p><p>%7%Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%9%</a> more&nbsp;test content.%8%</p>');

        $this->selectKeyword(6);
        $this->clickinLineToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p><em>%1%Test content</em> <a href="http://www.squizlabs.com" title="Squiz Labs">%3%</a> <em>more&nbsp;test content.%2%</em></p><p><em>%4%Test content </em><a href="http://www.squizlabs.com" title="Squiz Labs">%6%</a><em> more&nbsp;test content.%5%</em></p><p>%7%Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%9%</a> more&nbsp;test content.%8%</p>');

        // Test for italic within a created italic paragraph using keyboard shortcuts
        $this->selectKeyword(7,8);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('<p><em>%1%Test content</em> <a href="http://www.squizlabs.com" title="Squiz Labs">%3%</a> <em>more&nbsp;test content.%2%</em></p><p><em>%4%Test content </em><a href="http://www.squizlabs.com" title="Squiz Labs">%6%</a><em> more&nbsp;test content.%5%</em></p><p><em>%7%Test content <a href="http://www.squizlabs.com" title="Squiz Labs">%9%</a> more&nbsp;test content.%8%</em></p>');

        $this->selectKeyword(9);
        $this->sikuli->keyDown('Key.CMD + i');
        $this->assertHTMLMatch('%1%</p><p><strong>XBX</strong> sit amet</p><p>test <img src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))" alt="Viper" data-viper-alt="((prop:productName))" title="Test Image" data-viper-height="((prop:height))" data-viper-width="((prop:width))" height="200px" width="100px"></p>');

        $raw = $this->getRawHTML();
        $this->assertEquals('<p>%1%</p><p><strong>%2%</strong> sit amet</p><p>test<img src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))" alt="Viper" data-viper-alt="((prop:productName))" title="Test Image" data-viper-height="((prop:height))" data-viper-width="((prop:width))" height="200px" width="100px"></p>');

        $visible = $this->getHtml();
        $this->assertHTMLMatch('<p>Lorem ((prop:productName)) %1%</p><p><strong>%2%</strong> sit amet</p><p>test <img src="((prop:url))" alt="((prop:productName))" title="Test Image" height="((prop:height))" width="((prop:width))" /></p>');
        $raw = $this->getRawHtml();
        $this->assertEquals('<p>Lorem <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span> </p>');
    }//end testKeywordsReplaced()


    /**
     * Test that keywords can have formats removed with remove format key applied.
     *
     * @return void
     */
    public function testRemoveFormatOnKeywords()
    {
        // Test on italic
        $this->useTest(3);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT + Key.SHIFT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% <strong>((prop:productName))</strong></p><p>%3% <del>((prop:productName))</del></p><p>%4% <sub>((prop:productName))</sub></p><p>%5% <sup>((prop:productName))</sup></p>');
        $this->assertRawHTMLMatch('<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%2% <strong><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></strong></p><p>%3% <del><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></del></p><p>%4% <sub><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sub></p><p>%5% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sup></p>');

        // Test on bold
        $this->moveToKeyword(2 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% <del>((prop:productName))</del></p><p>%4% <sub>((prop:productName))</sub></p><p>%5% <sup>((prop:productName))</sup></p>');
        $this->assertRawHTMLMatch('<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%2% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%3% <del><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></del></p><p>%4% <sub><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sub></p><p>%5% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sup></p>');

        // Test on strikethrough
        $this->moveToKeyword(3 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p><p>%4% <sub>((prop:productName))</sub></p><p>%5% <sup>((prop:productName))</sup></p>');
        $this->assertRawHTMLMatch('<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%2% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4% <sub><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sub></p><p>%5% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sup></p>');

        // Test on subscript
        $this->moveToKeyword(4 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p><p>%4% ((prop:productName))</p><p>%5% <sup>((prop:productName))</sup></p>');
        $this->assertRawHTMLMatch('<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%2% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% <sup><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></sup></p>');

        // Test on subscript
        $this->moveToKeyword(5 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->clickTopToolbarButton('removeFormat', NULL);
        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p><p>%4% ((prop:productName))</p><p>%5% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%2% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');

    }//end testRemoveFormatOnKeywords()


    /**
     * Test that keywords can have content around it and be edited.
     *
     * @return void
     */
    public function testAddingContentAroundKeywords()
    {
        // Test before keyword
        $this->useTest(4);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('Test content ');
        sleep(1);

        $this->assertHTMLMatch('<p>%1% Test content ((prop:productName)) %2%</p>');
        $this->assertRawHTMLMatch('<p>%1% Test content&nbsp;<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %2%</p>');

        // Test after keyword
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        sleep(2);
        $this->type(' more test content');
        sleep(1);

        $this->assertHTMLMatch('<p>%1% Test content ((prop:productName)) more test content %2%</p>');
        $this->assertRawHTMLMatch('<p>%1% Test content&nbsp;<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>&nbsp;more test content %2%</p>');

    }//end testAddingContentAroundKeywords()


    /**
     * Test that keywords can work properly with the delete functions.
     *
     * @return void
     */
    public function testDeletingKeywords()
    {
        // Test backspace key on standard keyword
        $this->useTest(2);
        $this->clickKeyword(1);
        sleep(2);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        
        $this->assertHTMLMatch('<p>%1% </p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p><p>%4% ((prop:productName))</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% </p><p>%2% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%3% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%4% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%5% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p><p>%6% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');
        
        // Using delete key on standard keyword
        $this->moveToKeyword(2 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.DELETE');
        $this->sikuli->keyDown('Key.ENTER');
        
        $this->assertHTMLMatch('<p>%1% </p><p>%2%</p><p>%3% ((prop:productName))</p><p>%4% ((prop:productName))</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% </p><p>%2% </p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');
        
        // Test backspace key on content after keyword
        $this->moveToKeyword(3 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('-A');
        $this->sikuli->keyDown('Key.BACKSPACE');
        
        $this->assertHTMLMatch('<p>%1% </p><p>%2%</p><p>%3% ((prop:productName)) -</p><p>%4% ((prop:productName))</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% </p><p>%2% </p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> -</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');
        
        // Using delete key on content after keyword
        $this->moveToKeyword(4 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('-B');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.DELETE');
        
        $this->assertHTMLMatch('<p>%1% </p><p>%2%</p><p>%3% ((prop:productName)) -</p><p>%4% ((prop:productName)) B</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% </p><p>%2% </p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> -</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> B</p><p>%5% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');
        
        // Test backspace key on content before keyword
        $this->moveToKeyword(5 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('C-');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        
        $this->assertHTMLMatch('<p>%1% </p><p>%2%</p><p>%3% ((prop:productName)) -</p><p>%4% ((prop:productName))</p><p>%5% -((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% </p><p>%2% </p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> -</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> B</p><p>%5% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');
        
        // Using delete key on content before keyword
        $this->moveToKeyword(6 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('D-');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.DELETE');
        
        $this->assertHTMLMatch('<p>%1% </p><p>%2%</p><p>%3% ((prop:productName)) -</p><p>%4% ((prop:productName)) B</p><p>%5% ((prop:productName))</p><p>%6% D((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% </p><p>%2% </p><p>%3% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> -</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> B</p><p>%5% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6% D<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');
        
    }//end testDeletingKeywords()


    /**
     * Test that selections with keywords can be edited.
     *
     * @return void
     */
    public function testRetainSelectionWithOneWordNotKeyword()
    {
        $this->useTest(6);
        $this->clickKeyword(1);
        sleep(1);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertEquals($this->replaceKeywords('%2%'), $this->getSelectedText(), '%2% should be selected');

    }//end testRetainSelectionWithOneWordNotKeyword()


    /**
     * Test that selections with keywords can be edited.
     *
     * @return void
     */
    public function testRetainSelectionWithParagraphNotKeyword()
    {
        $this->useTest(6);
        $this->clickKeyword(1);
        sleep(1);
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertEquals($this->replaceKeywords('%1% Test content Viper more test content %2% still test content. %3%'), $this->getSelectedText(), 'First line should be selected');
        
    }//end testRetainSelectionWithParagraphNotKeyword()

}//end class

?>
