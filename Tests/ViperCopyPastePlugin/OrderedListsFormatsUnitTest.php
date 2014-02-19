<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_OrderedListsFormatsUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the OrderedListsFormats works correctly for Firefox on OSX.
     *
     * @return void
     */
    public function testOrderedListsFormatsForOSXFirefox()
    {
        $this->runTestFor('osx', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/OrderedListsFormats.txt'));

    }//end testOrderedListsFormatsForOSXFirefox()


	/**
     * Test that copying/pasting from the OrderedListsFormats works correctly for Chrome on OSX.
     *
     * @return void
     */
    public function testOrderedListsFormatsForOSXChrome()
    {
        $this->runTestFor('osx', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/OrderedListsFormats.txt'));

    }//end testOrderedListsFormatsForOSXChrome()


	/**
     * Test that copying/pasting from the OrderedListsFormats works correctly for Safari on OSX.
     *
     * @return void
     */
    public function testOrderedListsFormatsForOSXSafari()
    {
        $this->runTestFor('osx', 'safari');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/OrderedListsFormats.txt'));

    }//end testOrderedListsFormatsForOSXSafari()
 

  	/**
     * Test that copying/pasting from the OrderedListsFormats works correctly for Firefox on Windows.
     *
     * @return void
     */
    public function testOrderedListsFormatsForWindowsFirefox()
    {
        $this->runTestFor('windows', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/OrderedListsFormats.txt'));

    }//end testOrderedListsFormatsForWindowsFirefox()
 

 	/**
     * Test that copying/pasting from the OrderedListsFormats works correctly for Chrome on Windows.
     *
     * @return void
     */
    public function testOrderedListsFormatsForWindowsChrome()
    {
        $this->runTestFor('windows', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/OrderedListsFormats.txt'));

    }//end testOrderedListsFormatsForWindowsChrome()

	/**
     * Test that copying/pasting from the OrderedListsFormats works correctly for IE8 on Windows.
     *
     * @return void
     */
    public function testOrderedListsFormatsForWindowsIE8()
    {
        $this->runTestFor('windows', 'ie8');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/OrderedListsFormats.txt'));

    }//end testOrderedListsFormatsForWindowsIE8()


	/**
     * Test that copying/pasting from the OrderedListsFormats works correctly for IE9 on Windows.
     *
     * @return void
     */
    public function testOrderedListsFormatsForWindowsIE9()
    {
        $this->runTestFor('windows', 'ie9');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/OrderedListsFormats.txt'));

    }//end testOrderedListsFormatsForWindowsIE9()


	/**
     * Test that copying/pasting from the OrderedListsFormats works correctly for IE10 on Windows.
     *
     * @return void
     */
    public function testOrderedListsFormatsForWindowsIE10()
    {
        $this->runTestFor('windows', 'ie10');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/OrderedListsFormats.txt'));

    }//end testOrderedListsFormatsForWindowsIE10()

	/**
     * Test that copying/pasting from the OrderedListsFormats works correctly for IE11 on Windows.
     *
     * @return void
     */
    public function testOrderedListsFormatsForWindowsIE11()
    {
        $this->runTestFor('windows', 'ie11');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/OrderedListsFormats.txt'));

    }//end testOrderedListsFormatsForWindowsIE11()


 	/**
     * Run the test for the OrderedListsFormats document.
     *
     * @param string $textFileURL The URL of the text file to use in the Unit Test.
     *
     * @return void
     */
    private function _runTest($textFileURL)
    {
        $this->selectKeyword(1);
        $this->pasteFromURL($textFileURL);

       $this->assertHTMLMatch('<ol><li>First item</li><li>Second item</li><li>Third Item</li></ol><ol><li>First item</li><li>Second item</li><li>Third Item</li></ol><ol type="A"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="a"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="a"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="I"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="i"><li>First item</li><li>Second item</li><li>Third item</li></ol>');

    }//end _runTest()

}//end class

?>