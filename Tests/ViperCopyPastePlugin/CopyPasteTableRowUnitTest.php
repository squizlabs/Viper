<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyPasteTableRowUnitTest extends AbstractViperTableEditorPluginUnitTest
{

/**
     * Test that copying/pasting part of a row from word works.
     *
     * @return void
     */
    public function testCopyPasteTableRow()
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/WordDocs/TableRowForPartialCopyPaste.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/WordDocs/TableRowForPartialCopyPaste.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/WordDocs/TableRowForPartialCopyPaste.txt');
                        break;
                    default:
                        $this->fail('Testing for '.$this->sikuli->getBrowserid().' is not supported on osx for this test');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/WordDocs/TableRowForPartialCopyPaste.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/WordDocs/TableRowForPartialCopyPaste.txt');
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/WordDocs/TableRowForPartialCopyPaste.txt');
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/WordDocs/TableRowForPartialCopyPaste.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/WordDocs/TableRowForPartialCopyPaste.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/WordDocs/TableRowForPartialCopyPaste.txt');
                        break;
                    default:
                        $this->fail('Testing for '.$this->sikuli->getBrowserid().' is not supported on Windows for this test');
                }//end switch
                break;
        }//end switch

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        sleep(2);

        $this->pasteFromURL($testFile);
        sleep(5);
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table cellpadding="2" cellspacing="3"><thead><tr><th>Header 1</th><th>Header 2</th><th>Header 3</th></tr></thead><tbody><tr><td><p>New Cell 1</p></td><td><p>New Cell 2</p></td><td><p>New Cell 3</p></td></tr><tr><td>Cell 4</td><td>Cell 5</td><td>Cell 6</td></tr></tbody></table>');

    }//end testCopyPasteTableRow()

}//end class

?>