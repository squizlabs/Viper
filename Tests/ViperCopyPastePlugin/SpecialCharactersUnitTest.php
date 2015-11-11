<?php

require_once 'AbstractCopyPasteFromWordAndGoogleDocsUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_SpecialCharactersUnitTest extends AbstractCopyPasteFromWordAndGoogleDocsUnitTest
{

	/**
     * Test that copying/pasting from the SpecialCharacters for word correctly with aggressive mode off.
     *
     * @return void
     */
    public function testSpecialCharactersFromWordWithAggressiveModeOff()
    {
        $this->setPluginSettings('ViperCopyPastePlugin', array('aggressiveMode' => false));

        $this->copyAndPasteFromWordDoc('SpecialCharacters.txt', '<p>~ ! @ # $ % ^ &amp; * ( ) _ +</p><p>` 1 2 3 4 5 6 7 8 9 0 - =</p><p>{ } |</p><p>:</p><p>&lt; &gt; ?</p><p>[ ]</p><p>; &ldquo;a&rdquo; &lsquo;b&rsquo;</p><p>, . /</p><p>&hellip;</p><p>q w e r t y u i o p</p><p>Q W E R T Y U I O P</p><p>a s d f g h j k l</p><p>A S D F G H J K L</p><p>z x c v b n m</p><p>Z X C V B N M</p>');

    }//end testSpecialCharactersFromWordWithAggressiveModeOff()


    /**
     * Test that copying/pasting from the SpecialCharacters for word correctly with aggressive mode on.
     *
     * @return void
     */
    public function testSpecialCharactersFromWordWithAggressiveModeOn()
    {
        $this->copyAndPasteFromWordDoc('SpecialCharacters.txt', '<p>~ ! @ # $ % ^ &amp; * ( ) _ +</p><p>` 1 2 3 4 5 6 7 8 9 0 - =</p><p>{ } |</p><p>:</p><p>&lt; &gt; ?</p><p>[ ]</p><p>; &ldquo;a&rdquo; &lsquo;b&rsquo;</p><p>, . /</p><p>&hellip;</p><p>q w e r t y u i o p</p><p>Q W E R T Y U I O P</p><p>a s d f g h j k l</p><p>A S D F G H J K L</p><p>z x c v b n m</p><p>Z X C V B N M</p>');

    }//end testSpecialCharactersFromWordWithAggressiveModeOn()


    /**
     * Test that copying/pasting from the SpecialCharacters for Google Dcos correctly with aggressive mode off.
     *
     * @return void
     */
    public function testSpecialCharactersFromGoogleDocsWithAggressiveModeOff()
    {
        $this->setPluginSettings('ViperCopyPastePlugin', array('aggressiveMode' => false));

        $this->copyAndPasteFromGoogleDocs('SpecialCharacters.txt', '<p>~!@#$%^&amp;*()_+</p><p>`1234567890-=</p><p>{}|</p><p>:</p><p>&lt;&gt;?</p><p>[]</p><p>;&rdquo;a&rdquo;&rsquo;b&rsquo;</p><p>,./</p><p>&hellip;</p><p>qwertyuiop</p><p>QWERTYUIOP</p><p>asdfghjkl</p><p>ASDFGHJKL</p><p>zxcvbnm</p><p>ZXCVBNM</p>');

    }//end testSpecialCharactersFromGoogleDocsWithAggressiveModeOff()


    /**
     * Test that copying/pasting from the SpecialCharacters for Google Dcos correctly with aggressive mode on.
     *
     * @return void
     */
    public function testSpecialCharactersFromGoogleDocsWithAggressiveModeOn()
    {
        $this->copyAndPasteFromGoogleDocs('SpecialCharacters.txt', '<p>~!@#$%^&amp;*()_+</p><p>`1234567890-=</p><p>{}|</p><p>:</p><p>&lt;&gt;?</p><p>[]</p><p>;&rdquo;a&rdquo;&rsquo;b&rsquo;</p><p>,./</p><p>&hellip;</p><p>qwertyuiop</p><p>QWERTYUIOP</p><p>asdfghjkl</p><p>ASDFGHJKL</p><p>zxcvbnm</p><p>ZXCVBNM</p>');

    }//end testSpecialCharactersFromGoogleDocsWithAggressiveModeOn()

}//end class

?>