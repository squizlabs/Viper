<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CursorAssistWithWordDocUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that copying/pasting from the CursorAssistWithWordDoc, using the cursor assist and the pasting again works correctly.
     *
     * @return void
     */
    public function testUsingCursorAssistWhenPastingContent()
    {
        $this->useTest(1);

        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/CursorAssistWithWordDoc.txt');
                        break;
                    case 'firefoxNightly':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefoxNightly/CursorAssistWithWordDoc.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/CursorAssistWithWordDoc.txt');
                        break;
                    case 'chromeCanary':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChromium/CursorAssistWithWordDoc.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/CursorAssistWithWordDoc.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/CursorAssistWithWordDoc.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/CursorAssistWithWordDoc.txt');
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/CursorAssistWithWordDoc.txt');
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/CursorAssistWithWordDoc.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/CursorAssistWithWordDoc.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/CursorAssistWithWordDoc.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on windows');
                }//end switch
                break;
        }//end switch

        // Paste the word document in the content
        $this->selectKeyword(1);
        $this->pasteFromURL($testFile);
        $this->assertHTMLMatch('<p>This is some basic content to test copy and paste when using the cursor assist feature in viper.</p><table border="1" style="width: 100%;"><tbody><tr><td><p>Cell 1</p></td><td><p>Cell 2</p></td><td><p>Cell 3</p></td></tr><tr><td><p>Cell 4</p></td><td><p>Cell 5</p></td><td><p>Cell 6</p></td></tr></tbody></table>');

        // Click the cursor assist icon 
        $this->moveMouseToElement('table', 'bottom');
        $this->clickCursorAssistLine();

        // Paste the word document again to make sure the attributes are removed
        $this->pasteFromURL($testFile);
        $this->assertHTMLMatch('<p>This is some basic content to test copy and paste when using the cursor assist feature in viper.</p><table border="1" style="width:100%;"><tbody><tr><td><p>Cell 1</p></td><td><p>Cell 2</p></td><td><p>Cell 3</p></td></tr><tr><td><p>Cell 4</p></td><td><p>Cell 5</p></td><td><p>Cell 6</p></td></tr></tbody></table><p>This is some basic content to test copy and paste when using the cursor assist feature in viper.</p><table border="1" style="width:100%;"><tbody><tr><td><p>Cell 1</p></td><td><p>Cell 2</p></td><td><p>Cell 3</p></td></tr><tr><td><p>Cell 4</p></td><td><p>Cell 5</p></td><td><p>Cell 6</p></td></tr></tbody></table>');

    }//end testUsingCursorAssistWhenPastingContent()

}//end class

?>