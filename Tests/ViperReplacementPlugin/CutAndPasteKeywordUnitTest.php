	<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperReplacementPlugin_CutAndPasteKeywordUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that keyword can cut and pasted.
     *
     * @return void
     */
    public function testCutAndPasteKeyword()
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
        
        $this->assertHTMLMatch('<p>((prop:productName))%1%</p><p>%2% %3%</p><p>%4% ((prop:productName))</p><p>%5% %6%</p>');
        $this->assertRawHTMLMatch('<p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>%1%</p><p>%2% %3%</p><p>%4% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% %6%</p>');
        
        // Middle of paragraph using keyboard shortcuts
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        
        $this->assertHTMLMatch('<p>((prop:productName))%1%</p><p>%2% %3%</p><p>%4% ((prop:productName))</p><p>%5% %6%</p>');
        $this->assertRawHTMLMatch('<p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>%1%</p><p>%2%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%</p><p>%4%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% %6%</p>');
        
        // End of paragraph using keyboard shortcuts
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        
        $this->assertHTMLMatch('<p>((prop:productName))%1%</p><p>%2%((prop:productName)) %3%((prop:productName))</p><p>%4%((prop:productName))</p><p>%5% %6%</p>');
        $this->assertRawHTMLMatch('<p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>%1%</p><p>%2%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%4%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%5% %6%</p>');
        
        // Beginning of paragraph using right click
        $this->moveToKeyword(4 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->cut(true);
        $this->moveToKeyword(4, 'left');
        $this->paste(true);
        
        $this->assertHTMLMatch('<p>((prop:productName))%1%</p><p>%2%((prop:productName)) %3%((prop:productName))</p><p>((prop:productName))%4%</p><p>%5% %6%</p>');
        $this->assertRawHTMLMatch('<p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>%1%</p><p>%2%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>%4%</p><p>%5% %6%</p>');
        
        // Middle of paragraph using right click
        $this->moveToKeyword(5, 'right');
        $this->paste(true);
        
        $this->assertHTMLMatch('<p>((prop:productName))%1%</p><p>%2%((prop:productName)) %3%((prop:productName))</p><p>((prop:productName))%4%</p><p>%5%((prop:productName)) %6%</p>');
        $this->assertRawHTMLMatch('<p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>%1% <span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p>%2%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>%4%</p><p>%5%<span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %6%</p>');
        
        // End of paragraph using right click
        $this->moveToKeyword(6, 'right');
        $this->paste(true);
        
        $this->assertHTMLMatch('<p>((prop:productName))%1% %3%((prop:productName))</p><p>((prop:productName))%4%</p><p>%5%((prop:productName)) %6%((prop:productName))</p>');
        $this->assertRawHTMLMatch('<p><span <keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>%1%</p><p>%2%<span <keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %3%<span <keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p><p><span <keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span>%4%</p><p>%5%<span <keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span> %6%<span <keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></p>');
        
    }//end testCutAndPasteKeyword()


    /**
     * Test that keyword with a link can cut and pasted.
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
        
        $this->assertHTMLMatch('<p><a href="www.squizlabs.com.au">((prop:productName))</a>%1%</p><p>%2% %3%</p><p>%4% <a href="www.squizlabs.com.au">((prop:productName))</a></p><p>%5% %6%</p>');
        $this->assertRawHTMLMatch('<p><a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a>%1%</p><p>%2% %3%</p><p>%4% <a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>%5% %6%</p>');
        
        // Middle of paragraph using keyboard shortcuts
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        
        $this->assertHTMLMatch('<p><a href="www.squizlabs.com.au">((prop:productName))</a>%1%</p><p>%2% %3%</p><p>%4% <a href="www.squizlabs.com.au">((prop:productName))</a></p><p>%5% %6%</p>');
        $this->assertRawHTMLMatch('<p><a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a>%1%</p><p>%2%<a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%</p><p>%4%<a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>%5% %6%</p>');
        
        // End of paragraph using keyboard shortcuts
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        
        $this->assertHTMLMatch('<p><a href="www.squizlabs.com.au">((prop:productName))</a>%1%</p><p>%2%<a href="www.squizlabs.com.au">((prop:productName))</a> %3%<a href="www.squizlabs.com.au">((prop:productName))</a></p><p>%4%<a href="www.squizlabs.com.au">((prop:productName))</a></p><p>%5% %6%</p>');
        $this->assertRawHTMLMatch('<p><a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a>%1%</p><p>%2%<a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%<a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>%4%<a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>%5% %6%</p>');
        
        // Beginning of paragraph using right click
        $this->moveToKeyword(4 , 'right');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->cut(true);
        $this->moveToKeyword(4, 'left');
        $this->paste(true);
        
        $this->assertHTMLMatch('<p><a href="www.squizlabs.com.au">((prop:productName))</a>%1%</p><p>%2%<a href="www.squizlabs.com.au">((prop:productName))</a> %3%<a href="www.squizlabs.com.au">((prop:productName))</a></p><p><a href="www.squizlabs.com.au">((prop:productName))</a>%4%</p><p>%5% %6%</p>');
        $this->assertRawHTMLMatch('<p><a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a>%1%</p><p>%2%<a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%<a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p><a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a>%4%</p><p>%5% %6%</p>');
        
        // Middle of paragraph using right click
        $this->moveToKeyword(5, 'right');
        $this->paste(true);
        
        $this->assertHTMLMatch('<p><a href="www.squizlabs.com.au">((prop:productName))</a>%1%</p><p>%2%<a href="www.squizlabs.com.au">((prop:productName))</a> %3%<a href="www.squizlabs.com.au">((prop:productName))</a></p><p><a href="www.squizlabs.com.au">((prop:productName))</a>%4%</p><p>%5%<a href="www.squizlabs.com.au">((prop:productName))</a> %6%</p>');
        $this->assertRawHTMLMatch('<p><a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a>%1% <a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p>%2%<a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %3%<a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a></p><p><a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a>%4%</p><p>%5%<a href="www.squizlabs.com.au"><span data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</span></a> %6%</p>');
        
        // End of paragraph using right click
        $this->moveToKeyword(6, 'right');
        $this->paste(true);
        
        $this->assertHTMLMatch('<p><a href="www.squizlabs.com.au">((prop:productName))</a>%1% %3%<a href="www.squizlabs.com.au">((prop:productName))</a></p><p><a href="www.squizlabs.com.au">((prop:productName))</a>%4%</p><p>%5%<a href="www.squizlabs.com.au">((prop:productName))</a> %6%<a href="www.squizlabs.com.au">((prop:productName))</a></p>');
        $this->assertRawHTMLMatch('<p><span <a href="www.squizlabs.com.au"><keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</a></span>%1%</p><p>%2%<span <a href="www.squizlabs.com.au"><keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</a></span> %3%<span <a href="www.squizlabs.com.au"><keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</a></span></p><p><span <a href="www.squizlabs.com.au"><keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</a></span>%4%</p><p>%5%<span <a href="www.squizlabs.com.au"><keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</a></span> %6%<span <a href="www.squizlabs.com.au"><keyword contenteditable="false" data-viper-keyword="((prop:productName))" title="((prop:productName))">Viper</a></span></p>');
        
    }//end testCopyAndPasteKeywordWithLink()
}