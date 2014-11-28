<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_OrderedListsFormatsUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the OrderedListsFormats doc works correctly.
     *
     * @return void
     */
    public function testOrderedListsFormats()
    {
        $this->useTest(1);

        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/OrderedListsFormats.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/OrderedListsFormats.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/OrderedListsFormats.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/OrderedListsFormats.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/OrderedListsFormats.txt');
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/OrderedListsFormats.txt');
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/OrderedListsFormats.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/OrderedListsFormats.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/OrderedListsFormats.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on windows');
                }//end switch
                break;
        }//end switch

        $this->selectKeyword(1);
        $this->pasteFromURL($testFile);

       $this->assertHTMLMatch('<ol><li>First item</li><li>Second item</li><li>Third Item</li></ol><ol><li>First item</li><li>Second item</li><li>Third Item</li></ol><ol type="A"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="a"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="a"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="I"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="i"><li>First item</li><li>Second item</li><li>Third item</li></ol>');

    }//end testOrderedListsFormats()

}//end class

?>