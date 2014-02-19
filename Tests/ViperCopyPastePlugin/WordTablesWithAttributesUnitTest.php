<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_WordTablesWithAttributesUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the WordTablesWithAttributes works correctly for Firefox on OSX.
     *
     * @return void
     */
    public function testWordTablesWithAttributesForOSXFirefox()
    {
        $this->runTestFor('osx', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/WordTablesWithAttributes.txt'));

    }//end testWordTablesWithAttributesForOSXFirefox()


	/**
     * Test that copying/pasting from the WordTablesWithAttributes works correctly for Chrome on OSX.
     *
     * @return void
     */
    public function testWordTablesWithAttributesForOSXChrome()
    {
        $this->runTestFor('osx', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/WordTablesWithAttributes.txt'));

    }//end testWordTablesWithAttributesForOSXChrome()


	/**
     * Test that copying/pasting from the WordTablesWithAttributes works correctly for Safari on OSX.
     *
     * @return void
     */
    public function testWordTablesWithAttributesForOSXSafari()
    {
        $this->runTestFor('osx', 'safari');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/WordTablesWithAttributes.txt'));

    }//end testWordTablesWithAttributesForOSXSafari()
 

  	/**
     * Test that copying/pasting from the WordTablesWithAttributes works correctly for Firefox on Windows.
     *
     * @return void
     */
    public function testWordTablesWithAttributesForWindowsFirefox()
    {
        $this->runTestFor('windows', 'firefox');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/WordTablesWithAttributes.txt'));

    }//end testWordTablesWithAttributesForWindowsFirefox()
 

 	/**
     * Test that copying/pasting from the WordTablesWithAttributes works correctly for Chrome on Windows.
     *
     * @return void
     */
    public function testWordTablesWithAttributesForWindowsChrome()
    {
        $this->runTestFor('windows', 'chrome');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/WordTablesWithAttributes.txt'));

    }//end testWordTablesWithAttributesForWindowsChrome()

	/**
     * Test that copying/pasting from the WordTablesWithAttributes works correctly for IE8 on Windows.
     *
     * @return void
     */
    public function testWordTablesWithAttributesForWindowsIE8()
    {
        $this->runTestFor('windows', 'ie8');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/WordTablesWithAttributes.txt'));

    }//end testWordTablesWithAttributesForWindowsIE8()


	/**
     * Test that copying/pasting from the WordTablesWithAttributes works correctly for IE9 on Windows.
     *
     * @return void
     */
    public function testWordTablesWithAttributesForWindowsIE9()
    {
        $this->runTestFor('windows', 'ie9');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/WordTablesWithAttributes.txt'));

    }//end testWordTablesWithAttributesForWindowsIE9()


	/**
     * Test that copying/pasting from the WordTablesWithAttributes works correctly for IE10 on Windows.
     *
     * @return void
     */
    public function testWordTablesWithAttributesForWindowsIE10()
    {
        $this->runTestFor('windows', 'ie10');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/WordTablesWithAttributes.txt'));

    }//end testWordTablesWithAttributesForWindowsIE10()

	/**
     * Test that copying/pasting from the WordTablesWithAttributes works correctly for IE11 on Windows.
     *
     * @return void
     */
    public function testWordTablesWithAttributesForWindowsIE11()
    {
        $this->runTestFor('windows', 'ie11');
        $this->_runTest($this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/WordTablesWithAttributes.txt'));

    }//end testWordTablesWithAttributesForWindowsIE11()


 	/**
     * Run the test for the WordTablesWithAttributes document.
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
        $this->assertHTMLMatch('<p>There are some similar rows that can probably be considered as groups.</p><ul><li>Dependants, History, Logs and Preview screens are effectively read-only screens and consequently, the user always has access to these screens regardless of asset status.</li><li>Permissions, Metadata Schemas, Layouts and Workflow (With the exception of approving or rejecting, as noted below) screens require admin access to make changes, so the user with write permission only, never has access.</li></ul><p>The following table indicates which screens on the admin interface a user with write permission to assets with workflow applied that is not the approval step in workflow.</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td><p>Under Construction</p></td><td><p>Pending Approval</p></td><td><p>Approved to go live</p></td><td><p>Live</p></td><td><p>Safe edit</p></td><td><p>Safe edit pending approval</p></td><td><p>Safe edit approved to go live</p></td><td><p>Archived</p></td><td><p>Up for review</p></td></tr><tr><td><p>Details</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û1</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û1</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Edit Contents</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Web Paths</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Permissions</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Workflow</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Metadata Schemas</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Metadata</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Linking</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td></tr><tr><td><p>Settings</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü2</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü2</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Lookup Settings</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Tagging</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Layouts</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Roles</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td></tr><tr><td><p>Dependants</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>History</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>Logs</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>Preview</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr></tbody></table><ol><li>Can set thumbnail but can\'t clear thumbnail.</li><li>Can set design but can\'t clear design.</li></ol><p>The following table indicates which screens on the admin interface a user with write permission to assets with workflow applied that is the approval step in workflow.</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td><p>Under Construction</p></td><td><p>Pending Approval</p></td><td><p>Approved to go live</p></td><td><p>Live</p></td><td><p>Safe edit</p></td><td><p>Safe edit pending approval</p></td><td><p>Safe edit approved to go live</p></td><td><p>Archived</p></td><td><p>Up for review</p></td></tr><tr><td><p>Details</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û1</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û1</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Edit Contents</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Web Paths</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Permissions</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Workflow</p></td><td><p>û</p></td><td><p>ü3</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü3</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Metadata Schemas</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Metadata</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Linking</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>Settings</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü2</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü2</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Lookup Settings</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Tagging</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Layouts</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Roles</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td></tr><tr><td><p>Dependants</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>History</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>Logs</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>Preview</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr></tbody></table><ol><li>Can set thumbnail but can\'t clear thumbnail.</li><li>Can set design but can\'t clear design.</li><li>Can approve or reject but cannot remove or apply schema.</li></ol><p>This table is almost identical the columns that differ are Pending approval, Live, Safe edit pending approval and Up for review. These columns now contain values more or less identical to the Under Construction and Safe edit columns.</p>');

    }//end _runTest()

}//end class

?>