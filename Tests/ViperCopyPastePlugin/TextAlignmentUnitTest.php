<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_TextAlignmentUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the TextAlignment works correctly for Firefox on OSX.
     *
     * @return void
     */
    public function testTextAlignmentForOSXFirefox()
    {
        $this->runTestFor('osx', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/TextAlignment.txt'));

    }//end testTextAlignmentForOSXFirefox()


	/**
     * Test that copying/pasting from the TextAlignment works correctly for Chrome on OSX.
     *
     * @return void
     */
    public function testTextAlignmentForOSXChrome()
    {
        $this->runTestFor('osx', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/TextAlignment.txt'));

    }//end testTextAlignmentForOSXChrome()


	/**
     * Test that copying/pasting from the TextAlignment works correctly for Safari on OSX.
     *
     * @return void
     */
    public function testTextAlignmentForOSXSafari()
    {
        $this->runTestFor('osx', 'safari');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/TextAlignment.txt'));

    }//end testTextAlignmentForOSXSafari()


  	/**
     * Test that copying/pasting from the TextAlignment works correctly for Firefox on Windows.
     *
     * @return void
     */
    public function testTextAlignmentForWindowsFirefox()
    {
        $this->runTestFor('windows', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/TextAlignment.txt'));

    }//end testTextAlignmentForWindowsFirefox()


 	/**
     * Test that copying/pasting from the TextAlignment works correctly for Chrome on Windows.
     *
     * @return void
     */
    public function testTextAlignmentForWindowsChrome()
    {
        $this->runTestFor('windows', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/TextAlignment.txt'));

    }//end testTextAlignmentForWindowsChrome()

	/**
     * Test that copying/pasting from the TextAlignment works correctly for IE8 on Windows.
     *
     * @return void
     */
    public function testTextAlignmentForWindowsIE8()
    {
        $this->runTestFor('windows', 'ie8');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/TextAlignment.txt'));

    }//end testTextAlignmentForWindowsIE8()


	/**
     * Test that copying/pasting from the TextAlignment works correctly for IE9 on Windows.
     *
     * @return void
     */
    public function testTextAlignmentForWindowsIE9()
    {
        $this->runTestFor('windows', 'ie9');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/TextAlignment.txt'));

    }//end testTextAlignmentForWindowsIE9()


	/**
     * Test that copying/pasting from the TextAlignment works correctly for IE10 on Windows.
     *
     * @return void
     */
    public function testTextAlignmentForWindowsIE10()
    {
        $this->runTestFor('windows', 'ie10');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/TextAlignment.txt'));

    }//end testTextAlignmentForWindowsIE10()

	/**
     * Test that copying/pasting from the TextAlignment works correctly for IE11 on Windows.
     *
     * @return void
     */
    public function testTextAlignmentForWindowsIE11()
    {
        $this->runTestFor('windows', 'ie11');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/TextAlignment.txt'));

    }//end testTextAlignmentForWindowsIE11()


 	/**
     * Run the test for the TextAlignment document.
     *
     * @param string $textFileURL The URL of the text file to use in the Unit Test.
     *
     * @return void
     */
    private function _runTest($textFileURL)
    {
        $this->selectKeyword(1);
        $this->pasteFromURL($textFileURL);

        $this->assertHTMLMatch('<p>First para default.</p><p>Second para centered.</p><p>Third para right aligned.</p><p>Fourth para justified (by love).</p><p>Fifth para changed from justified to left align.</p><h3>Table Editing With Aligned Text</h3><ul><li>One</li><li>Two</li><li>Three<ul><li>Sub One</li><li>Sub Two</li></ul></li><li>Four</li></ul><ol><li>One</li><li>Two</li><li>Three<ol type="a"><li>Sub One</li><li>Sub Two</li></ol></li><li>Four</li></ol><h3>Table Editing With Aligned Text</h3><table border="1" style="width: 100%;"><tbody><tr><td><p>Item</p></td><td><p>Price</p></td><td><p>Quantity</p></td></tr><tr><td><p>Book (hard cover)</p></td><td><p>$15.60</p></td><td><p>3</p></td></tr><tr><td><p>DVD</p></td><td><p>$8.50</p></td><td><p>1</p></td></tr></tbody></table><table border="1" style="width: 100%;"><tbody><tr><td><p><strong>H1</strong></p></td><td><p><strong>H2</strong></p></td><td><p><strong>H3</strong></p></td><td><p><strong>H4</strong></p></td><td><p><strong>H5</strong></p></td><td><p><strong>H6</strong></p></td><td><p><strong>H7</strong></p></td><td><p><strong>H8</strong></p></td><td><p><strong>H9</strong></p></td><td><p><strong>H10</strong></p></td></tr><tr><td><p><strong>1a</strong></p></td><td><p>2a</p></td><td><p>3a</p></td><td><p>4a</p></td><td><p>5a</p></td><td><p>6a</p></td><td><p>7a</p></td><td><p>8a</p></td><td><p>9a</p></td><td><p>10a</p></td></tr><tr><td><p><strong>1b</strong></p></td><td><p>2b</p></td><td><p>3b</p></td><td><p>4b</p></td><td><p>5b</p></td><td><p>6b</p></td><td><p>7b</p></td><td><p>8b</p></td><td><p>9b</p></td><td><p>10b</p></td></tr><tr><td><p><strong>1c</strong></p></td><td><p>2c</p></td><td><p>3c</p></td><td><p>4c</p></td><td><p>5c</p></td><td><p>6c</p></td><td><p>7c</p></td><td><p>8c</p></td><td><p>9c</p></td><td><p>10c</p></td></tr></tbody></table>');

    }//end _runTest()

}//end class

?>