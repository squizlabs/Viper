<?php

require_once 'AbstractViperTableEditorPluginUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyPasteTableRowUnitTest extends AbstractViperTableEditorPluginUnitTest
{

    /**
     * Test that copying/pasting a partial table row works correctly for Firefox on OSX.
     *
     * @return void
     */
    public function testCopyPastePartialRowForOSXFirefox()
    {
        $this->runTestFor('osx', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/TableRowForPartialCopyPaste.txt'));

    }//end testListsForOSXFirefox()


    /**
     * Test that copying/pasting a partial table row works correctly for Chrome on OSX.
     *
     * @return void
     */
    public function testCopyPastePartialRowForOSXChrome()
    {
        $this->runTestFor('osx', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/TableRowForPartialCopyPaste.txt'));

    }//end testListsForOSXChrome()


    /**
     * Test that copying/pasting a partial table row works correctly for Safari on OSX.
     *
     * @return void
     */
    public function testCopyPastePartialRowForOSXSafari()
    {
        $this->runTestFor('osx', 'safari');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/TableRowForPartialCopyPaste.txt'));

    }//end testListsForOSXSafari()
 

    /**
     * Test that copying/pasting a partial table row works correctly for Firefox on Windows.
     *
     * @return void
     */
    public function testCopyPastePartialRowForWindowsFirefox()
    {
        $this->runTestFor('windows', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/TableRowForPartialCopyPaste.txt'));

    }//end testListsForWindowsFirefox()
 

    /**
     * Test that copying/pasting a partial table row works correctly for Chrome on Windows.
     *
     * @return void
     */
    public function testCopyPastePartialRowForWindowsChrome()
    {
        $this->runTestFor('windows', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/TableRowForPartialCopyPaste.txt'));

    }//end testListsForWindowsChrome()

    /**
     * Test that copying/pasting a partial table row works correctly for IE8 on Windows.
     *
     * @return void
     */
    public function testCopyPastePartialRowForWindowsIE8()
    {
        $this->runTestFor('windows', 'ie8');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/TableRowForPartialCopyPaste.txt'));

    }//end testListsForWindowsIE8()


    /**
     * Test that copying/pasting a partial table row works correctly for IE9 on Windows.
     *
     * @return void
     */
    public function testCopyPastePartialRowForWindowsIE9()
    {
        $this->runTestFor('windows', 'ie9');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/TableRowForPartialCopyPaste.txt'));

    }//end testListsForWindowsIE9()


    /**
     * Test that copying/pasting a partial table row works correctly for IE10 on Windows.
     *
     * @return void
     */
    public function testCopyPastePartialRowForWindowsIE10()
    {
        $this->runTestFor('windows', 'ie10');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/TableRowForPartialCopyPaste.txt'));

    }//end testListsForWindowsIE10()

    /**
     * Test that copying/pasting a partial table row works correctly for IE11 on Windows.
     *
     * @return void
     */
    public function testCopyPastePartialRowForWindowsIE11()
    {
        $this->runTestFor('windows', 'ie11');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/TableRowForPartialCopyPaste.txt'));

    }//end testListsForWindowsIE11()


    /**
     * Run the test for the TableRowForPartialCopyPaste document.
     *
     * @param string $textFileURL The URL of the text file to use in the Unit Test.
     *
     * @return void
     */
    private function _runTest($textFileURLL)
    {
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(2);
        $this->pasteFromURL($textFileURL);

       $this->assertHTMLMatch('<table style="width: 100%;" border="1"><thead><tr><th><p>Header 1</p></th><th><p>Header 2</p></th><th><p>Header 3</p></th></tr></thead><tbody><tr><td><p>Cell 1</p></td><td><p>Cell 2</p></td><td><p>Cell 3</p></td></tr><tr><td><p>Cell 4</p></td><td><p>Cell 5</p></td><td><p>Cell 6</p></td></tr><tr><td><p>Cell 7</p></td><td><p>Cell 8</p></td><td><p>Cell 9</p></td></tr></tbody></table>');

    }//end _runTest()

}//end class

?>