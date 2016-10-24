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
        $this->useTest(4);
        $this->clickKeyword(1);
        sleep(1);
        $raw = $this->getRawHtml();
        $this->assertRawHTMLMatch(
            '<p>Lorem <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span> XAX</p><p><strong>XBX</strong> sit amet</p><p>test <img src="'.$this->getTestURL('/Web/testImage.png').'" data-viper-src="((prop:url))" alt="Viper" data-viper-alt="((prop:productName))" title="Test Image" data-viper-height="((prop:height))" data-viper-width="((prop:width))" height="200px" width="100px" /></p>'
        );
        $visible = $this->getHtml();
        $this->assertHTMLMatch('<p>Lorem ((prop:productName)) %1%</p><p><strong>%2%</strong> sit amet</p><p>test <img src="((prop:url))" alt="((prop:productName))" title="Test Image" height="((prop:height))" width="((prop:width))" /></p>');

    }//end testKeywordsReplaced()


    /**
     * Test that keywords can have content around it and be edited.
     *
     * @return void
     */
    public function testAddingContentAroundKeywords()
    {

        // Test before keyword at the start of a paragraph
        $this->useTest(3);
        $this->moveToKeyword(1, 'left');
        sleep(1);
        for ($i = 0; $i < 6; $i++) {
            $this->sikuli->keyDown('Key.LEFT');
        }
        $this->type('Test content ');
        sleep(1);

        $this->assertHTMLMatch('<p>Test content ((prop:productName)) %1%</p><p>((prop:productName)) %2%</p><p>%3% ((prop:productName)) more test content</p><p>Test content ((prop:productName)) %4%</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %1%</p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %2%</p><p>%3%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> more test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %4%</p><p>%5%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');

        // Test after keyword at the start of a paragraph
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type(' test content');
        sleep(1);

        $this->assertHTMLMatch('<p>Test content ((prop:productName)) %1%</p><p>((prop:productName)) test content %2%</p><p>%3% ((prop:productName)) more test content</p><p>Test content ((prop:productName)) %4%</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %1%</p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content %2%</p><p>%3%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> more test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %4%</p><p>%5%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');

        // Test before keyword in the middle of a paragraph
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('Test content ');
        sleep(1);

        $this->assertHTMLMatch('<p>Test content ((prop:productName)) %1%</p><p>((prop:productName)) test content %2%</p><p>%3% Test content ((prop:productName)) more test content</p><p>Test content ((prop:productName)) %4%</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %1%</p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content %2%</p><p>%3% Test content <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> more test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %4%</p><p>%5%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');

        // Test after keyword in the middle of a paragraph
        $this->moveToKeyword(4, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type(' more test content');
        sleep(1);

        $this->assertHTMLMatch('<p>Test content ((prop:productName)) %1%</p><p>((prop:productName)) test content %2%</p><p>%3% Test content ((prop:productName)) more test content</p><p>Test content ((prop:productName)) more test content %4%</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %1%</p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content %2%</p><p>%3% Test content <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> more test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> more test content %4%</p><p>%5%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');

        // Test before keyword at the end of a paragraph
        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('Test content ');
        sleep(1);

        $this->assertHTMLMatch('<p>Test content ((prop:productName)) %1%</p><p>((prop:productName)) test content %2%</p><p>%3% Test content ((prop:productName)) more test content</p><p>Test content ((prop:productName)) more test content %4%</p><p>%5% Test content ((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %1%</p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content %2%</p><p>%3% Test content <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> more test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> more test content %4%</p><p>%5% Test content <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');

        // Test after keyword at the end of a paragraph
        $this->moveToKeyword(6, 'right');
        for ($i = 0; $i < 6; $i++) {
            $this->sikuli->keyDown('Key.RIGHT');
        }
        $this->type(' test content');
        sleep(1);

        $this->assertHTMLMatch('<p>Test content ((prop:productName)) %1%</p><p>((prop:productName)) test content %2%</p><p>%3% Test content ((prop:productName)) more test content</p><p>Test content ((prop:productName)) more test content %4%</p><p>%5% Test content ((prop:productName))</p><p>%6% ((prop:productName)) test content</p>');
        $this->assertRawHTMLMatch('<p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %1%</p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content %2%</p><p>%3% Test content <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> more test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> more test content %4%</p><p>%5% Test content <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p>');

    }//end testAddingContentAroundKeywords()


    /**
     * Test that keywords with content can work properly with the delete functions.
     *
     * @return void
     */
    public function testDeletingContentAroundKeywords()
    {
        // Test using backspace key on content after keyword
        $this->useTest(2);
        $this->clickKeyword(1);
        sleep(2);
        $this->moveToKeyword(1 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->type('-A');
        sleep(1);
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);

        $this->assertHTMLMatch('<p>%1% ((prop:productName))-</p><p>%2% ((prop:productName))</p><p>%3% ((prop:productName))</p><p>%4% ((prop:productName))</p><p>%5% ((prop:productName)) test content</p><p>%6% ((prop:productName)) test content</p><p>Test content ((prop:productName)) %7%</p><p>Test content ((prop:productName)) %8%</p>');
        $this->assertRawHTMLMatch('<p>%1%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>-</p><p>%2%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%3%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %7%</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %8%</p>');

        // Test using delete key on content after keyword
        $this->moveToKeyword(2 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        sleep(1);
        $this->type('-B');
        sleep(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);

        $this->assertHTMLMatch('<p>%1% ((prop:productName))-</p><p>%2% ((prop:productName))B</p><p>%3% ((prop:productName))</p><p>%4% ((prop:productName))</p><p>%5% ((prop:productName)) test content</p><p>%6% ((prop:productName)) test content</p><p>Test content ((prop:productName)) %7%</p><p>Test content ((prop:productName)) %8%</p>');
        $this->assertRawHTMLMatch('<p>%1%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>-</p><p>%2%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>B</p><p>%3%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %7%</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %8%</p>');

        // Test using backspace key on content before keyword
        $this->moveToKeyword(3 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('C-');
        sleep(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');
        sleep(1);

        $this->assertHTMLMatch('<p>%1% ((prop:productName))-</p><p>%2% ((prop:productName))B</p><p>%3% -((prop:productName))</p><p>%4% ((prop:productName))</p><p>%5% ((prop:productName)) test content</p><p>%6% ((prop:productName)) test content</p><p>Test content ((prop:productName)) %7%</p><p>Test content ((prop:productName)) %8%</p>');
        $this->assertRawHTMLMatch('<p>%1%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>-</p><p>%2%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>B</p><p>%3% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %7%</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %8%</p>');

        // Test using delete key on content before keyword
        $this->moveToKeyword(4 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('D-');
        sleep(1);
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);

        $this->assertHTMLMatch('<p>%1% ((prop:productName))-</p><p>%2% ((prop:productName))B</p><p>%3% -((prop:productName))</p><p>%4% D((prop:productName))</p><p>%5% ((prop:productName)) test content</p><p>%6% ((prop:productName)) test content</p><p>Test content ((prop:productName)) %7%</p><p>Test content ((prop:productName)) %8%</p>');
        $this->assertRawHTMLMatch('<p>%1%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>-</p><p>%2%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>B</p><p>%3% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4% D<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %7%</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %8%</p>');

        // Test using backspace key on content before keyword in the middle of a paragraph  
        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('E-');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1% ((prop:productName))-</p><p>%2% ((prop:productName))B</p><p>%3% -((prop:productName))</p><p>%4% D((prop:productName))</p><p>%5% -((prop:productName)) test content</p><p>%6% ((prop:productName)) test content</p><p>Test content ((prop:productName)) %7%</p><p>Test content ((prop:productName)) %8%</p>');
        $this->assertRawHTMLMatch('<p>%1%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>-</p><p>%2%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>B</p><p>%3% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4% D<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %7%</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %8%</p>');

        // Test using delete key on content before keyword in the middle of a paragraph
        $this->moveToKeyword(6 , 'right');
        sleep(1);
        $this->sikuli->keyDown('Key.RIGHT');
        $this->type('F-');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1% ((prop:productName))-</p><p>%2% ((prop:productName))B</p><p>%3% -((prop:productName))</p><p>%4% D((prop:productName))</p><p>%5% -((prop:productName)) test content</p><p>%6% F((prop:productName)) test content</p><p>Test content ((prop:productName)) %7%</p><p>Test content ((prop:productName)) %8%</p>');
        $this->assertRawHTMLMatch('<p>%1%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>-</p><p>%2%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>B</p><p>%3% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4% D<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>%6% F<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %7%</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %8%</p>');

        // Test using backspace key on content after keyword in the middle of a paragraph
        $this->moveToKeyword(7, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('-G');
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1% ((prop:productName))-</p><p>%2% ((prop:productName))B</p><p>%3% -((prop:productName))</p><p>%4% D((prop:productName))</p><p>%5% -((prop:productName)) test content</p><p>%6% F((prop:productName)) test content</p><p>Test content ((prop:productName))- %7%</p><p>Test content ((prop:productName)) %8%</p>');
        $this->assertRawHTMLMatch('<p>%1%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>-</p><p>%2%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>B</p><p>%3% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4% D<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>%6% F<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>- %7%</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %8%</p>');
        
        // Test using backspace key on content after keyword in the middle of a paragraph
        $this->moveToKeyword(8, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->type('-H');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1% ((prop:productName))-</p><p>%2% ((prop:productName))B</p><p>%3% -((prop:productName))</p><p>%4% D((prop:productName))</p><p>%5% -((prop:productName)) test content</p><p>%6% F((prop:productName)) test content</p><p>Test content ((prop:productName))- %7%</p><p>Test content ((prop:productName))H %8%</p>');
        $this->assertRawHTMLMatch('<p>%1%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>-</p><p>%2%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>B</p><p>%3% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4% D<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% -<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>%6% F<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>- %7%</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>H %8%</p>');
        
    }//end testDeletingContentAroundKeywords()


    /**
     * Test that keywords work properly with the delete functions.
     *
     * @return void
     */
    public function testDeletingKeywords()
    {
        // Test using backspace on a keyword at the start of a paragraph
        $this->useTest(7);
        $this->clickKeyword(1);
        sleep(2);
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1%</p><p>((prop:productName)) %2%</p><p>Test content ((prop:productName)) %3%</p><p>%4% ((prop:productName)) test content</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1%</p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %2%</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%</p><p>%4%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>%5%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');

        // Test using delete on a keyword at the start of a paragraph
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1%</p><p>%2%</p><p>Test content ((prop:productName)) %3%</p><p>%4% ((prop:productName)) test content</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1%</p><p>%2%</p><p>Test content<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%</p><p>%4%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>%5%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');

        // Test using backspace on a keyword in the middle of a paragraph
        $this->moveToKeyword(3, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1%</p><p>%2%</p><p>Test content&nbsp;&nbsp;%3%</p><p>%4% ((prop:productName)) test content</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1%</p><p>%2%</p><p>Test content&nbsp;&nbsp;%3%</p><p>%4%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> test content</p><p>%5%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');

        // Test using delete on a keyword in the middle of a paragraph
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1%</p><p>%2%</p><p>Test content&nbsp;&nbsp;%3%</p><p>%4%&nbsp;&nbsp;test content</p><p>%5% ((prop:productName))</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1%</p><p>%2%</p><p>Test content&nbsp;&nbsp;%3%</p><p>%4%&nbsp;&nbsp;test content</p><p>%5%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');
    
        // Test using backspace on a keyword at the end of a paragraph
        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1%</p><p>%2%</p><p>Test content&nbsp;&nbsp;%3%</p><p>%4%&nbsp;&nbsp;test content</p><p>%5%</p><p>%6% ((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p>%1%</p><p>%2%</p><p>Test content&nbsp;&nbsp;%3%</p><p>%4%&nbsp;&nbsp;test content</p><p>%5%</p><p>%6%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');

        // Test using delete on a keyword at the end of a paragraph
        $this->moveToKeyword(6, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.DELETE');

        $this->assertHTMLMatch('<p>%1%</p><p>%2%</p><p>Test content&nbsp;&nbsp;%3%</p><p>%4%&nbsp;&nbsp;test content</p><p>%5%</p><p>%6%</p>');
        $this->assertRawHTMLMatch('<p>%1%</p><p>%2%</p><p>Test content&nbsp;&nbsp;%3%</p><p>%4%&nbsp;&nbsp;test content</p><p>%5%</p><p>%6%</p>');

    }//end testDeletingKeywords()
    

    /**
     * Test that selection is mainted when removing formating.
     *
     * @return void
     */
    public function testSelectionWhenUsingRemoveFormat()
    {
        // Test when selecting keyword
        $this->useTest(5, 1);
        $this->clickKeyword(5);
        sleep(1);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertEquals($this->replaceKeywords('%5%'), $this->getSelectedText(), '%5% should be selected');
        $this->assertHTMLMatch('<p><strong>Test %1% content </strong>((prop:viperKeyword))<strong> more test content</strong></p>');
        $this->assertRawHTMLMatch('<p><strong>Test %1% content</strong><span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span><strong> more test content</strong></p>');

        // Test when selecting content within a paragraph that has a keyword
        $this->useTest(5);
        $this->selectKeyword(1);
        sleep(1);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), '%5% should be selected');
        $this->assertHTMLMatch('<p><strong>Test</strong>%1%<strong> content ((prop:viperKeyword)) more test content</strong></p>');
        $this->assertRawHTMLMatch('<p><strong>Test</strong>%1%<strong> content<span data-viper-keyword="((prop:viperKeyword))" title="((prop:viperKeyword))">%5%</span> more test content</strong></p>');

        // Test when selecting whole paragraph
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->clickTopToolbarButton('removeFormat');
        $this->assertEquals($this->replaceKeywords('Test %1% content %5% more test content'), $this->getSelectedText(), 'Paragraph should be selected');

    }//end testSelectionWhenUsingRemoveFormat()


    /**
     * Test selecting keywords using keyboard shortcuts on OSX
     *
     * @return void
     */
    public function testSelectingKeywordsOnOsx()
    {   
        $this->runTestFor('osx');

        // Test from left of keyword with arrow keys
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT + Key.SHIFT');
        sleep(1);
        $this->assertEquals($this->replaceKeywords('Viper'), $this->getSelectedText(), 'Keyword should be selected');

        // Test from right of keyword with arrow keys
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        sleep(1);
        $this->sikuli->keyDown('Key.LEFT + Key.SHIFT');
        sleep(1);
        $this->assertEquals($this->replaceKeywords('Viper'), $this->getSelectedText(), 'Keyword should be selected');

        // Test from left of keyword with additional content with arrow keys
        $this->moveToKeyword(1, 'left');
        for ($i = 0; $i < 5; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        sleep(2);
        $this->assertEquals($this->replaceKeywords('%1% Viper'), $this->getSelectedText(), 'Keyword and content should be selected');

        // Test from right of keyword with additional content with arrow keys
        $this->moveToKeyword(2, 'right');
        for ($i = 0; $i < 5; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        sleep(1);
        $this->assertEquals($this->replaceKeywords('Viper %2%'), $this->getSelectedText(), 'Keyword and content should be selected');

        // Test from left of keyword with alt keyboard shortcut
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->assertEquals($this->replaceKeywords('Viper'), $this->getSelectedText(), 'Keyword should be selected');

        // Test from right of keyword with alt keyboard shortcut
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.LEFT');
        sleep(1);
        $this->assertEquals($this->replaceKeywords('Viper'), $this->getSelectedText(), 'Keyword should be selected');

        // Test from left of keyword with additional content with alt keyboard shortcut
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.RIGHT');
        sleep(2);
        $this->assertEquals($this->replaceKeywords('%1% Viper'), $this->getSelectedText(), 'Keyword and content should be selected');

        // Test from right of keyword with additional content with alt keyboard shortcut
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.ALT + Key.SHIFT + Key.LEFT');
        sleep(1);
        $this->assertEquals($this->replaceKeywords('Viper %2%'), $this->getSelectedText(), 'Keyword and content should be selected');

    }//end testSelectingKeywordsOnOsx()


     /**
     * Test selecting keywords using keyboard shortcuts on Windows
     *
     * @return void
     */
    public function testSelectingKeywordsOnWindows()
    {   
        $this->runTestFor('windows');

        // Test from left of keyword with arrow keys
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.RIGHT + Key.SHIFT');
        sleep(1);
        $this->assertEquals($this->replaceKeywords('Viper'), $this->getSelectedText(), 'Keyword should be selected');

        // Test from right of keyword with arrow keys
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.LEFT + Key.SHIFT');
        sleep(1);
        $this->assertEquals($this->replaceKeywords('Viper'), $this->getSelectedText(), 'Keyword should be selected');

        // Test from left of keyword with additional content with arrow keys
        $this->moveToKeyword(1, 'left');
        for ($i = 0; $i < 5; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        sleep(2);
        $this->assertEquals($this->replaceKeywords('%1% Viper'), $this->getSelectedText(), 'Keyword and content should be selected');

        // Test from right of keyword with additional content with arrow keys
        $this->moveToKeyword(2, 'right');
        for ($i = 0; $i < 4; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.LEFT');
        }
        sleep(1);
        $this->assertEquals($this->replaceKeywords('Viper %2%'), $this->getSelectedText(), 'Keyword and content should be selected');

        // Test from left of keyword with alt keyboard shortcut
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->assertEquals($this->replaceKeywords('Viper'), $this->getSelectedText(), 'Keyword should be selected');

        // Test from right of keyword with alt keyboard shortcut
        $this->moveToKeyword(2, 'left');
        $this->sikuli->keyDown('Key.LEFT');
        $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.LEFT');
        sleep(1);
        $this->assertEquals($this->replaceKeywords('Viper'), $this->getSelectedText(), 'Keyword should be selected');

        // Test from left of keyword with additional content with alt keyboard shortcut
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.RIGHT');
        sleep(2);
        $this->assertEquals($this->replaceKeywords('%1% Viper'), $this->getSelectedText(), 'Keyword and content should be selected');

        // Test from right of keyword with additional content with alt keyboard shortcut
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.LEFT');
        $this->sikuli->keyDown('Key.CTRL + Key.SHIFT + Key.LEFT');
        sleep(1);
        $this->assertEquals($this->replaceKeywords('Viper %2%'), $this->getSelectedText(), 'Keyword and content should be selected');

    }//end testSelectingKeywordsOnWindows()
    

}//end class

?>
