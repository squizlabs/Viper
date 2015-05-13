<?php
require_once 'AbstractViperUnitTest.php';


/**
 * An abstract class that all copy and paste from Word and Google Doc unit tests should extend.
 */
abstract class AbstractCopyPasteFromWordAndGoogleDocsUnitTest extends AbstractViperUnitTest
{

    /**
     * Copies a Word document into Viper and checks the HTML code that is produced.
     *
     * @return void
    */

    protected function copyAndPasteFromWordDoc($textFileName, $expectedHtmlCode)
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/WordDocs/'.$textFileName);
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/WordDocs/'.$textFileName);
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/WordDocs/'.$textFileName);
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/WordDocs/'.$textFileName);
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/WordDocs/'.$textFileName);
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/WordDocs/'.$textFileName);
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/WordDocs/'.$textFileName);
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/WordDocs/'.$textFileName);
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/WordDocs/'.$textFileName);
                        break;
                    default:
                        throw new Exception('Browser is not supported on windows');
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

        $this->removeTableHeaders();
        $this->assertHTMLMatch($expectedHtmlCode);
        $this->assertFalse($this->_isPasteToolbarVisible());

    }//end copyAndPasteFromWordDoc


    /**
     * Copies a Google document into Viper and checks the HTML code that is produced.
     *
     * @return void
    */

    protected function copyAndPasteFromGoogleDocs($textFileName, $expectedHtmlCode)
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/GoogleDocs/'.$textFileName);
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/GoogleDocs/'.$textFileName);
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/GoogleDocs/'.$textFileName);
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/GoogleDocs/'.$textFileName);
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/GoogleDocs/'.$textFileName);
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/GoogleDocs/'.$textFileName);
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/GoogleDocs/'.$textFileName);
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/GoogleDocs/'.$textFileName);
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/GoogleDocs/'.$textFileName);
                        break;
                    default:
                        throw new Exception('Browser is not supported on windows');
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

        $this->removeTableHeaders();
        $this->assertHTMLMatch($expectedHtmlCode);
        $this->assertFalse($this->_isPasteToolbarVisible());

    }//end copyAndPasteFromGoogleDocs


    /**
     * Returns true if the right click paste toolbar is visible.
     *
     * @return boolean
     */
    private function _isPasteToolbarVisible()
    {
        $rect = $this->getBoundingRectangle('#test-ViperCopyPastePlugin-paste');
        if (empty($rect) === true) {
            return false;
        }

        return true;

    }//end _isPasteToolbarVisible()


}//end class

?>
