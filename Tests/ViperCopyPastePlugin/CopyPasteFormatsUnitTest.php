<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyPasteFormatsUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that you can copy and paste inside different formats.
     *
     * @return void
     */
    public function testCopyAndPasteInsideFormats()
    {
        // Test copy and paste inside a pre section
        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2%%1% to test %2%</pre>');

        // Test copy and paste inside a div section
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%%1% to test %2%</div>');

        // Test copy and paste inside a quoote section
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<blockquote><p>Lorum this is more content %1% to test %2%%1% to test %2%</p></blockquote>');

        // Test copy and paste inside a p section
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>Lorum this is more content %1% to test %2%%1% to test %2%</p>');

    }//end testCopyAndPasteInsideFormats()


    /**
     * Test copy and paste a section of different formats.
     *
     * @return void
     */
    public function testCopyAndPasteASectionOfAFormat()
    {
        // Test copyd and paste a pre section
        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2%</pre><p>%1% to test %2%</p>');

        // Test copy and paste a div section
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%</div><p>%1% to test %2%</p>');

        // Test copy and paste a quote section
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<blockquote><p>Lorum this is more content %1% to test %2%</p><p>%1% to test %2%</p></blockquote>');

        // Test copy and paste a paragraph section
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>Lorum this is more content %1% to test %2%</p><p>%1% to test %2%</p>');

    }//end testCopyAndPasteASectionOfAFormat()


    /**
     * Test copy and paste a format section.
     *
     * @return void
     */
    public function testCopyAndPasteFormats()
    {
        // Test copyd and paste a pre
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2%</pre><pre>Lorum this is more content %1% to test %2%</pre>');

        // Test copy and paste a div section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%</div><div>Lorum this is more content %1% to test %2%</div>');

        // Test copy and paste a quote section
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<blockquote><p>Lorum this is more content %1% to test %2%</p></blockquote><blockquote><p>Lorum this is more content %1% to test %2%</p></blockquote>');

        // Test copy and paste a paragraph section
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>Lorum this is more content %1% to test %2%</p><p>Lorum this is more content %1% to test %2%</p>');

    }//end testCopyAndPasteASectionOfAFormats()


    /**
     * Test copy and paste a Pre section inside a pre section.
     *
     * @return void
     */
    public function testCopyAndPastePreFormat()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->type('First paste ');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2% First paste Lorum this is more content %1% to test %2%</pre>');

        // Paste again to make sure the character is still there
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->type('Second paste ');
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2% First paste Lorum this is more content %1% to test %2% Second Paste Lorum this is more content %1% to test %2%</pre>');

        // Paste again in a new pre section
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2% First paste Lorum this is more content %1% to test %2% Second paste Lorum this is more content %1% to test %2%</pre><pre>Lorum this is more content %1% to test %2%</pre>');

    }//end testCopyAndPastePreFormat()


}//end class

?>
