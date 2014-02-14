<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyPasteInFormatsUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that you can copy and paste in a PRE tag.
     *
     * @return void
     */
    public function testCopyAndPasteInPreTag()
    {
        $this->useTest(1);

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);

        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2%%1% to test %2%</pre>');

    }//end testCopyAndPasteInPreTag()


    /**
     * Test that you can copy and paste in a Div tag.
     *
     * @return void
     */
    public function testCopyAndPasteInDivTag()
    {
        $this->useTest(2);

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);

        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%%1% to test %2%</div>');

    }//end testCopyAndPasteInDivTag()


    /**
     * Test that you can copy and paste in a Quote tag.
     *
     * @return void
     */
    public function testCopyAndPasteInQuoteTag()
    {
        $this->useTest(3);

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);

        $this->assertHTMLMatch('<blockquote><p>Lorum this is more content %1% to test %2%%1% to test %2%</p></blockquote>');

    }//end testCopyAndPasteInQuoteTag()


    /**
     * Test that you can copy and paste in a P tag.
     *
     * @return void
     */
    public function testCopyAndPasteInPTag()
    {
        $this->useTest(4);

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);

        $this->assertHTMLMatch('<p>Lorum this is more content %1% to test %2%%1% to test %2%</p>');

    }//end testCopyAndPasteInPTag()


    /**
     * Test copy and paste for a paragraph.
     *
     * @return void
     */
    public function testCopyAndPasteForAParagraphSection()
    {
        $this->useTest(4);

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>Lorum this is more content %1% to test %2%</p><p>%1% to test %2%</p>');

    }//end testCopyAndPasteForAParagraph()


    /**
     * Test copy and paste for a div.
     *
     * @return void
     */
    public function testCopyAndPasteForADivSection()
    {
        $this->useTest(2);

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%</div><p>%1% to test %2%</p>');

    }//end testCopyAndPasteForADivSection()


    /**
     * Test copy and paste for a quote.
     *
     * @return void
     */
    public function testCopyAndPasteForAQuoteSection()
    {
        $this->useTest(3);

        // Test copy and paste
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<blockquote><p>Lorum this is more content %1% to test %2%</p><p>%1% to test %2%</p></blockquote>');

    }//end testCopyAndPasteForAQuoteSection()


    /**
     * Test copy and paste for a pre.
     *
     * @return void
     */
    public function testCopyAndPasteForAPreSection()
    {
        $this->useTest(1);

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2%</pre><pre>%1% to test %2%</pre>');

    }//end testCopyAndPasteForAPreSection()

}//end class

?>
