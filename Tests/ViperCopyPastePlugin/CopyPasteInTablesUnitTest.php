<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyPasteInTablesUnitTest extends AbstractViperUnitTest
{
    /**
     * Test copy and paste for a table.
     *
     * @return void
     */
    public function testCopyAndPasteForTable()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);

        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<p>Lorem XAX</p><table border="1" style="width: 100%;"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p><p>eooee</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testCopyAndPasteForTable()


     /**
     * Test that copying/pasting from the HtmlTablesInPage works correctly.
     *
     * @return void
     */
    public function testHtmlTablesInPageCopyPaste()
    {
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->pasteFromURL($this->getTestURL('/ViperCopyPastePlugin/CopyPasteFiles/HtmlTablesInPage.txt'));

        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<h1>Viper Table Plugin Examples</h1><p>Insert &gt; None &gt; Manual insertion of non breaking space in each empty cell</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; Headers Left</p><table border="1" style="width: 100%;"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; Headers Top</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; Headers Both</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; None &gt; Custom Headers &gt; Top left and bottom right cells.</p><table border="1" style="width: 100%;"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><th></th></tr></tbody></table><p>Insert &gt; Headers Top &gt; Custom Heads &gt; Middle columns.</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><th></th><th></th><td></td></tr><tr><td></td><th></th><th></th><td></td></tr></tbody></table><p>Blah.</p>');

    }//end testHtmlTablesInPageCopyPaste()

}//end class

?>
