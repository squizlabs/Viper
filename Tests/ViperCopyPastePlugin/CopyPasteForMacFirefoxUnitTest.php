<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyPasteForMacFirefoxUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that copying/pasting from the SpecialCharactersDoc works correctly.
     *
     * @return void
     */
    public function testSpecialCharactersDocCopyPaste2()
    {
        $this->runTestFor('osx', 'firefox');
        $this->useTest(1);

        $this->moveToKeyword(1, 'right');
        $this->pasteFromURL($this->getTestURL('/ViperCopyPastePlugin/TextFiles/MacFirefox/SpecialCharactersDoc.txt'));

        sleep(10);

        $this->assertHTMLMatch('<p>  ~ ! @ # $ % ^ &amp; * ( ) _ +</p><p>  ` 1 2 3 4 5 6 7 8 9 0 - =</p><p>  { } |</p><p>  :</p><p>  &lt; &gt; ?</p><p>  [ ]</p><p>  ; "a" \'b\'</p><p>  , . /</p><p>  &hellip;</p><p>  q w e r t y u i o p</p><p>  Q W E R T Y U I O P</p><p>  a s d f g h j k l</p><p>  A S D F G H J K L</p><p>  z x c v b n m</p><p>  Z X C V B N M</p>');

    }//end testSpecialCharactersDocCopyPaste()

}//end class

?>
