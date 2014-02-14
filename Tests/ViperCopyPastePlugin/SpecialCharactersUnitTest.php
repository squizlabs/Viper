<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_SpecialCharactersUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the SpecialCharacters works correctly for Firefox on OSX.
     *
     * @return void
     */
    public function testSpecialCharactersForOSXFirefox()
    {
        $this->runTestFor('osx', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/SpecialCharacters.txt'));

    }//end testSpecialCharactersForOSXFirefox()


	/**
     * Test that copying/pasting from the SpecialCharacters works correctly for Chrome on OSX.
     *
     * @return void
     */
    public function testSpecialCharactersForOSXChrome()
    {
        $this->runTestFor('osx', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/SpecialCharacters.txt'));

    }//end testSpecialCharactersForOSXChrome()


	/**
     * Test that copying/pasting from the SpecialCharacters works correctly for Safari on OSX.
     *
     * @return void
     */
    public function testSpecialCharactersForOSXSafari()
    {
        $this->runTestFor('osx', 'safari');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/SpecialCharacters.txt'));

    }//end testSpecialCharactersForOSXSafari()
 

  	/**
     * Test that copying/pasting from the SpecialCharacters works correctly for Firefox on Windows.
     *
     * @return void
     */
    public function testSpecialCharactersForWindowsFirefox()
    {
        $this->runTestFor('windows', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/SpecialCharacters.txt'));

    }//end testSpecialCharactersForWindowsFirefox()
 

 	/**
     * Test that copying/pasting from the SpecialCharacters works correctly for Chrome on Windows.
     *
     * @return void
     */
    public function testSpecialCharactersForWindowsChrome()
    {
        $this->runTestFor('windows', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/SpecialCharacters.txt'));

    }//end testSpecialCharactersForWindowsChrome()

	/**
     * Test that copying/pasting from the SpecialCharacters works correctly for IE8 on Windows.
     *
     * @return void
     */
    public function testSpecialCharactersForWindowsIE8()
    {
        $this->runTestFor('windows', 'ie8');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/SpecialCharacters.txt'));

    }//end testSpecialCharactersForWindowsIE8()


	/**
     * Test that copying/pasting from the SpecialCharacters works correctly for IE9 on Windows.
     *
     * @return void
     */
    public function testSpecialCharactersForWindowsIE9()
    {
        $this->runTestFor('windows', 'ie9');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/SpecialCharacters.txt'));

    }//end testSpecialCharactersForWindowsIE9()


	/**
     * Test that copying/pasting from the SpecialCharacters works correctly for IE10 on Windows.
     *
     * @return void
     */
    public function testSpecialCharactersForWindowsIE10()
    {
        $this->runTestFor('windows', 'ie10');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/SpecialCharacters.txt'));

    }//end testSpecialCharactersForWindowsIE10()

	/**
     * Test that copying/pasting from the SpecialCharacters works correctly for IE11 on Windows.
     *
     * @return void
     */
    public function testSpecialCharactersForWindowsIE11()
    {
        $this->runTestFor('windows', 'ie11');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/SpecialCharacters.txt'));

    }//end testSpecialCharactersForWindowsIE11()


 	/**
     * Run the test for the SpecialCharacters document.
     *
     * @param string $textFileURL The URL of the text file to use in the Unit Test.
     *
     * @return void
     */
    private function _runTest($textFileURL)
    {
        $this->selectKeyword(1);
        $this->pasteFromURL($textFileURL);

       $this->assertHTMLMatch('<p>~ ! @ # $ % ^ &amp; * ( ) _ +</p><p>` 1 2 3 4 5 6 7 8 9 0 - =</p><p>{ } |</p><p>:</p><p>&lt; &gt; ?</p><p>[ ]</p><p>; "a" \'b\'</p><p>, . /</p><p>&hellip;</p><p>q w e r t y u i o p</p><p>Q W E R T Y U I O P</p><p>a s d f g h j k l</p><p>A S D F G H J K L</p><p>z x c v b n m</p><p>Z X C V B N M</p>');

    }//end _runTest()

}//end class

?>