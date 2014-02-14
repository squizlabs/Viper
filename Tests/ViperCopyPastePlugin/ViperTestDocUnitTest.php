<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_ViperTestDocUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the ViperTestDoc works correctly for Firefox on OSX.
     *
     * @return void
     */
    public function testViperTestDocForOSXFirefox()
    {
        $this->runTestFor('osx', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/ViperTestDoc.txt'));

    }//end testViperTestDocForOSXFirefox()


	/**
     * Test that copying/pasting from the ViperTestDoc works correctly for Chrome on OSX.
     *
     * @return void
     */
    public function testViperTestDocForOSXChrome()
    {
        $this->runTestFor('osx', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/ViperTestDoc.txt'));

    }//end testViperTestDocForOSXChrome()


	/**
     * Test that copying/pasting from the ViperTestDoc works correctly for Safari on OSX.
     *
     * @return void
     */
    public function testViperTestDocForOSXSafari()
    {
        $this->runTestFor('osx', 'safari');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/ViperTestDoc.txt'));

    }//end testViperTestDocForOSXSafari()
 

  	/**
     * Test that copying/pasting from the ViperTestDoc works correctly for Firefox on Windows.
     *
     * @return void
     */
    public function testViperTestDocForWindowsFirefox()
    {
        $this->runTestFor('windows', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/ViperTestDoc.txt'));

    }//end testViperTestDocForWindowsFirefox()
 

 	/**
     * Test that copying/pasting from the ViperTestDoc works correctly for Chrome on Windows.
     *
     * @return void
     */
    public function testViperTestDocForWindowsChrome()
    {
        $this->runTestFor('windows', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/ViperTestDoc.txt'));

    }//end testViperTestDocForWindowsChrome()

	/**
     * Test that copying/pasting from the ViperTestDoc works correctly for IE8 on Windows.
     *
     * @return void
     */
    public function testViperTestDocForWindowsIE8()
    {
        $this->runTestFor('windows', 'ie8');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/ViperTestDoc.txt'));

    }//end testViperTestDocForWindowsIE8()


	/**
     * Test that copying/pasting from the ViperTestDoc works correctly for IE9 on Windows.
     *
     * @return void
     */
    public function testViperTestDocForWindowsIE9()
    {
        $this->runTestFor('windows', 'ie9');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/ViperTestDoc.txt'));

    }//end testViperTestDocForWindowsIE9()


	/**
     * Test that copying/pasting from the ViperTestDoc works correctly for IE10 on Windows.
     *
     * @return void
     */
    public function testViperTestDocForWindowsIE10()
    {
        $this->runTestFor('windows', 'ie10');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/ViperTestDoc.txt'));

    }//end testViperTestDocForWindowsIE10()

	/**
     * Test that copying/pasting from the ViperTestDoc works correctly for IE11 on Windows.
     *
     * @return void
     */
    public function testViperTestDocForWindowsIE11()
    {
        $this->runTestFor('windows', 'ie11');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/ViperTestDoc.txt'));

    }//end testViperTestDocForWindowsIE11()


 	/**
     * Run the test for the ViperTestDoc document.
     *
     * @param string $textFileURL The URL of the text file to use in the Unit Test.
     *
     * @return void
     */
    private function _runTest($textFileURL)
    {
        $this->selectKeyword(1);
        $this->pasteFromURL($textFileURL);

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<h1>Lorem Ipsum</h1><p>Lorem Ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.<a href="http://www.google.com.au">Suspendisse</a> vehicula tortor a purus vestibulum eget bibendum est auctor. Donec neque turpis, dignissim et viverra nec, ultricies et libero. Suspendisse potenti.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien</p><h2>Lorem ipsum</h2><p><img alt="Description: Macintosh HD:Applications:Microsoft Office 2011:Office:Media:Clipart: Business.localized:AA006219.png" height="137" hspace="9" src="" width="92" />Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ul type="disc"><li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit.</li><li>Phasellus ornare ipsum nec felis      lacinia a feugiat lectus pellentesque.<ul type="circle"><li>Lorem ipsum dolor sit amet,       consectetur adipiscing elit.</li><li>Lorem ipsum dolor sit amet,       consectetur adipiscing elit.<ul type="square"><li>Praesent in sapien sapien</li></ul></li><li>Praesent in sapien sapien</li></ul></li><li>Praesent in sapien sapien.</li></ul><h3>Lorem ipsum</h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.e.</p><p>Social Networking ToolsLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien. Social Networking ToolsLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><table border="1" style="width: 100%;"><thead><tr><th><p><strong>Col1 Header</strong></p></th><th><p><strong>Col2 Header</strong></p></th><th><p><strong>Col3 Header</strong></p></th></tr></thead><tbody><tr><td><p>nec porta ante</p></td><td><p>sapien vel aliquet</p></td><td><ul><li>purus neque luctus ligula, vel molestie   arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><p>nec porta ante</p></td><td colspan="2"><p>purus neque luctus<a href="http://www.google.com"><strong>ligula</strong></a>,   vel molestie arcu</p></td></tr><tr><td><p>nec<strong>porta</strong> ante</p></td><td><p>sapien vel aliquet</p></td><td rowspan="2"><p>purus neque luctus   ligula, vel molestie arcu</p></td></tr><tr><td colspan="2"><p>sapien vel aliquet</p></td></tr></tbody></table><p><strong></strong></p><h2>Lorem ipsum</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol start="1" type="1"><li>Lorem ipsum dolor sit amet, consectetur      adipiscing elit.</li><li>Phasellus ornare ipsum nec felis      lacinia a feugiat lectus pellentesque.<ol start="1" type="a"><li>Lorem ipsum dolor sit amet,       consectetur adipiscing elit</li><li>Lorem ipsum dolor sit amet,       consectetur adipiscing elit</li></ol></li><li>Praesent in sapien sapien.</li></ol><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol start="1" type="1"><li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit.<ul type="circle"><li>Phasellus ornare ipsum nec felis       lacinia a feugiat lectus pellentesque.</li><li>Praesent in sapien sapien.</li></ul></li><li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit</li></ol>');

    }//end _runTest()

}//end class

?>