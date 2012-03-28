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
            sleep(2);
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

        $this->assertHTMLMatch('<p>&nbsp;</p><h1>Lorem Ipsum</h1><p>Lorem Ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque.Praesent in sapien sapien. <a href="http://www.google.com.au">Suspendisse</a>vehicula tortor a purus vestibulum eget bibendum est auctor. Donec nequeturpis, dignissim et viverra nec, ultricies et libero. Suspendisse potenti. </p><p style="text-indent:36.0pt">Lorem ipsum dolor sit amet,consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiatlectus pellentesque. Praesent in sapien sapien</p><h2>Lorem ipsum</h2><p><img width="92" height="137" src="file://localhost/Users/dsherwood/Library/Caches/TemporaryItems/msoclip/0clip_image002.png" hspace="9" alt="Description: Macintosh HD:Applications:Microsoft Office 2011:Office:Media:Clipart: Business.localized:AA006219.png" v:shapes="Picture_x0020_3">Lorem ipsum dolor sit amet, consecteturadipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectuspellentesque. Praesent in sapien sapien.</p><ul> <li>Lorem ipsum dolor sit amet,     consectetur adipiscing elit. </li> <li>Phasellus ornare ipsum nec felis     lacinia a feugiat lectus pellentesque. <ul>  <li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit.</li>  <li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit.<ul>   <li>Praesent in sapien sapien</li>  </ul></li>    <li>Praesent in sapien sapien</li> </ul></li>  <li>Praesent in sapien sapien.</li></ul><h3>Loremipsum</h3><p>Loremipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum necfelis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><p style="text-align:center">Lorem ipsum dolor sit amet, consecteturadipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectuspellentesque. Praesent in sapien sapien.</p><p style="text-align:right">Lorem ipsum dolor sit amet, consecteturadipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectuspellentesque. Praesent in sapien sapien.e.</p><p style="text-align:justify">Social Networking ToolsLorem ipsum dolor sit amet,consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiatlectus pellentesque. Praesent in sapien sapien. Social Networking ToolsLorem ipsum dolor sit amet,consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiatlectus pellentesque. Praesent in sapien sapien.</p><table border="1" cellspacing="0" cellpadding="0" style="border-collapse:collapse;border:none"> <tbody><tr>  <td width="183" valign="top" style="width:183.0pt;border:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt">  <p style="text-align:justify"><strong>Col1 Header</strong></p>  </td>  <td width="183" valign="top" style="width:183.05pt;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt">  <p style="text-align:justify"><strong>Col2 Header</strong></p>  </td>  <td width="183" valign="top" style="width:183.05pt;border:solid windowtext 1.0pt;border-left:none;padding:0cm 5.4pt 0cm 5.4pt">  <p style="text-align:justify"><strong>Col3 Header</strong></p>  </td> </tr> <tr>  <td width="183" valign="top" style="width:183.0pt;border:solid windowtext 1.0pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt">  <p style="text-align:justify">nec porta ante</p>  </td>  <td width="183" valign="top" style="width:183.05pt;border-top:none;border-left:  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt">  <p style="text-align:justify">sapien vel aliquet</p>  </td>  <td width="183" valign="top" style="width:183.05pt;border-top:none;border-left:  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt">  <ul><li>purus neque luctus ligula, vel molestie  arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>      </td> </tr> <tr>  <td width="183" valign="top" style="width:183.0pt;border:solid windowtext 1.0pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt">  <p style="text-align:justify">nec porta ante</p>  </td>  <td width="366" colspan="2" valign="top" style="width:366.1pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt">  <p style="text-align:justify">purus neque luctus <a href="http://www.google.com"><strong>ligula</strong></a>,  vel molestie arcu</p>  </td> </tr> <tr>  <td width="183" valign="top" style="width:183.0pt;border:solid windowtext 1.0pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt">  <p style="text-align:justify">nec <strong>porta</strong> ante</p>  </td>  <td width="183" valign="top" style="width:183.05pt;border-top:none;border-left:  none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt">  <p style="text-align:justify">sapien vel aliquet</p>  </td>  <td width="183" rowspan="2" valign="top" style="width:183.05pt;border-top:none;border-left:none;border-bottom:solid windowtext 1.0pt;border-right:solid windowtext 1.0pt;padding:0cm 5.4pt 0cm 5.4pt">  <p style="text-align:justify">purus neque luctus  ligula, vel molestie arcu</p>  </td> </tr> <tr>  <td width="366" colspan="2" valign="top" style="width:366.05pt;border:solid windowtext 1.0pt;border-top:none;padding:0cm 5.4pt 0cm 5.4pt">  <p style="text-align:justify">sapien vel aliquet</p>  </td> </tr></tbody></table><p><strong>&nbsp;</strong></p><h2>Lorem ipsum</h2><p>Loremipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum necfelis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol> <li>Lorem ipsum dolor sit amet, consectetur     adipiscing elit. </li> <li>Phasellus ornare ipsum nec felis     lacinia a feugiat lectus pellentesque. <ol>  <li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit</li>  <li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit</li> </ol></li>  <li>Praesent in sapien sapien.</li></ol><p>Loremipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum necfelis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol> <li>Lorem ipsum dolor sit amet,     consectetur adipiscing elit. <ul>  <li>Phasellus ornare ipsum nec felis      lacinia a feugiat lectus pellentesque. </li>  <li>Praesent in sapien sapien.</li> </ul></li>  <li>Lorem ipsum dolor sit amet,     consectetur adipiscing elit</li></ol><p>~! @ # $ % ^ &amp; * ( ) _ + ` 1 2 3 4 5 6 7 8 9 0 - = { } | : � &lt; &gt; ? [ ]\\ ; � , . / q w e r t y u I o p Q W E R T Y U I O P a s d f g h j k l A S D F GH J K L z x c v b n m Z X C V B N M</p><p>&nbsp;</p>');

    }//end testViperTestDocCopyPaste()


}//end class

?>
