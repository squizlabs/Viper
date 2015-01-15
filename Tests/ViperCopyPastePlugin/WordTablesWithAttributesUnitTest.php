<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_WordTablesWithAttributesUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the WordTablesWithAttributes doc works correctly.
     *
     * @return void
     */
    public function testWordTablesWithAttributes()
    {
        $this->useTest(1);

        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/WordTablesWithAttributes.txt');
                        break;
                    case 'firefoxNightly':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefoxNightly/WordTablesWithAttributes.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/WordTablesWithAttributes.txt');
                        break;
                    case 'chromeCanary':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChromeCanary/WordTablesWithAttributes.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/WordTablesWithAttributes.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/WordTablesWithAttributes.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/WordTablesWithAttributes.txt');
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/WordTablesWithAttributes.txt');
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/WordTablesWithAttributes.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/WordTablesWithAttributes.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/WordTablesWithAttributes.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on windows');
                }//end switch
                break;
        }//end switch

        $this->selectKeyword(1);
        $this->pasteFromURL($testFile);
        $this->removeTableHeaders();
        $this->assertHTMLMatch('<p>There are some similar rows that can probably be considered as groups.</p><ul><li>Dependants, History, Logs and Preview screens are effectively read-only screens and consequently, the user always has access to these screens regardless of asset status.</li><li>Permissions, Metadata Schemas, Layouts and Workflow (With the exception of approving or rejecting, as noted below) screens require admin access to make changes, so the user with write permission only, never has access.</li></ul><p>The following table indicates which screens on the admin interface a user with write permission to assets with workflow applied that is not the approval step in workflow.</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td><p>Under Construction</p></td><td><p>Pending Approval</p></td><td><p>Approved to go live</p></td><td><p>Live</p></td><td><p>Safe edit</p></td><td><p>Safe edit pending approval</p></td><td><p>Safe edit approved to go live</p></td><td><p>Archived</p></td><td><p>Up for review</p></td></tr><tr><td><p>Details</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û1</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û1</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Edit Contents</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Web Paths</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Permissions</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Workflow</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Metadata Schemas</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Metadata</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Linking</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td></tr><tr><td><p>Settings</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü2</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü2</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Lookup Settings</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Tagging</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Layouts</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Roles</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td></tr><tr><td><p>Dependants</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>History</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>Logs</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>Preview</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr></tbody></table><ol><li>Can set thumbnail but can\'t clear thumbnail.</li><li>Can set design but can\'t clear design.</li></ol><p>The following table indicates which screens on the admin interface a user with write permission to assets with workflow applied that is the approval step in workflow.</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td><p>Under Construction</p></td><td><p>Pending Approval</p></td><td><p>Approved to go live</p></td><td><p>Live</p></td><td><p>Safe edit</p></td><td><p>Safe edit pending approval</p></td><td><p>Safe edit approved to go live</p></td><td><p>Archived</p></td><td><p>Up for review</p></td></tr><tr><td><p>Details</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û1</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û1</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Edit Contents</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Web Paths</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Permissions</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Workflow</p></td><td><p>û</p></td><td><p>ü3</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü3</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Metadata Schemas</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Metadata</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Linking</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>Settings</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü2</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü2</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Lookup Settings</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Tagging</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>û</p></td><td><p>û</p></td><td><p>ü</p></td></tr><tr><td><p>Layouts</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td><td><p>û</p></td></tr><tr><td><p>Roles</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td><td><p>-</p></td></tr><tr><td><p>Dependants</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>History</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>Logs</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr><tr><td><p>Preview</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td><td><p>ü</p></td></tr></tbody></table><ol><li>Can set thumbnail but can\'t clear thumbnail.</li><li>Can set design but can\'t clear design.</li><li>Can approve or reject but cannot remove or apply schema.</li></ol><p>This table is almost identical the columns that differ are Pending approval, Live, Safe edit pending approval and Up for review. These columns now contain values more or less identical to the Under Construction and Safe edit columns.</p>');

    }//end testWordTablesWithAttributes()

}//end class

?>