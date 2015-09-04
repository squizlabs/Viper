<?php

require_once 'AbstractCopyPasteFromWordAndGoogleDocsUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_BlockquoteUnitTest extends AbstractCopyPasteFromWordAndGoogleDocsUnitTest
{

    /**
     * Test that copying/pasting from the Blockquote doc from word correctly.
     *
     * @return void
     */
    public function testBlockquoteFromWord()
    {
        $this->copyAndPasteFromWordDoc('BlockquoteDoc.txt', '<blockquote><p>I\'ve attached the document I have started to create which will be used in the demonstration, it has a word blockquote near the begining. When pasting into the viper pasting page, looks like we have conistent markup to check agains <strong>class="MsoQuote"</strong> is in raw content for all browsers except ie8.</p></blockquote>');

    }//end testTextAlignmentFromWord()

}//end class

?>