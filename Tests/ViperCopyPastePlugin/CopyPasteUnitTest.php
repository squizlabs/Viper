<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyPasteUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that copying/pasting a simple text works.
     *
     * @return void
     */
    public function testSimpleTextCopyPaste()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        sleep(1);
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + v');
        $this->type('A');
        sleep(1);
        $this->keyDown('Key.CMD + v');
        $this->type('B');
        sleep(1);
        $this->keyDown('Key.CMD + v');
        $this->type('C');

        $this->assertHTMLMatch('<p>%1%A%1%B%1%C</p>');

    }//end testSimpleTextCopyPaste()


    /**
     * Test that copying/pasting bold text works.
     *
     * @return void
     */
    public function testBoldTextCopyPaste()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        sleep(1);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + v');
        $this->type('A');
        sleep(1);
        $this->keyDown('Key.CMD + v');
        $this->type('B');
        sleep(1);
        $this->keyDown('Key.CMD + v');
        $this->type('C');
        sleep(1);

        $this->assertHTMLMatch('<p><strong>%1%A%1%B%1%C</strong></p>');

    }//end testBoldTextCopyPaste()


   /**
     * Test that copying/pasting italic text works.
     *
     * @return void
     */
    public function testItalicTextCopyPaste()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        sleep(1);
        $this->keyDown('Key.CMD + i');
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + v');
        $this->type('A');
        sleep(1);
        $this->keyDown('Key.CMD + v');
        $this->type('B');
        sleep(1);
        $this->keyDown('Key.CMD + v');
        $this->type('C');
        sleep(1);

        $this->assertHTMLMatch('<p><em>%1%A%1%B%1%C</em></p>');

    }//end testItalicTextCopyPaste()


    /**
     * Test that you can copy and paste in a PRE tag.
     *
     * @return void
     */
    public function testCopyAndPasteInPreTag()
    {
        $this->useTest(2);

        // Change paragraph to pre
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2%</pre>');

        // Test copy and paste
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.CMD + v');
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

        // Change paragraph to div
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%</div>');

        // Test copy and paste
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.CMD + v');
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
        $this->useTest(2);

        // Change paragraph to blockquote
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>Lorum this is more content %1% to test %2%</p></blockquote>');

        // Test copy and paste
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.CMD + v');
        sleep(1);

        $this->assertHTMLMatch('<blockquote><p>Lorum this is more content %1% to test %2%%1% to test %2%</p></blockquote>');

    }//end testCopyAndPasteInQuoteTag()


    /**
     * Test copy and paste for a paragraph.
     *
     * @return void
     */
    public function testCopyAndPasteForAParagraphSection()
    {
        $this->useTest(2);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->keyDown('Key.CMD + c');

        $this->click($this->findKeyword(1));
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>Lorum this is more content %1% to test %2%</p><p>Lorum this is more content %1% to test %2%</p>');

    }//end testCopyAndPasteForAParagraph()


    /**
     * Test copy and paste for a div.
     *
     * @return void
     */
    public function testCopyAndPasteForADivSection()
    {
        $this->useTest(2);

        // Change paragraph to div
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('DIV', NULL, TRUE);
        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%</div>');

        // Test copy and paste
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->keyDown('Key.CMD + c');

        $this->click($this->findKeyword(1));
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%</div><p>Lorum this is more content %1% to test %2%</p>');

    }//end testCopyAndPasteForADiv()


    /**
     * Test copy and paste for a quote.
     *
     * @return void
     */
    public function testCopyAndPasteForAQuoteSection()
    {
        $this->useTest(2);

        // Change paragraph to quote
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('Quote', NULL, TRUE);
        $this->assertHTMLMatch('<blockquote><p>Lorum this is more content %1% to test %2%</p></blockquote>');

        // Test copy and paste
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->keyDown('Key.CMD + c');

        $this->click($this->findKeyword(1));
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<blockquote><p>Lorum this is more content %1% to test %2%</p><p>Lorum this is more content %1% to test %2%</p></blockquote>');

    }//end testCopyAndPasteForAQuote()


    /**
     * Test copy and paste for a pre.
     *
     * @return void
     */
    public function testCopyAndPasteForAPreSection()
    {
        $this->useTest(2);

        // Change paragraph to pre
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2%</pre>');

        // Test copy and paste
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->keyDown('Key.CMD + c');

        $this->click($this->findKeyword(1));
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<pre>Lorum this is more content %1% to test %2%</pre><p>Lorum this is more content %1% to test %2%</p>');

    }//end testCopyAndPasteForAPre()


    /**
     * Test copy and paste for a table.
     *
     * @return void
     */
    public function testCopyAndPasteForTable()
    {
        $this->useTest(4);

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->keyDown('Key.CMD + c');

        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');
        sleep(1);

        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<p>Lorem XAX</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table><p></p><p>sit amet <strong>consectetur</strong></p><p>eooee</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Check that the cursor is under the new table
        $this->type('type some more content');
        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<p>Lorem XAX</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table><p>type some more content</p><p>sit amet <strong>consectetur</strong></p><p>eooee</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testCopyAndPasteForTable()


    /**
     * Test that copying/pasting from the HtmlTablesInPage works correctly.
     *
     * @return void
     */
    public function testHtmlTablesInPageCopyPaste()
    {
        $this->useTest(1);

        // Open HTML doc, copy its contents.
        if ($this->openFile(dirname(__FILE__).'/HtmlTablesInPage.html', $this->getBrowserName()) === FALSE) {
            $this->markTestSkipped('MS Word is not available');
        }

        sleep(2);

        // Copy text.
        $this->keyDown('Key.CMD + a');
        sleep(1);
        $this->keyDown('Key.CMD + c');
        sleep(1);
        $this->closeApp($this->getBrowserName());
        sleep(1);

        $this->selectKeyword(1);

        $this->keyDown('Key.CMD + v');

        sleep(5);

        $this->removeTableHeaders();
        sleep(1);

        $this->assertHTMLMatch('<h1>Viper Table Plugin Examples</h1><p>Insert &gt; None &gt; Manual insertion of non breaking space in each empty cell</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; Headers Left</p><table border="1" style="width: 100%;"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; Headers Top</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; Headers Both</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; None &gt; Custom Headers &gt; Top left and bottom right cells.</p><table border="1" style="width: 100%;"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><th></th></tr></tbody></table><p>Insert &gt; Headers Top &gt; Custom Heads &gt; Middle columns.</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><th></th><th></th><td></td></tr><tr><td></td><th></th><th></th><td></td></tr></tbody></table><p>Blah.</p>');

    }//end testSpecialCharactersDocCopyPaste()


    /**
     * Test that right click menu and paste works.
     *
     * @return void
     */
    public function testRightClickPaste()
    {
        $this->useTest(3);

        $this->selectKeyword(1);
        sleep(1);
        $this->keyDown('Key.CMD + c');

        $this->selectKeyword(2);
        $this->paste(TRUE);

        sleep(1);
        $this->assertHTMLMatch('<p>test %1% test %1%</p>');

    }//end testRightClickPaste()


}//end class

?>
