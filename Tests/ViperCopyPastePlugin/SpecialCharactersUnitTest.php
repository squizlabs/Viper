<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_SpecialCharactersUnitTest extends AbstractViperUnitTest
{

	/**
     * Test that copying/pasting from the SpecialCharacters for word correctly.
     *
     * @return void
     */
    public function testSpecialCharactersFromWord()
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/WordDocs/SpecialCharacters.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/WordDocs/SpecialCharacters.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/WordDocs/SpecialCharacters.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/WordDocs/SpecialCharacters.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/WordDocs/SpecialCharacters.txt');
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/WordDocs/SpecialCharacters.txt');
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/WordDocs/SpecialCharacters.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/WordDocs/SpecialCharacters.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/WordDocs/SpecialCharacters.txt');
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

       $this->assertHTMLMatch('<p>~ ! @ # $ % ^ &amp; * ( ) _ +</p><p>` 1 2 3 4 5 6 7 8 9 0 - =</p><p>{ } |</p><p>:</p><p>&lt; &gt; ?</p><p>[ ]</p><p>; &ldquo;a&rdquo; &lsquo;b&rsquo;</p><p>, . /</p><p>&hellip;</p><p>q w e r t y u i o p</p><p>Q W E R T Y U I O P</p><p>a s d f g h j k l</p><p>A S D F G H J K L</p><p>z x c v b n m</p><p>Z X C V B N M</p>');

    }//end testSpecialCharactersFromWord()


    /**
     * Test that copying/pasting from the SpecialCharacters for Google Dcos correctly.
     *
     * @return void
     */
    public function testSpecialCharactersFromGoogleDocs()
    {
        $testFile = '';

        switch ($this->sikuli->getOS()) {
            case 'osx':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/GoogleDocs/SpecialCharacters.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacGoogleChrome/GoogleDocs/SpecialCharacters.txt');
                        break;
                    case 'safari':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacSafari/GoogleDocs/SpecialCharacters.txt');
                        break;
                    default:
                        throw new Exception('Browser is not supported on osx');
                }//end switch
                break;
            case 'windows':
                switch ($this->sikuli->getBrowserid()) {
                    case 'firefox':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsFirefox/GoogleDocs/SpecialCharacters.txt');
                        break;
                    case 'chrome':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsGoogleChrome/GoogleDocs/SpecialCharacters.txt');
                        break;
                    case 'ie8':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE8/GoogleDocs/SpecialCharacters.txt');
                        break;
                    case 'ie9':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE9/GoogleDocs/SpecialCharacters.txt');
                        break;
                    case 'ie10':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE10/GoogleDocs/SpecialCharacters.txt');
                        break;
                    case 'ie11':
                        $testFile = $this->getTestURL('/ViperCopyPastePlugin/TextFiles/WindowsIE11/GoogleDocs/SpecialCharacters.txt');
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

       $this->assertHTMLMatch('<p>~!@#$%^&amp;*()_+</p><p>`1234567890-=</p><p>{}|</p><p>:</p><p>&lt;&gt;?</p><p>[]</p><p>;&rdquo;a&rdquo;&rsquo;b&rsquo;</p><p>,./</p><p>&hellip;</p><p>qwertyuiop</p><p>QWERTYUIOP</p><p>asdfghjkl</p><p>ASDFGHJKL</p><p>zxcvbnm</p><p>ZXCVBNM</p>');

    }//end testSpecialCharactersFromGoogleDocs()

}//end class

?>