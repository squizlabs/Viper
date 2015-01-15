<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_ListsUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the Lists doc works correctly.
     *
     * @return void
     */
    public function testLists()
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/Lists.txt');
                        break;
                    case 'firefoxNightly':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefoxNightly/Lists.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/Lists.txt');
                        break;
                    case 'chromeCanary':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChromeCanary/Lists.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/Lists.txt');
                        break;
                    default:
                        $this->fail('Testing for '.$this->sikuli->getBrowserid().' is not supported on osx for this test');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/Lists.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/Lists.txt');
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/Lists.txt');
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/Lists.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/Lists.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/Lists.txt');
                        break;
                    default:
                        $this->fail('Testing for '.$this->sikuli->getBrowserid().' is not supported on Windows for this test');
                }//end switch
                break;
        }//end switch

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        $this->sikuli->keyDown('Key.DELETE');

        $this->pasteFromURL($testFile);
        sleep(5);

        $this->assertHTMLMatch('<p>Complex number list one</p><ol><li>Asdadsads<ul><li>Dsfsdfsfd</li><li>Sdfsdfsfd<ul><li>Sfd</li><li>Sfdsfd</li><li>Dsfsdf</li><li>sdfsdf</li></ul></li><li>Sdfsdfsfd</li><li>sdfsdfsfd</li></ul></li><li>Asdadsasd</li><li>Sfdsfds</li><li>Asdasdasd</li><li>Asdasdasd</li></ol><p>Complex number list two</p><ol><li>One baby<ol type="a"><li>Sub baby<ol type="i"><li>Sub sub baby!</li><li>Sdfdsfsdf</li><li>sdfsdfsdf</li></ol></li></ol></li><li>Two baby<ol type="a"><li>Sdfsfdds</li><li>Sdfsfdsfd</li><li>sfdsdfsdf</li></ol></li><li>Three baby</li><li>Four</li></ol><p>Complex bulleted list one</p><ul><li>Sadsadasda<ul><li>Sdfdsf</li><li>Sdfsdfsdf<ul><li>Sdfsfdsdf</li><li>sdfsdfsdf</li></ul></li><li>Sdfsdfsfd</li><li>sdfsfdsdf</li></ul></li><li>Asdasdsad</li></ul><p>Complex bulleted list two</p><ul><li>One bullet<ul><li>Dsfsdfsdf<ul><li>Sdfsfdsdf</li><li>sdfsdf</li></ul></li></ul></li><li>Two bullet<ul><li>Dsfsfd</li><li>sdfsdfsf</li></ul></li><li>Three bullet</li><li>Four<ul><li>sdfsdfsfd</li></ul></li></ul><p>Paragraph with a number then an unordered list</p><p><strong>6. The solution</strong></p><ul><li>What did you deliver?</li><li>As well as the technical solution, also focus on the benefits that your product / service delivered - for every product feature you want to talk about, balance it with the corresponding benefit to your client</li><li>Did we do anything particularly cool?</li></ul><p>Complex list with numbers, letters and roman numerals</p><ol><li>First item<ol type="a"><li>Sub item 1<ol type="i"><li>Sub of sub item 1</li><li>Sub of sub item 2</li></ol></li><li>Sub item 2</li></ol></li><li>Second item</li><li>Third Item<ol type="a"><li>Sub item 1</li></ol></li></ol><p>Complex list with roman numerals, letters and numbers</p><ol type="I"><li>First item<ol type="A"><li>Sub item 1<ol><li>Sub of sub item 1</li></ol></li><li>Sub item 2</li></ol></li><li>Second item</li><li>Third Item<ol type="A"><li>Sub item 1</li></ol></li></ol><p>Different list formats:</p><ol><li>First item<ol><li>Sub item 1<ol><li>Sub of sub item 1</li></ol></li><li>Sub item 2</li></ol></li><li>Second item</li><li>Third Item<ol><li>Sub item 1</li></ol></li></ol><ul><li>First item<ul><li>Sub item 1<ul><li>Sub of sub item 1</li></ul></li><li>Sub item 2</li></ul></li><li>Second item</li><li>Third Item<ul><li>Sub item 1</li></ul></li></ul><ol><li>First item<ol><li>Sub item 1<ol><li>Sub of sub item 1</li></ol></li><li>Sub item 2</li></ol></li><li>Second item</li><li>Third Item<ol><li>Sub item 1</li></ol></li></ol><ul><li>First item</li><li>Second item</li><li>Third item</li></ul><ul><li>First item</li><li>Second item</li><li>Third item</li></ul><ul><li>First item</li><li>Second item</li><li>Third item</li></ul>');


    }//end testLists()

}//end class

?>