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
     * Test that copying/pasting bold text works.
     *
     * @return void
     */
    public function testBoldTextCopyPaste()
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
        sleep(2);

        $this->assertHTMLMatch('<p><strong>LoremALoremBLoremC</strong></p>');

    }//end testBoldTextCopyPaste()


   /**
     * Test that copying/pasting italic text works.
     *
     * @return void
     */
    public function testItalicTextCopyPaste()
    {
        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + v');
        $this->type('A');
        $this->keyDown('Key.CMD + v');
        $this->type('B');
        $this->keyDown('Key.CMD + v');
        $this->type('C');
        sleep(2);

        $this->assertHTMLMatch('<p><em>LoremALoremBLoremC</em></p>');

    }//end testItalicTextCopyPaste()


    /**
     * Test that you can copy and paste in a PRE tag.
     *
     * @return void
     */
    public function testCopyAndPasteInPreTag()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->clickInlineToolbarButton(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_toggle_formats_highlighted.png');
        $this->clickInlineToolbarButton(dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/toolbarIcon_pre.png');

        $this->type('Lorum this is more content');
        $this->keyDown('Key.ENTER');
        $this->type('WoW to test XuT');

        $this->assertHTMLMatch('<pre>Lorum this is more contentWoW to test XuT</pre>');

        // Open Word doc, copy its contents.
        $retval = NULL;

        system('open '.escapeshellarg(dirname(__FILE__).'/CopyPasteDoc.docx'), $retval);

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
        sleep(1);
        $this->keyDown('Key.CMD + c');
        sleep(1);
        $this->keyDown('Key.CMD + w');
        $this->keyDown('Key.CMD + q');
        sleep(5);

        $this->switchApp($this->getBrowserName());
        $this->selectText('WoW', 'XuT');
        $this->keyDown('Key.CMD + v');

        sleep(5);

        $this->assertHTMLMatch('<pre>Lorum this is more content<p>Loremipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum necfelis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p> </pre>');

    }//end testCopyAndPasteInPreTag()


    /**
     * Test that copying/pasting from the SpecialCharactersDoc works correctly.
     *
     * @return void
     */
    public function testSpecialCharactersDocCopyPaste()
    {
        // Open Word doc, copy its contents.
        $retval = NULL;

        system('open '.escapeshellarg(dirname(__FILE__).'/SpecialCharactersDoc.docx'), $retval);

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
        sleep(1);
        $this->keyDown('Key.CMD + c');
        sleep(1);
        $this->keyDown('Key.CMD + w');
        $this->keyDown('Key.CMD + q');
        sleep(5);

        $this->switchApp($this->getBrowserName());
        $this->selectText('Lorem');

        $this->keyDown('Key.CMD + v');

        sleep(5);

        $this->assertHTMLMatch('<p>~ ! @ # $ % ^ &amp; * ( ) _ + ` 1 2 3 4 5 6 7 8 9 0 - = { } | : &#8221; &lt; &gt; ? [ ] \ ; &#8217; , . / q w e r t y u I o p Q W E R T Y U I O P a s d f g h j k l A S D F G H J K L z x c v b n m Z X C V B N M</p><p>&nbsp;</p>');

    }//end testSpecialCharactersDocCopyPaste()


    /**
     * Test that copying/pasting from the ViperTestDoc works correctly.
     *
     * @return void
     */
    public function testViperTestDocCopyPaste()
    {
        // Open Word doc, copy its contents.
        $retval = NULL;

        system('open '.escapeshellarg(dirname(__FILE__).'/ViperTestDoc.docx'), $retval);

        if ($retval === 1) {
            $this->markTestSkipped('MS Word is not available');
            return;
        } else {
            sleep(5);
        }

        // Switch to MS Word.
        $this->switchApp('Microsoft Word');

        // Copy text.
        $this->keyDown('Key.CMD + a');
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + w');
        $this->keyDown('Key.CMD + q');
        sleep(5);

        $this->switchApp($this->getBrowserName());
        $this->selectText('Lorem');

        $this->keyDown('Key.CMD + v');

        sleep(5);
        
        $this->execJS('rmTableHeaders(0,true)');

        $this->assertHTMLMatch('<h1>Lorem Ipsum</h1><p>Lorem Ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque.Praesent in sapien sapien. <a href="http://www.google.com.au">Suspendisse</a>vehicula tortor a purus vestibulum eget bibendum est auctor. Donec nequeturpis, dignissim et viverra nec, ultricies et libero. Suspendisse potenti.</p><p>Lorem ipsum dolor sit amet,consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiatlectus pellentesque. Praesent in sapien sapien</p><h2>Lorem ipsum</h2><p><img width="92" height="137" src="file://localhost/Users/dsherwood/Library/Caches/TemporaryItems/msoclip/0clip_image002.png" hspace="9" alt="Description: Macintosh HD:Applications:Microsoft Office 2011:Office:Media:Clipart: Business.localized:AA006219.png" v:shapes="Picture_x0020_3" />Lorem ipsum dolor sit amet, consecteturadipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectuspellentesque. Praesent in sapien sapien.</p><ul><li>Lorem ipsum dolor sit amet,     consectetur adipiscing elit.</li><li>Phasellus ornare ipsum nec felis     lacinia a feugiat lectus pellentesque. <ul><li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit.</li><li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit.<ul><li>Praesent in sapien sapien</li></ul></li><li>Praesent in sapien sapien</li></ul></li><li>Praesent in sapien sapien.</li></ul><h3>Loremipsum</h3><p>Loremipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum necfelis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><p>Lorem ipsum dolor sit amet, consecteturadipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectuspellentesque. Praesent in sapien sapien.</p><p>Lorem ipsum dolor sit amet, consecteturadipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectuspellentesque. Praesent in sapien sapien.e.</p><p>Social Networking ToolsLorem ipsum dolor sit amet,consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiatlectus pellentesque. Praesent in sapien sapien. Social Networking ToolsLorem ipsum dolor sit amet,consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiatlectus pellentesque. Praesent in sapien sapien.</p><table border="1" cellspacing="0" cellpadding="0"><tbody><tr><td width="183" valign="top">  <p><strong>Col1 Header</strong></p>  </td><td width="183" valign="top">  <p><strong>Col2 Header</strong></p>  </td><td width="183" valign="top">  <p><strong>Col3 Header</strong></p>  </td></tr><tr><td width="183" valign="top">  <p>nec porta ante</p>  </td><td width="183" valign="top">  <p>sapien vel aliquet</p>  </td><td width="183" valign="top">  <ul><li>purus neque luctus ligula, vel molestie  arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>      </td></tr><tr><td width="183" valign="top">  <p>nec porta ante</p>  </td><td width="366" colspan="2" valign="top">  <p>purus neque luctus <a href="http://www.google.com"><strong>ligula</strong></a>,  vel molestie arcu</p>  </td></tr><tr><td width="183" valign="top">  <p>nec <strong>porta</strong> ante</p>  </td><td width="183" valign="top">  <p>sapien vel aliquet</p>  </td><td width="183" rowspan="2" valign="top">  <p>purus neque luctus  ligula, vel molestie arcu</p>  </td></tr><tr><td width="366" colspan="2" valign="top">  <p>sapien vel aliquet</p>  </td></tr></tbody></table><p><strong>&nbsp;</strong></p><h2>Lorem ipsum</h2><p>Loremipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum necfelis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol><li>Lorem ipsum dolor sit amet,     consectetur adipiscing elit.</li><li>Phasellus ornare ipsum nec felis     lacinia a feugiat lectus pellentesque. <ol><li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit</li><li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit</li></ol></li><li>Praesent in sapien sapien.</li></ol><p>Loremipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum necfelis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol><li>Lorem ipsum dolor sit amet,     consectetur adipiscing elit. <ul><li>Phasellus ornare ipsum nec felis      lacinia a feugiat lectus pellentesque.</li><li>Praesent in sapien sapien.</li></ul></li><li>Lorem ipsum dolor sit amet,     consectetur adipiscing elit</li></ol><p></p>');

    }//end testViperTestDocCopyPaste()


}//end class

?>
