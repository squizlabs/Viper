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
        sleep(2);
        $this->selectInlineToolbarLineageItem(0);
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);

        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<p>Lorem %1%</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>test</td><td>sapien %2% vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet %3%</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table><p>sit amet <strong>consectetur</strong></p><p>eooee</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>test</td><td>sapien %2% vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet %3%</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

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


    /**
     * Test copying and pasting content from a table.
     *
     * @return void
     */
    public function testCopyAndPasteContentFromTable()
    {
        // Copy and paste content inside table
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->sikuli->keyDown('Key.CMD + c');
        
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);

        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<p>Lorem %1%</p><p>sit amet <strong>consectetur</strong></p><p>eooee</p><table cellspacing="0" cellpadding="3" border="1"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>test</td><td>sapien %2% vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet %3%<br />sapien %2% vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Paste content outside table
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);

        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<p>Lorem %1%</p><p>sapien %2% vel aliquet</p><p>sit amet <strong>consectetur</strong></p><p>eooee</p><table cellspacing="0" cellpadding="3" border="1"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>test</td><td>sapien %2% vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet %3%<br />sapien %2% vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Copy and paste a row from the table outside the table
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->sikuli->keyDown('Key.CMD + c');
        
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);

        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<p>Lorem %1%</p><table border="1" style="width: 100%;"><tbody><tr><td>test</td><td>sapien %2% vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr></tbody></table><p>sapien %2% vel aliquet</p><p>sit amet <strong>consectetur</strong></p><p>eooee</p><table cellspacing="0" cellpadding="3" border="1"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>test</td><td>sapien %2% vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet %3%<br />sapien %2% vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Paste the row from the table inside the table        
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);

        $this->removeTableHeaders();
        sleep(1);
        $this->assertHTMLMatch('<p>Lorem %1%</p><table border="1" style="width:100%;"><tbody><tr><td>test</td><td>sapien %2% vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr></tbody></table><p>sapien %2% vel aliquet</p><p>sit amet<strong>consectetur</strong></p><p>eooee</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>test</td><td>sapien %2% vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec<strong>porta</strong> ante</td><td><p>sapien vel aliquet %3%<br /></p>testsapien %2% vel aliquet<ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul><p><br /><br />sapien %2% vel aliquet</p></td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testCopyAndPasteContentFromTable()

}//end class

?>
