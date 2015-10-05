<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperReplacementPlugin_ListsWithKeywordsUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that keyword can be added to ordered lists.
     *
     * @return void
     */
    public function testKeywordOrderedList()
    {
        $this->useTest(1);
        $this->clickKeyword(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listOL');

        $this->assertHTMLMatch('<ol><li>%1% ((prop:productName))</li></ol>');
        $this->assertRawHTMLMatch('<ol><li>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></li></ol>');
        // Test for revert
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listOL', 'active');

        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');
    }//end testKeywordOrderedList()


    /**
     * Test that keyword can be added unordered to lists.
     *
     * @return void
     */
    public function testKeywordUnorderedList()
    {
        $this->useTest(1);
        $this->clickKeyword(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listUL');

        $this->assertHTMLMatch('<ul><li>%1% ((prop:productName))</li></ul>');
        $this->assertRawHTMLMatch('<ul><li>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></li></ul>');
        // Test for revert
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listUL', 'active');

        $this->assertHTMLMatch('<p>%1% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1% <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></p>');
    }//end testKeywordUnorderedList()


    /**
     * Test that linked keyword can be added to unordered lists.
     *
     * @return void
     */
    public function testLinkedKeywordUnorderedList()
    {
        $this->useTest(2);
        $this->clickKeyword(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listUL');

        $this->assertHTMLMatch('<ul><li>%1% <a href="www.squizlabs.com.au">((prop:productName))</a></li></ul>');
        $this->assertRawHTMLMatch('<ul><li>%1% <a href="www.squizlabs.com.au"><span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></a></li></ul>');
        // Test for revert
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listUL', 'active');

        $this->assertHTMLMatch('<p>%1% <a href="www.squizlabs.com.au">((prop:productName))</a></p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="www.squizlabs.com.au"><span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></a></p>');
    }//end testLinkedKeywordUnorderedList()


    /**
     * Test that linked keyword can be added to ordered lists.
     *
     * @return void
     */
    public function testLinkedKeywordOrderedList()
    {
        $this->useTest(2);
        $this->clickKeyword(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listOL');

        $this->assertHTMLMatch('<ol><li>%1% <a href="www.squizlabs.com.au">((prop:productName))</a></li></ol>');
        $this->assertRawHTMLMatch('<ol><li>%1% <a href="www.squizlabs.com.au"><span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></a></li></ol>');
        // Test for revert
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listOL', 'active');

        $this->assertHTMLMatch('<p>%1% <a href="www.squizlabs.com.au">((prop:productName))</a></p>');
        $this->assertRawHTMLMatch('<p>%1% <a href="www.squizlabs.com.au"><span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span></a></p>');
    }//end testLinkedKeywordOrderedList()


    /**
     * Test that images using keywords can be added to unordered lists.
     *
     * @return void
     */
    public function testImageKeywordUnorderedList()
    {
        $this->useTest(3);
        $this->clickKeyword(1);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('listUL');

        $this->assertHTMLMatch('<ul><li>%1% Test content<img alt="TITLE" src="((prop:url))" /> more test content.%2%</li></ul>');
        $this->assertRawHTMLMatch('<ul><li>%1% Test content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'"> more test content.%2%</li></ul>');
        // Test for revert
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('listUL', 'active');

        $this->assertHTMLMatch('<p>%1% Test content <img alt="TITLE" src="((prop:url))" /> more test content.%2%</p>');
        $this->assertRawHTMLMatch('<p>%1% Test content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'"> more test content.%2%</p>');
    }//end testImageKeywordUnorderedList()

    /**
     * Test that images using keywords can be added to ordered lists.
     *
     * @return void
     */
    public function testImageKeywordOrderedList()
    {
        $this->useTest(3);
        $this->clickKeyword(1);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('listOL');

        $this->assertHTMLMatch('<ol><li>%1% Test content<img alt="TITLE" src="((prop:url))" /> more test content.%2%</li></ol>');
        $this->assertRawHTMLMatch('<ol><li>%1% Test content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'"> more test content.%2%</li></ol>');
        // Test for revert
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listOL', 'active');

        $this->assertHTMLMatch('<p>%1% Test content <img alt="TITLE" src="((prop:url))" /> more test content.%2%</p>');
        $this->assertRawHTMLMatch('<p>%1% Test content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'"> more test content.%2%</p>');
    }//end testImageKeywordOrderedList()
}
