<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_ListsUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the Lists doc works correctly.
     *
     * @return void
     */
    public function testListsFromWord()
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/WordDocs/Lists.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/WordDocs/Lists.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/WordDocs/Lists.txt');
                        break;
                    default:
                        $this->fail('Testing for '.$this->sikuli->getBrowserid().' is not supported on osx for this test');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/WordDocs/Lists.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/WordDocs/Lists.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/WordDocs/Lists.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/WordDocs/Lists.txt');
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

    }//end testListsFromWord()


    /**
     * Test that copying/pasting from the Lists google works correctly.
     *
     * @return void
     */
    public function testListsFromGoogleDocs()
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/GoogleDocs/Lists.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/GoogleDocs/Lists.txt');
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
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/GoogleDocs/Lists.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/GoogleDocs/Lists.txt');
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/GoogleDocs/Lists.txt');
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/GoogleDocs/Lists.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/GoogleDocs/Lists.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/GoogleDocs/Lists.txt');
                        break;
                    default:
                        $this->fail('Testing for '.$this->sikuli->getBrowserid().' is not supported on Windows for this test');
                }//end switch
                break;
        }//end switch

        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + a');
        sleep(1);
        $this->sikuli->keyDown('Key.DELETE');
        sleep(1);
        $this->pasteFromURL($testFile);
        sleep(5);

        $this->assertHTMLMatch('<p>Complex number list one</p><ol><li style="list-style-type:decimal">Asdadsads<ul><li style="list-style-type:circle">Dsfsdfsfd</li><li style="list-style-type:circle">Sdfsdfsfd<ul><li style="list-style-type:square">Sfd</li><li style="list-style-type:square">Sfdsfd</li><li style="list-style-type:square">Dsfsdf</li><li style="list-style-type:square">sdfsdf</li></ul></li><li style="list-style-type:circle">Sdfsdfsfd</li><li style="list-style-type:circle">sdfsdfsfd</li></ul></li><li style="list-style-type:decimal">Asdadsasd</li><li style="list-style-type:decimal">Sfdsfds</li><li style="list-style-type:decimal">Asdasdasd</li><li style="list-style-type:decimal">Asdasdasd</li></ol><p>Complex number list two</p><ol><li style="list-style-type:decimal">One baby<ol><li style="list-style-type:lower-alpha">Sub baby<ol><li style="list-style-type:lower-roman">Sub sub baby!</li><li style="list-style-type:lower-roman">Sdfdsfsdf</li><li style="list-style-type:lower-roman">sdfsdfsdf</li></ol></li></ol></li><li style="list-style-type:decimal">Two baby<ol><li style="list-style-type:lower-alpha">Sdfsfdds</li><li style="list-style-type:lower-alpha">Sdfsfdsfd</li><li style="list-style-type:lower-alpha">sfdsdfsdf</li></ol></li><li style="list-style-type:decimal">Three baby</li><li style="list-style-type:decimal">Four</li></ol><p>Complex bulleted list one</p><ul><li style="list-style-type:disc">Sadsadasda<ul><li style="list-style-type:circle">Sdfdsf</li><li style="list-style-type:circle">Sdfsdfsdf<ul><li style="list-style-type:square">Sdfsfdsdf</li><li style="list-style-type:square">sdfsdfsdf</li></ul></li><li style="list-style-type:circle">Sdfsdfsfd</li><li style="list-style-type:circle">sdfsfdsdf</li></ul></li><li style="list-style-type:disc">Asdasdsad</li></ul><p>Complex bulleted list two</p><ul><li style="list-style-type:disc">One bullet<ul><li style="list-style-type:circle">Dsfsdfsdf<ul><li style="list-style-type:square">Sdfsfdsdf</li><li style="list-style-type:square">sdfsdf</li></ul></li></ul></li><li style="list-style-type:disc">Two bullet<ul><li style="list-style-type:circle">Dsfsfd</li><li style="list-style-type:circle">sdfsdfsf</li></ul></li><li style="list-style-type:disc">Three bullet</li><li style="list-style-type:disc">Four<ul><li style="list-style-type:circle">sdfsdfsfd</li></ul></li></ul><p>Paragraph with a number then an unordered list</p><p><strong>6. The solution</strong></p><ul><li style="list-style-type:disc">What did you deliver?</li><li style="list-style-type:disc">As well as the technical solution, also focus on the benefits that your product / service delivered - for every product feature you want to talk about, balance it with the corresponding benefit to your client</li><li style="list-style-type:disc">Did we do anything particularly cool?</li></ul><p>Complex list with numbers, letters and roman numerals</p><ol><li style="list-style-type:decimal">First item<ol><li style="list-style-type:lower-alpha">Sub item 1<ol><li style="list-style-type:lower-roman">Sub of sub item 1</li><li style="list-style-type:lower-roman">Sub of sub item 2</li></ol></li><li style="list-style-type:lower-alpha">Sub item 2</li></ol></li><li style="list-style-type:decimal">Second item</li><li style="list-style-type:decimal">Third Item<ol><li style="list-style-type:lower-alpha">Sub item 1</li></ol></li></ol><p>Complex list with roman numerals, letters and numbers</p><ol><li style="list-style-type:upper-roman">First item<ol><li style="list-style-type:upper-alpha">Sub item 1<ol><li style="list-style-type:decimal">Sub of sub item 1</li></ol></li><li style="list-style-type:upper-alpha">Sub item 2</li></ol></li><li style="list-style-type:upper-roman">Second item</li><li style="list-style-type:upper-roman">Third Item<ol><li style="list-style-type:upper-alpha">Sub item 1</li></ol></li></ol><p>Different list formats:</p><ol><li style="list-style-type:decimal">First item<ol><li style="list-style-type:decimal">Sub item 1<ol><li style="list-style-type:decimal">Sub of sub item 1</li></ol></li><li style="list-style-type:decimal">Sub item 2</li></ol></li><li style="list-style-type:decimal">Second item</li><li style="list-style-type:decimal">Third Item<ol><li style="list-style-type:decimal">Sub item 1</li></ol></li></ol><ul><li style="list-style-type:disc">First item<ul><li style="list-style-type:disc">Sub item 1<ul><li style="list-style-type:square">Sub of sub item 1</li></ul></li><li style="list-style-type:disc">Sub item 2</li></ul></li><li style="list-style-type:disc">Second item</li><li style="list-style-type:disc">Third Item<ul><li style="list-style-type:disc">Sub item 1</li></ul></li></ul><p>&nbsp;</p><ul><li style="list-style-type:disc">First item</li><li style="list-style-type:disc">Second item</li><li style="list-style-type:disc">Third item</li></ul><ul><li style="list-style-type:disc">First item</li><li style="list-style-type:disc">Second item</li><li style="list-style-type:disc">Third item</li></ul>');

    }//end testListsFromGoogleDocs()

}//end class

?>