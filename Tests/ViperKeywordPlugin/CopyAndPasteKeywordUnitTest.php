	<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperKeywordPlugin_CopyAndPasteKeywordUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that keyword can copied and pasted.
     *
     * @return void
     */
    public function testCopyAndPasteKeyword()
    {

        // Beginning of paragraph using keyboard shortcuts
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>((prop:productName))%1% ((prop:productName)) %2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p>%1% <keyword title="((prop:productName))" data-viper-keyword="((prop:productName))" contenteditable="false">Viper</keyword> %2%<keyword title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</keyword></p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Middle of paragraph using keyboard shortcuts
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>%1% ((prop:productName)) %2%</p><p>%3%((prop:productName)) %4%</p>');

        $expectedRawHTML = '<p>%1% <keyword title="((prop:productName))" data-viper-keyword="((prop:productName))" contenteditable="false">Viper</keyword> %2%<keyword title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</keyword></p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // End of paragraph using keyboard shortcuts
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>%1% ((prop:productName)) %2%((prop:productName))</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p>%1% <keyword title="((prop:productName))" data-viper-keyword="((prop:productName))" contenteditable="false">Viper</keyword> %2%<keyword title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</keyword></p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testCopyAndPasteKeyword()


    /**
     * Test that classes using keyword names can be copied and pasted.
     *
     * @return void
     */
    public function testCopyAndPasteClassesWithKeywordNames()
    {
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->KeyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->KeyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>Test content <span class="footnote-ref ((prop:className)) ((prop:className))">%1%</span> more test content %2%<span class="footnote-ref ((prop:className)) ((prop:className))">%1%</span></p>');

        $expectedRawHTML = '<p>Test content <span class="footnote-ref replaced-className replaced-className" data-viper-class="footnote-ref ((prop:className)) ((prop:className))">%1%</span> more test content %2%<span class="footnote-ref replaced-className replaced-className" data-viper-class="footnote-ref ((prop:className)) ((prop:className))">%1%</span></p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testCopyAndPasteClassesWithKeywordNames()


    /**
     * Test that keyword with a link can be copied and pasted.
     *
     * @return void
     */
    public function testCopyAndPasteKeywordWithLink()
    {
        // Beginning of paragraph using keyboard shortcuts
        $this->useTest(3);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(1, 'left');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p><a href="www.squizlabs.com.au">((prop:productName))</a>%1% <a href="www.squizlabs.com.au">((prop:productName))</a> %2%</p><p>%3% %4%</p>');

        $expectedRawHTML = '<p><a href="www.squizlabs.com.au"><keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</keyword></a>%1% <a href="www.squizlabs.com.au"><keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</keyword></a> %2%</p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // Middle of paragraph using keyboard shortcuts
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>%1% <a href="www.squizlabs.com.au">((prop:productName))</a> %2%</p><p>%3%<a href="www.squizlabs.com.au">((prop:productName))</a> %4%</p>');

        $expectedRawHTML = '<p>%1% <a href="www.squizlabs.com.au"><keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</keyword></a> %2%</p><p>%3%<a href="www.squizlabs.com.au"><keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</keyword></a> %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

        // End of paragraph using keyboard shortcuts
        $this->useTest(1);
        $this->moveToKeyword(1 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>%1% <a href="www.squizlabs.com.au">((prop:productName))</a> %2%<a href="www.squizlabs.com.au">((prop:productName))</a></p><p>%3% %4%</p>');

        $expectedRawHTML = '<p>%1% <a href="www.squizlabs.com.au"><keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</keyword></a> %2%<a href="www.squizlabs.com.au"><keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">VIPER</keyword></a></p><p>%3% %4%</p>';
        $actualRawHTML = $this->getRawHtml();
        $this->assertEquals($expectedRawHTML, $actualRawHTML);

    }//end testCopyAndPasteKeywordWithLink()
}