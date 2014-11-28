<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_TextAlignmentUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the TextAlignment doc works correctly.
     *
     * @return void
     */
    public function testTextAlignment()
    {
        $this->useTest(1);

        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/TextAlignment.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/TextAlignment.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/TextAlignment.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/TextAlignment.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/TextAlignment.txt');
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/TextAlignment.txt');
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/TextAlignment.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/TextAlignment.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/TextAlignment.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on windows');
                }//end switch
                break;
        }//end switch

        $this->selectKeyword(1);
        $this->pasteFromURL($testFile);

        $this->assertHTMLMatch('<p>First para default.</p><p style="text-align:center;">Second para centered.</p><p style="text-align:right;">Third para right aligned.</p><p style="text-align:justify;">Fourth para justified (by love).</p><p>Fifth para changed from justified to left align.</p><h3>Table Editing With Aligned Text</h3><ul><li>One</li><li>Two</li><li>Three<ul><li>Sub One</li><li>Sub Two</li></ul></li><li>Four</li></ul><ol><li>One</li><li>Two</li><li>Three<ol type="a"><li>Sub One</li><li>Sub Two</li></ol></li><li>Four</li></ol><h3>Table Editing With Aligned Text</h3><table border="1" style="width: 100%;"><tbody><tr><td><p style="text-align:center;">Item</p></td><td><p style="text-align:center;">Price</p></td><td><p style="text-align:center;">Quantity</p></td></tr><tr><td><p>Book (hard cover)</p></td><td><p style="text-align:center;">$15.60</p></td><td><p style="text-align:center;">3</p></td></tr><tr><td><p>DVD</p></td><td><p style="text-align:center;">$8.50</p></td><td><p style="text-align:center;">1</p></td></tr></tbody></table><table border="1" style="width: 100%;"><tbody><tr><td><p style="text-align:center;"><strong>H1</strong></p></td><td><p style="text-align:center;"><strong>H2</strong></p></td><td><p style="text-align:center;"><strong>H3</strong></p></td><td><p style="text-align:center;"><strong>H4</strong></p></td><td><p style="text-align:center;"><strong>H5</strong></p></td><td><p style="text-align:center;"><strong>H6</strong></p></td><td><p style="text-align:center;"><strong>H7</strong></p></td><td><p style="text-align:center;"><strong>H8</strong></p></td><td><p style="text-align:center;"><strong>H9</strong></p></td><td><p style="text-align:center;"><strong>H10</strong></p></td></tr><tr><td><p style="text-align:center;"><strong>1a</strong></p></td><td><p style="text-align:center;">2a</p></td><td><p style="text-align:center;">3a</p></td><td><p style="text-align:center;">4a</p></td><td><p style="text-align:center;">5a</p></td><td><p style="text-align:center;">6a</p></td><td><p style="text-align:center;">7a</p></td><td><p style="text-align:center;">8a</p></td><td><p style="text-align:center;">9a</p></td><td><p style="text-align:center;">10a</p></td></tr><tr><td><p style="text-align:right;"><strong>1b</strong></p></td><td><p style="text-align:right;">2b</p></td><td><p style="text-align:right;">3b</p></td><td><p style="text-align:right;">4b</p></td><td><p style="text-align:right;">5b</p></td><td><p style="text-align:right;">6b</p></td><td><p style="text-align:right;">7b</p></td><td><p style="text-align:right;">8b</p></td><td><p style="text-align:right;">9b</p></td><td><p style="text-align:right;">10b</p></td></tr><tr><td><p><strong>1c</strong></p></td><td><p>2c</p></td><td><p>3c</p></td><td><p>4c</p></td><td><p>5c</p></td><td><p>6c</p></td><td><p>7c</p></td><td><p>8c</p></td><td><p>9c</p></td><td><p>10c</p></td></tr></tbody></table>');

    }//end testTextAlignment()

}//end class

?>