<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CursorAssistWithWordDocUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that copying/pasting from the CursorAssistDoc, using the cursor assist and the pasting again works correctly.
     *
     * @return void
     */
    public function testUsingCursorAssistWhenPastingContentFromWord()
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/WordDocs/CursorAssistDoc.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/WordDocs/CursorAssistDoc.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/WordDocs/CursorAssistDoc.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/WordDocs/CursorAssistDoc.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/WordDocs/CursorAssistDoc.txt');
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/WordDocs/CursorAssistDoc.txt');
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/WordDocs/CursorAssistDoc.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/WordDocs/CursorAssistDoc.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/WordDocs/CursorAssistDoc.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on windows');
                }//end switch
                break;
        }//end switch

        // Paste the word document in the content
        $this->selectKeyword(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + a');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->pasteFromURL($testFile);
        sleep(5);
        $this->assertHTMLMatch('<p>This is some basic content to test copy and paste when using the cursor assist feature in viper.</p><table border="1" style="width: 100%;"><tbody><tr><td><p>Cell 1</p></td><td><p>Cell 2</p></td><td><p>Cell 3</p></td></tr><tr><td><p>Cell 4</p></td><td><p>Cell 5</p></td><td><p>Cell 6</p></td></tr></tbody></table>');

        // Click the cursor assist icon 
        $this->moveMouseToElement('table', 'bottom');
        $this->clickCursorAssistLine();

        // Paste the word document again to make sure the attributes are removed
        $this->pasteFromURL($testFile);
        sleep(5);
        $this->assertHTMLMatch('<p>This is some basic content to test copy and paste when using the cursor assist feature in viper.</p><table border="1" style="width:100%;"><tbody><tr><td><p>Cell 1</p></td><td><p>Cell 2</p></td><td><p>Cell 3</p></td></tr><tr><td><p>Cell 4</p></td><td><p>Cell 5</p></td><td><p>Cell 6</p></td></tr></tbody></table><p>This is some basic content to test copy and paste when using the cursor assist feature in viper.</p><table border="1" style="width:100%;"><tbody><tr><td><p>Cell 1</p></td><td><p>Cell 2</p></td><td><p>Cell 3</p></td></tr><tr><td><p>Cell 4</p></td><td><p>Cell 5</p></td><td><p>Cell 6</p></td></tr></tbody></table>');

    }//end testUsingCursorAssistWhenPastingContentFromWord()


    /**
     * Test that copying/pasting from the CursorAssistDoc in Google Docs, using the cursor assist and the pasting again works correctly.
     *
     * @return void
     */
    public function testUsingCursorAssistWhenPastingContentFromGoogleDocs()
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/GoogleDocs/CursorAssistDoc.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/GoogleDocs/CursorAssistDoc.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/GoogleDocs/CursorAssistDoc.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/GoogleDocs/CursorAssistDoc.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/GoogleDocs/CursorAssistDoc.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/GoogleDocs/CursorAssistDoc.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/GoogleDocs/CursorAssistDoc.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on windows');
                }//end switch
                break;
        }//end switch

        // Paste the word document in the content
        $this->selectKeyword(1);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + a');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->pasteFromURL($testFile);
        sleep(5);
        $this->assertHTMLMatch('<p>This is some basic content to test copy and paste when using the cursor assist feature in viper.</p><div><table style="border:none; border-collapse:collapse;"><colgroup><col width="197"><col width="197"><col width="198"></colgroup><tbody><tr style="height:0px;"><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p>Cell 1</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p>Cell 2</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p>Cell 3</p></td></tr><tr style="height:0px;"><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p>Cell 4</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p>Cell 5</p></td><td style="border-bottom:solid #000000 1px; border-left:solid #000000 1px; border-right:solid #000000 1px; border-top:solid #000000 1px; padding:7px 7px 7px 7px;"><p>Cell 6</p></td></tr></tbody></table></div>');

        // Click the cursor assist icon 
        $this->moveMouseToElement('table', 'bottom');
        sleep(5);
        $this->clickCursorAssistLine();

        // Paste the word document again to make sure the attributes are removed
        $this->pasteFromURL($testFile);
        sleep(5);
        $this->assertHTMLMatch('<p>This is some basic content to test copy and paste when using the cursor assist feature in viper.</p><table border="1" style="width:100%;"><tbody><tr><td><p>Cell 1</p></td><td><p>Cell 2</p></td><td><p>Cell 3</p></td></tr><tr><td><p>Cell 4</p></td><td><p>Cell 5</p></td><td><p>Cell 6</p></td></tr></tbody></table><p>This is some basic content to test copy and paste when using the cursor assist feature in viper.</p><table border="1" style="width:100%;"><tbody><tr><td><p>Cell 1</p></td><td><p>Cell 2</p></td><td><p>Cell 3</p></td></tr><tr><td><p>Cell 4</p></td><td><p>Cell 5</p></td><td><p>Cell 6</p></td></tr></tbody></table>');

    }//end testUsingCursorAssistWhenPastingContentFromGoogleDocs()

}//end class

?>