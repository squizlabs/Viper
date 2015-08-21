	<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperKeywordPlugin_CutAndPasteKeywordUnitTest extends AbstractViperUnitTest
{

        /**
     * Test that keyword can cut and pasted.
     *
     * @return void
     */
    public function testCutAndPasteKeyword()
    {

        // Beginning of paragraph
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(1, 'left');
        $this->sikuli->KeyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>((prop:productName))%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p><keyword title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</keyword>%1% <keyword title="((prop:productName))" data-viper-keyword="((prop:productName))" contenteditable="false"></keyword> %2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);
        
        // Middle of paragraph
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(3, 'right');
        $this->sikuli->KeyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3%((prop:productName)) %4%</p>');

        $expectedRawHTML = '<p><keyword title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</keyword>%1% <keyword title="((prop:productName))" data-viper-keyword="((prop:productName))" contenteditable="false"></keyword> %2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);        

        // End of paragraph
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->KeyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%((prop:productName))</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p><keyword title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</keyword>%1% <keyword title="((prop:productName))" data-viper-keyword="((prop:productName))" contenteditable="false"></keyword> %2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testCutAndPasteKeyword()


    /**
     * Test that classes using keyword names can be cut and pasted.
     *
     * @return void
     */
    public function testCutAndPasteClassesWithKeywordNames()
    {
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->KeyDown('Key.CMD + x');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->KeyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>Test content&nbsp;&nbsp;more test content %2%<span class="footnote-ref ((prop:className)) ((prop:className))">%1%</span></p>');

        $expectedRawHTML = '<p>Test content&nbsp;&nbsp;more test content %2%<span class="footnote-ref replaced-className replaced-className" data-viper-class="footnote-ref ((prop:className)) ((prop:className))">%1%</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testCutAndPasteClassesWithKeywordNames()


    /**
     * Test that keyword with a link can be cut and pasted.
     *
     * @return void
     */
    public function testCutAndPasteKeywordWithLink()
    {


        // Beginning of paragraph using keyboard shortcuts
        $this->useTest(3);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p><a href="www.squizlabs.com.au">((prop:productName))</a>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p><a href="www.squizlabs.com.au"><keyword data-viper-keyword="((prop:productName))" title="((prop:productName))" contenteditable="false">VIPER</keyword></a>%1%&nbsp;&nbsp;%2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Middle of paragraph using keyboard shortcuts
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%</p><p>%3%<a href="www.squizlabs.com.au">((prop:productName))</a> %4%</p>');

        $expectedRawHTML = '<p>%1%&nbsp;&nbsp;%2%</p><p>%3%<a href="www.squizlabs.com.au"><keyword data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</keyword></a> %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // End of paragraph using keyboard shortcuts
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>%1%&nbsp;&nbsp;%2%<a href="www.squizlabs.com.au">((prop:productName))</a></p><p>%3% %4%</p>');

        $expectedRawHTML = '<p>%1%&nbsp;&nbsp;%2%<a href="www.squizlabs.com.au"><keyword data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</keyword></a></p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testCutAndPasteKeywordWithLink()

}