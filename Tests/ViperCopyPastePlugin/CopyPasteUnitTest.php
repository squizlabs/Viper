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
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + v');
        $this->type('A');
        $this->keyDown('Key.CMD + v');
        $this->type('B');
        $this->keyDown('Key.CMD + v');
        $this->type('C');

        $this->assertHTMLMatch('<p>%1%A%1%B%1%C</p>');

    }//end testSimpleTextCopyPaste()


    /**
     * Test that copying/pasting bold text works.
     *
     * @return void
     */
    public function testBoldTextCopyPaste()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + v');
        $this->type('A');
        $this->keyDown('Key.CMD + v');
        $this->type('B');
        $this->keyDown('Key.CMD + v');
        $this->type('C');
        sleep(2);

        $this->assertHTMLMatch('<p><strong>%1%A%1%B%1%C</strong></p>');

    }//end testBoldTextCopyPaste()


   /**
     * Test that copying/pasting italic text works.
     *
     * @return void
     */
    public function testItalicTextCopyPaste()
    {
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');
        $this->keyDown('Key.CMD + c');
        $this->keyDown('Key.CMD + v');
        $this->type('A');
        $this->keyDown('Key.CMD + v');
        $this->type('B');
        $this->keyDown('Key.CMD + v');
        $this->type('C');
        sleep(2);

        $this->assertHTMLMatch('<p><em>%1%A%1%B%1%C</em></p>');

    }//end testItalicTextCopyPaste()


    /**
     * Test that you can copy and paste in a PRE tag.
     *
     * @return void
     */
    public function testCopyAndPasteInPreTag()
    {
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

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
        $this->selectKeyword('WoW', 'XuT');
        $this->keyDown('Key.CMD + v');

        sleep(5);

        $this->assertHTMLMatch('<pre>Lorum this is more content<p>%1%ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum necfelis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p> </pre>');

    }//end testCopyAndPasteInPreTag()


    /**
     * Test copy and paste for a table.
     *
     * @return void
     */
    public function testCopyAndPasteForTable()
    {
        $this->selectKeyword('WoW');
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + c');

        $this->selectKeyword('IPSUM');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        $this->execJS('rmTableHeaders(0,true)');
        $this->execJS('rmTableHeaders(1,true)');
        $this->assertHTMLMatch('<p>%1% IPSUM</p><table cellspacing="0" cellpadding="3" border="1"><caption><strong>Table 1.2:</strong>&nbsp;The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>WoW&nbsp;test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus&nbsp;<strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec&nbsp;<strong>porta</strong>&nbsp;ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table><p>&nbsp;</p><p>sit amet <strong>consectetur</strong></p><p>eooee</p><table cellspacing="0" cellpadding="3" border="1"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>WoW test</td><td>sapien vel aliquet</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>        </td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testCopyAndPasteForTable()


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
        $this->selectKeyword(1);

        $this->keyDown('Key.CMD + v');

        sleep(5);

        $this->assertHTMLMatch('<p>~ ! @ # $ % ^ &amp; * ( ) _ +</p><p>` 1 2 3 4 5 6 7 8 9 0 - =</p><p>{ } |</p><p>: &#8220;</p><p>&lt; &gt; ?</p><p>[ ]</p><p>; &#8216;</p><p>, . /</p><p>q w e r t y u i o p</p><p>Q W E R T Y U I O P</p><p>a s d f g h j k l</p><p>A S D F G H J K L</p><p>z x c v b n m</p><p>Z X C V B N M</p><p></p>');

    }//end testSpecialCharactersDocCopyPaste()


    /**
     * Test that copying/pasting from the ListsTestDoc works correctly.
     *
     * @return void
     */
    public function testListTestDocCopyPaste()
    {
        // Open Word doc, copy its contents.
        $retval = NULL;

        system('open '.escapeshellarg(dirname(__FILE__).'/ListsTestDoc.docx'), $retval);

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
        $this->selectKeyword(1);

        $this->keyDown('Key.CMD + v');

        sleep(5);

        $this->assertHTMLMatch('<p>My complex numbered lists</p><ol><li>Asdadsads<ul><li>Dsfsdfsfd</li><li>Sdfsdfsfd<ul><li>Sfd</li><li>Sfdsfd</li><li>Dsfsdf</li><li>sdfsdf</li></ul></li><li>Sdfsdfsfd</li><li>sdfsdfsfd</li></ul></li><li>Asdadsasd</li><li>Sfdsfds&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</li><li>Asdasdasd</li><li>Asdasdasd</li></ol><p>My complex bulleted lists</p><ul><li>Sadsadasda</li><li>Sdfdsf</li><li>Sdfsdfsdf<ul><li>Sdfsfdsdf</li><li>sdfsdfsdf</li><li>Sdfsdfsfd</li><li>sdfsfdsdf</li></ul></li><li>Asdasdsad</li></ul><p></p>');

    }//end testListTestDocCopyPaste()


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
        $this->selectKeyword(1);

        $this->keyDown('Key.CMD + v');

        sleep(5);

        $this->execJS('rmTableHeaders(0,true)');

        $this->assertHTMLMatch('<h1>%1% Ipsum</h1><p>%1% Ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>%1% ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>%1% ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>%1% ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2</p><p>%1% ipsum dolor sit amet, consectetur adipiscing elit.Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque.Praesent in sapien sapien. <a href="http://www.google.com.au">Suspendisse</a>vehicula tortor a purus vestibulum eget bibendum est auctor. Donec nequeturpis, dignissim et viverra nec, ultricies et libero. Suspendisse potenti.</p><p>%1% ipsum dolor sit amet,consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiatlectus pellentesque. Praesent in sapien sapien</p><h2>%1% ipsum</h2><p><img width="92" height="137" src="file://localhost/Users/dsherwood/Library/Caches/TemporaryItems/msoclip/0clip_image002.png" hspace="9" alt="Description: Macintosh HD:Applications:Microsoft Office 2011:Office:Media:Clipart: Business.localized:AA006219.png" v:shapes="Picture_x0020_3" />%1% ipsum dolor sit amet, consecteturadipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectuspellentesque. Praesent in sapien sapien.</p><ul><li>%1% ipsum dolor sit amet,     consectetur adipiscing elit.</li><li>Phasellus ornare ipsum nec felis     lacinia a feugiat lectus pellentesque. <ul><li>%1% ipsum dolor sit amet,      consectetur adipiscing elit.</li><li>%1% ipsum dolor sit amet,      consectetur adipiscing elit.<ul><li>Praesent in sapien sapien</li></ul></li><li>Praesent in sapien sapien</li></ul></li><li>Praesent in sapien sapien.</li></ul><h3>%1%ipsum</h3><p>%1%ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum necfelis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><p>%1% ipsum dolor sit amet, consecteturadipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectuspellentesque. Praesent in sapien sapien.</p><p>%1% ipsum dolor sit amet, consecteturadipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectuspellentesque. Praesent in sapien sapien.e.</p><p>Social Networking Tools%1% ipsum dolor sit amet,consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiatlectus pellentesque. Praesent in sapien sapien. Social Networking Tools%1% ipsum dolor sit amet,consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiatlectus pellentesque. Praesent in sapien sapien.</p><table border="1" cellspacing="0" cellpadding="0"><tbody><tr><td width="183" valign="top">  <p><strong>Col1 Header</strong></p>  </td><td width="183" valign="top">  <p><strong>Col2 Header</strong></p>  </td><td width="183" valign="top">  <p><strong>Col3 Header</strong></p>  </td></tr><tr><td width="183" valign="top">  <p>nec porta ante</p>  </td><td width="183" valign="top">  <p>sapien vel aliquet</p>  </td><td width="183" valign="top">  <ul><li>purus neque luctus ligula, vel molestie  arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul>      </td></tr><tr><td width="183" valign="top">  <p>nec porta ante</p>  </td><td width="366" colspan="2" valign="top">  <p>purus neque luctus <a href="http://www.google.com"><strong>ligula</strong></a>,  vel molestie arcu</p>  </td></tr><tr><td width="183" valign="top">  <p>nec <strong>porta</strong> ante</p>  </td><td width="183" valign="top">  <p>sapien vel aliquet</p>  </td><td width="183" rowspan="2" valign="top">  <p>purus neque luctus  ligula, vel molestie arcu</p>  </td></tr><tr><td width="366" colspan="2" valign="top">  <p>sapien vel aliquet</p>  </td></tr></tbody></table><p><strong>&nbsp;</strong></p><h2>%1% ipsum</h2><p>%1%ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum necfelis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol><li>%1% ipsum dolor sit amet,     consectetur adipiscing elit.</li><li>Phasellus ornare ipsum nec felis     lacinia a feugiat lectus pellentesque. <ol><li>%1% ipsum dolor sit amet,      consectetur adipiscing elit</li><li>%1% ipsum dolor sit amet,      consectetur adipiscing elit</li></ol></li><li>Praesent in sapien sapien.</li></ol><p>%1%ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum necfelis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol><li>%1% ipsum dolor sit amet,     consectetur adipiscing elit. <ul><li>Phasellus ornare ipsum nec felis      lacinia a feugiat lectus pellentesque.</li><li>Praesent in sapien sapien.</li></ul></li><li>%1% ipsum dolor sit amet,     consectetur adipiscing elit</li></ol><p></p>');

    }//end testViperTestDocCopyPaste()


}//end class

?>
