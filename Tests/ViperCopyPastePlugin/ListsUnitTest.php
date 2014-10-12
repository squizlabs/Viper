<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_ListsUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the Lists works correctly for Firefox on OSX.
     *
     * @return void
     */
    public function testListsForOSXFirefox()
    {
        $this->runTestFor('osx', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/Lists.txt'));

    }//end testListsForOSXFirefox()


	/**
     * Test that copying/pasting from the Lists works correctly for Chrome on OSX.
     *
     * @return void
     */
    public function testListsForOSXChrome()
    {
        $this->runTestFor('osx', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/Lists.txt'));

    }//end testListsForOSXChrome()


	/**
     * Test that copying/pasting from the Lists works correctly for Safari on OSX.
     *
     * @return void
     */
    public function testListsForOSXSafari()
    {
        $this->runTestFor('osx', 'safari');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/Lists.txt'));

    }//end testListsForOSXSafari()
 

  	/**
     * Test that copying/pasting from the Lists works correctly for Firefox on Windows.
     *
     * @return void
     */
    public function testListsForWindowsFirefox()
    {
        $this->runTestFor('windows', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/Lists.txt'));

    }//end testListsForWindowsFirefox()
 

 	/**
     * Test that copying/pasting from the Lists works correctly for Chrome on Windows.
     *
     * @return void
     */
    public function testListsForWindowsChrome()
    {
        $this->runTestFor('windows', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/Lists.txt'));

    }//end testListsForWindowsChrome()

	/**
     * Test that copying/pasting from the Lists works correctly for IE8 on Windows.
     *
     * @return void
     */
    public function testListsForWindowsIE8()
    {
        $this->runTestFor('windows', 'ie8');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/Lists.txt'));

    }//end testListsForWindowsIE8()


	/**
     * Test that copying/pasting from the Lists works correctly for IE9 on Windows.
     *
     * @return void
     */
    public function testListsForWindowsIE9()
    {
        $this->runTestFor('windows', 'ie9');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/Lists.txt'));

    }//end testListsForWindowsIE9()


	/**
     * Test that copying/pasting from the Lists works correctly for IE10 on Windows.
     *
     * @return void
     */
    public function testListsForWindowsIE10()
    {
        $this->runTestFor('windows', 'ie10');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/Lists.txt'));

    }//end testListsForWindowsIE10()

	/**
     * Test that copying/pasting from the Lists works correctly for IE11 on Windows.
     *
     * @return void
     */
    public function testListsForWindowsIE11()
    {
        $this->runTestFor('windows', 'ie11');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/Lists.txt'));

    }//end testListsForWindowsIE11()


 	/**
     * Run the test for the Lists document.
     *
     * @param string $textFileURL The URL of the text file to use in the Unit Test.
     *
     * @return void
     */
    private function _runTest($textFileURL)
    {
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->pasteFromURL($textFileURL);

       $this->assertHTMLMatch('<p>Complex number list one</p><ol><li>Asdadsads<ul><li>Dsfsdfsfd</li><li>Sdfsdfsfd<ul><li>Sfd</li><li>Sfdsfd</li><li>Dsfsdf</li><li>sdfsdf</li></ul></li><li>Sdfsdfsfd</li><li>sdfsdfsfd</li></ul></li><li>Asdadsasd</li><li>Sfdsfds</li><li>Asdasdasd</li><li>Asdasdasd</li></ol><p>Complex number list two</p><ol><li>One baby<ol type="a"><li>Sub baby<ol type="i"><li>Sub sub baby!</li><li>Sdfdsfsdf</li><li>sdfsdfsdf</li></ol></li></ol></li><li>Two baby<ol type="a"><li>Sdfsfdds</li><li>Sdfsfdsfd</li><li>sfdsdfsdf</li></ol></li><li>Three baby</li><li>Four</li></ol><p>Complex bulleted list one</p><ul><li>Sadsadasda<ul><li>Sdfdsf</li><li>Sdfsdfsdf<ul><li>Sdfsfdsdf</li><li>sdfsdfsdf</li></ul></li><li>Sdfsdfsfd</li><li>sdfsfdsdf</li></ul></li><li>Asdasdsad</li></ul><p>Complex bulleted list two</p><ul><li>One bullet<ul><li>Dsfsdfsdf<ul><li>Sdfsfdsdf</li><li>sdfsdf</li></ul></li></ul></li><li>Two bullet<ul><li>Dsfsfd</li><li>sdfsdfsf</li></ul></li><li>Three bullet</li><li>Four<ul><li>sdfsdfsfd</li></ul></li></ul><p>Paragraph with a number then an unordered list</p><p><strong>6. The solution</strong></p><ul><li>What did you deliver?</li><li>As well as the technical solution, also focus on the benefits that your product / service delivered - for every product feature you want to talk about, balance it with the corresponding benefit to your client</li><li>Did we do anything particularly cool?</li></ul><p>Complex list with numbers, letters and roman numerals</p><ol><li>First item<ol type="a"><li>Sub item 1<ol type="i"><li>Sub of sub item 1</li><li>Sub of sub item 2</li></ol></li><li>Sub item 2</li></ol></li><li>Second item</li><li>Third Item<ol type="a"><li>Sub item 1</li></ol></li></ol><p>Complex list with roman numerals, letters and numbers</p><ol type="I"><li>First item<ol type="A"><li>Sub item 1<ol><li>Sub of sub item 1</li></ol></li><li>Sub item 2</li></ol></li><li>Second item</li><li>Third Item<ol type="A"><li>Sub item 1</li></ol></li></ol><p>Different list formats:</p><ol><li>First item<ol><li>Sub item 1<ol><li>Sub of sub item 1</li></ol></li><li>Sub item 2</li></ol></li><li>Second item</li><li>Third Item<ol><li>Sub item 1</li></ol></li></ol><ol><li>First item<ul><li>Sub item 1<ul><li>Sub of sub item 1</li></ul></li><li>Sub item 2</li></ul></li><li>Second item</li><li>Third Item<ul><li>Sub item 1</li></ul></li></ol><ol><li>First item<ol><li>Sub item 1<ol><li>Sub of sub item 1</li></ol></li><li>Sub item 2</li></ol></li><li>Second item</li><li>Third Item<ol><li>Sub item 1</li></ol></li></ol><p style="text-indent:-18.0pt"><img width="9" height="9" src="" alt="*" />&nbsp;&nbsp;&nbsp;&nbsp; First item</p><p style="text-indent:-18.0pt"><img width="9" height="9" src="" alt="*" />&nbsp;&nbsp;&nbsp;&nbsp; Second item</p><p style="text-indent:-18.0pt"><img width="9" height="9" src="" alt="*" />&nbsp;&nbsp;&nbsp;&nbsp; Third item</p><ol><li>First item</li><li>Second item</li><li>Third item</li></ol><ul><li>First item</li><li>Second item</li><li>Third item</li></ul><ul><li>First item</li><li>Second item</li><li>Third item</li></ul>');

    }//end _runTest()

}//end class

?>