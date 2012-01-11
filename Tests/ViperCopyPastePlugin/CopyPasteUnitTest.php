<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyPasteUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that copying/pasting a simple text works.
     *
     * @return void
     */
    public function testSimpleTextCopyPaste()
    {
        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + v');
        $this->type('A');
        $this->keyDown('Key.CMD + v');
        $this->type('B');
        $this->keyDown('Key.CMD + v');
        $this->type('C');

        $this->assertHTMLMatch('<p>LoremALoremBLoremC</p>');

    }//end testSimpleTextCopyPaste()


    /**
     * Test that copying/pasting a styled text works.
     *
     * @return void
     */
    public function testStyledTextCopyPaste()
    {
        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + v');
        $this->type('A');
        $this->keyDown('Key.CMD + v');
        $this->type('B');
        $this->keyDown('Key.CMD + v');
        $this->type('C');

        $this->assertHTMLMatch('<p><strong>LoremA<strong>LoremB<strong>LoremC</strong></strong></strong></p>');

    }//end testStyledTextCopyPaste()


    /**
     * Test that copying/pasting from a Word document works.
     *
     * @return void
     */
    public function testMSWordSimpleCopyPaste()
    {
        // Open Word doc, copy its contents.
        $retval = NULL;
      
        system('open '.escapeshellarg(dirname(__FILE__).'/test1.docx'), $retval);

        if ($retval === 1) {
            $this->markTestSkipped('MS Word is not available');
            return;
        } else {
            sleep(2);
        }

        // Switch to MS Word.
        $this->switchApp('Microsoft Word');

        // Copy text.
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + w');
        $this->keyDown('Key.CMD + q');

        $this->switchApp($this->getBrowserName());
        $this->selectText('Lorem');

        $this->keyDown('Key.CMD + v');

        sleep(5);
        
        $this->assertHTMLMatch('<p>&nbsp;</p><p>Test\u2026 <strong><em>bold and italic</em> just bold.</strong></p>\n<p>New paragraph\u2026</p><p>&nbsp;</p>');

    }//end testMSWordSimpleCopyPaste()


}//end class

?>
