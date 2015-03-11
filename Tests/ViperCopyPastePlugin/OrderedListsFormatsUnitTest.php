<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_OrderedListsFormatsUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the OrderedListsFormats word doc works correctly.
     *
     * @return void
     */
    public function testOrderedListsFormatsFromWord()
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/WordDocs/OrderedListsFormats.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/WordDocs/OrderedListsFormats.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/WordDocs/OrderedListsFormats.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/WordDocs/OrderedListsFormats.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/WordDocs/OrderedListsFormats.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/WordDocs/OrderedListsFormats.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/WordDocs/OrderedListsFormats.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on windows');
                }//end switch
                break;
        }//end switch

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->pasteFromURL($testFile);
        sleep(5);

       $this->assertHTMLMatch('<ol><li>First item</li><li>Second item</li><li>Third Item</li></ol><ol><li>First item</li><li>Second item</li><li>Third Item</li></ol><ol type="A"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="a"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="a"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="I"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="i"><li>First item</li><li>Second item</li><li>Third item</li></ol>');

    }//end testOrderedListsFormatsFromWord()


    /**
     * Test that copying/pasting from the OrderedListsFormats google doc works correctly.
     *
     * @return void
     */
    public function testOrderedListsFormatsFromGoogleDoc()
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/GoogleDocs/OrderedListsFormats.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/GoogleDocs/OrderedListsFormats.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/GoogleDocs/OrderedListsFormats.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/GoogleDocs/OrderedListsFormats.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/GoogleDocs/OrderedListsFormats.txt');
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/GoogleDocs/OrderedListsFormats.txt');
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/GoogleDocs/OrderedListsFormats.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/GoogleDocs/OrderedListsFormats.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/GoogleDocs/OrderedListsFormats.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on windows');
                }//end switch
                break;
        }//end switch

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');
        $this->pasteFromURL($testFile);
        sleep(5);

       $this->assertHTMLMatch('<ol><li style="list-style-type:decimal">First item</li><li style="list-style-type:decimal">Second item</li><li style="list-style-type:decimal">Third Item</li></ol><ol><li style="list-style-type:decimal">First item</li><li style="list-style-type:decimal">Second item</li><li style="list-style-type:decimal">Third Item</li></ol><ol><li style="list-style-type:upper-alpha">First item</li><li style="list-style-type:upper-alpha">Second item</li><li style="list-style-type:upper-alpha">Third item</li></ol><ol><li style="list-style-type:upper-roman">First item</li><li style="list-style-type:upper-roman">Second item</li><li style="list-style-type:upper-roman">Third item</li></ol><ol><li style="list-style-type:decimal-leading-zero">First item</li><li style="list-style-type:decimal-leading-zero">Second item</li><li style="list-style-type:decimal-leading-zero">Third item</li></ol>');

    }//end testOrderedListsFormatsFromGoogleDoc()

}//end class

?>