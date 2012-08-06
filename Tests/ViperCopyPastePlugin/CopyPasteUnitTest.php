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
        $this->click($this->findKeyword(1));

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
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.CMD + v');

        sleep(5);

        $this->assertHTMLMatch('<pre>Lorum this is more content <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p></pre>');

    }//end testCopyAndPasteInPreTag()


    /**
     * Test copy and paste for a table.
     *
     * @return void
     */
    public function testCopyAndPasteForAParagraph()
    {
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + c');

        $this->click($this->findKeyword(1));
        $this->selectKeyword(2);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>%1% sit amet ipsum</p><p>%2%</p><p>%1% sit amet ipsum</p>');

    }//end testCopyAndPasteForAParagraph()


    /**
     * Test copy and paste for a table.
     *
     * @return void
     */
    public function testCopyAndPasteForTable()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + c');

        $this->selectKeyword(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        $this->removeTableHeaders(0);
        $this->removeTableHeaders(1);
        $this->assertHTMLMatch('<p>Lorem XAX</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table><p></p><p>sit amet <strong>consectetur</strong></p><p>eooee</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

        // Check that the cursor is under the new table
        $this->type('type some more content');
        $this->removeTableHeaders(0);
        $this->removeTableHeaders(1);
        $this->assertHTMLMatch('<p>Lorem XAX</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table><p>type some more content</p><p>sit amet <strong>consectetur</strong></p><p>eooee</p><table border="1" cellpadding="3" cellspacing="0"><caption><strong>Table 1.2:</strong> The table caption text</caption><thead><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr></thead><tfoot><tr><td colspan="3">This is the table footer</td></tr></tfoot><tbody><tr><td>XBX test</td><td>sapien vel aliquet</td><td><ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td>nec porta ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr><tr><td>nec <strong>porta</strong> ante</td><td>sapien vel aliquet</td><td rowspan="2">purus neque luctus ligula, vel molestie arcu</td></tr><tr><td colspan="2">sapien vel aliquet</td></tr></tbody></table>');

    }//end testCopyAndPasteForTable()


    /**
     * Test that copying/pasting from the HtmlTablesInPage works correctly.
     *
     * @return void
     */
    public function testHtmlTablesInPageCopyPaste()
    {
        // Open Word doc, copy its contents.
        $retval = NULL;

        system('open '.escapeshellarg(dirname(__FILE__).'/HtmlTablesInPage.html'), $retval);

        if ($retval === 1) {
            $this->markTestSkipped('Firefox is not available');
            return;
        } else {
            sleep(2);
        }

        // Switch to Firefox.
        $this->switchApp('Firefox');

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

        $this->removeTableHeaders(1);
        $this->removeTableHeaders(2);
        $this->removeTableHeaders(3);
        $this->removeTableHeaders(4);
        $this->removeTableHeaders(5);

        $this->assertHTMLMatch('<h1>Viper Table Plugin Examples</h1><p>Insert &gt; None &gt; Manual insertion of non breaking space in each empty cell</p><table border="1" style="width: 100%;"><tbody><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; Headers Left</p><table border="1" style="width: 100%;"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; Headers Top</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; Headers Both</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><th></th><td></td><td></td><td></td></tr><tr><th></th><td></td><td></td><td></td></tr></tbody></table><p>Insert &gt; None &gt; Custom Headers &gt; Top left and bottom right cells.</p><table border="1" style="width: 100%;"><tbody><tr><th></th><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><td></td></tr><tr><td></td><td></td><td></td><th></th></tr></tbody></table><p>Insert &gt; Headers Top &gt; Custom Heads &gt; Middle columns.</p><table border="1" style="width: 100%;"><tbody><tr><th></th><th></th><th></th><th></th></tr><tr><td></td><th></th><th></th><td></td></tr><tr><td></td><th></th><th></th><td></td></tr></tbody></table><p>Blah.</p>');

    }//end testSpecialCharactersDocCopyPaste()


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

        $this->assertHTMLMatch('<p>~ ! @ # $ % ^ &amp; * ( ) _ +</p><p>` 1 2 3 4 5 6 7 8 9 0 - =</p><p>{ } |</p><p>:</p><p>&lt; &gt; ?</p><p>[ ]</p><p>; "a" \'b\'</p><p>, . /</p><p>...</p><p>q w e r t y u i o p</p><p>Q W E R T Y U I O P</p><p>a s d f g h j k l</p><p>A S D F G H J K L</p><p>z x c v b n m</p><p>Z X C V B N M</p>');

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

        $this->assertHTMLMatch('<p>My complex numbered lists</p><ol><li>Asdadsads<ul><li>Dsfsdfsfd</li><li>Sdfsdfsfd<ul><li>Sfd</li><li>Sfdsfd</li><li>Dsfsdf</li><li>sdfsdf</li></ul></li><li>Sdfsdfsfd</li><li>sdfsdfsfd</li></ul></li><li>Asdadsasd</li><li>Sfdsfds</li><li>Asdasdasd</li><li>Asdasdasd</li></ol><p>My complex bulleted lists</p><ul><li>Sadsadasda<ul><li>Sdfdsf</li><li>Sdfsdfsdf<ul><li>Sdfsfdsdf</li><li>sdfsdfsdf</li></ul></li><li>Sdfsdfsfd</li><li>sdfsfdsdf</li></ul></li><li>Asdasdsad</li></ul>');


    }//end testListTestDocCopyPaste()


    /**
     * Test that copying/pasting from the ComplexListDoc works correctly.
     *
     * @return void
     */
    public function testComplexListDocCopyPaste()
    {
        // Open Word doc, copy its contents.
        $retval = NULL;

        system('open '.escapeshellarg(dirname(__FILE__).'/ComplexListDoc.docx'), $retval);

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

        $this->assertHTMLMatch('<h1>My Complex Lists Dude!</h1><p>Here is a numbered list&hellip;</p><ol><li>One baby<ol><li>Sub baby<ol><li>Sub sub baby!</li><li>Sdfdsfsdf</li><li>sdfsdfsdf</li></ol></li></ol></li><li>Two baby<ol><li>Sdfsfdds</li><li>Sdfsfdsfd</li><li>sfdsdfsdf</li></ol></li><li>Three baby</li><li>Four</li></ol><p>Here is mu bulleted list&hellip;</p><ul><li>One bullet<ul><li>Dsfsdfsdf<ul><li>Sdfsfdsdf</li><li>sdfsdf</li></ul></li></ul></li><li>Two bullet<ul><li>Dsfsfd</li><li>sdfsdfsf</li></ul></li><li>Three bullet</li><li>Four<ul><li>sdfsdfsfd</li></ul></li></ul><p>Woot to lists!</p>');


    }//end testListTestDocCopyPaste()


    /**
     * Test that copying/pasting from the WordTableExamples doc works correctly.
     *
     * @return void
     */
    public function testWordTableExamplesDocCopyPaste()
    {
        // Open Word doc, copy its contents.
        $retval = NULL;

        system('open '.escapeshellarg(dirname(__FILE__).'/WordTableExamples.docx'), $retval);

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

        $this->removeTableHeaders(1);
        $this->removeTableHeaders(8);
        $this->removeTableHeaders(9);
        $this->removeTableHeaders(10);

        $this->assertHTMLMatch('<h1>Built in Word 2010 Table Templates Test</h1><p>These are from Insert &gt; Table &gt; Quick Tables &gt; &hellip;</p><h2>Calendar 1 (No Header Row Set)</h2><table border="1" style="width: 100%;"><tbody><tr><td colspan="7"><p><strong>December</strong></p></td></tr><tr><td><p>M</p></td><td><p>T</p></td><td><p>W</p></td><td><p>T</p></td><td><p>F</p></td><td><p>S</p></td><td><p>S</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td><p>1</p></td></tr><tr><td><p>2</p></td><td><p>3</p></td><td><p>4</p></td><td><p>5</p></td><td><p>6</p></td><td><p>7</p></td><td><p>8</p></td></tr><tr><td><p>9</p></td><td><p>10</p></td><td><p>11</p></td><td><p>12</p></td><td><p>13</p></td><td><p>14</p></td><td><p>15</p></td></tr><tr><td><p>16</p></td><td><p>17</p></td><td><p>18</p></td><td><p>19</p></td><td><p>20</p></td><td><p>21</p></td><td><p>22</p></td></tr><tr><td><p>23</p></td><td><p>24</p></td><td><p>25</p></td><td><p>26</p></td><td><p>27</p></td><td><p>28</p></td><td><p>29</p></td></tr><tr><td><p>30</p></td><td><p>31</p></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><p><strong></strong></p><h2>Calendar 2 (Top Two Rows Set as Headers)</h2><table border="1" style="width: 100%;"><thead><tr><th colspan="7"><p>May</p></th></tr><tr><th><p>M</p></th><th><p>T</p></th><th><p>W</p></th><th><p>T</p></th><th><p>F</p></th><th><p>S</p></th><th><p>S</p></th></tr></thead><tbody><tr><td></td><td><p>1</p></td><td><p>2</p></td><td><p>3</p></td><td><p>4</p></td><td><p>5</p></td><td><p>6</p></td></tr><tr><td><p>7</p></td><td><p>8</p></td><td><p>9</p></td><td><p>10</p></td><td><p>11</p></td><td><p>12</p></td><td><p>13</p></td></tr><tr><td><p>14</p></td><td><p>15</p></td><td><p>16</p></td><td><p>17</p></td><td><p>18</p></td><td><p>19</p></td><td><p>20</p></td></tr><tr><td><p>21</p></td><td><p>22</p></td><td><p>23</p></td><td><p>24</p></td><td><p>25</p></td><td><p>26</p></td><td><p>27</p></td></tr><tr><td><p>28</p></td><td><p>29</p></td><td><p>30</p></td><td><p>31</p></td><td></td><td></td><td></td></tr></tbody></table><p><strong></strong></p><h2>Calendar 3 (No Header Rows Set)</h2><table border="1" style="width: 100%;"><tbody><tr><td colspan="13"><p>December</p></td><td></td></tr><tr><td><p>Sun</p></td><td></td><td><p>Mon</p></td><td></td><td><p>Tue</p></td><td></td><td><p>Wed</p></td><td></td><td><p>Thu</p></td><td></td><td><p>Fri</p></td><td></td><td colspan="2"><p>Sat</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"><p>1</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"></td></tr><tr><td><p>2</p></td><td></td><td><p>3</p></td><td></td><td><p>4</p></td><td></td><td><p>5</p></td><td></td><td><p>6</p></td><td></td><td><p>7</p></td><td></td><td colspan="2"><p>8</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"></td></tr><tr><td><p>9</p></td><td></td><td><p>10</p></td><td></td><td><p>11</p></td><td></td><td><p>12</p></td><td></td><td><p>13</p></td><td></td><td><p>14</p></td><td></td><td colspan="2"><p>15</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"></td></tr><tr><td><p>16</p></td><td></td><td><p>17</p></td><td></td><td><p>18</p></td><td></td><td><p>19</p></td><td></td><td><p>20</p></td><td></td><td><p>21</p></td><td></td><td colspan="2"><p>22</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"></td></tr><tr><td><p>23</p></td><td></td><td><p>24</p></td><td></td><td><p>25</p></td><td></td><td><p>26</p></td><td></td><td><p>27</p></td><td></td><td><p>28</p></td><td></td><td colspan="2"><p>29</p></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"></td></tr><tr><td><p>30</p></td><td></td><td><p>31</p></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td colspan="2"></td></tr><tr><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td></tr></tbody></table><br /><p><strong></strong></p><h2>Calendar 4 (No Header Rows Set)</h2><table border="1" style="width: 100%;"><tbody><tr><td><p><strong></strong></p></td><td><p><strong></strong></p></td><td><p><strong></strong></p></td></tr><tr><td rowspan="32"><p><strong>May </strong></p></td><td><p><strong>Tuesday</strong></p></td><td><p><strong>Wednesday</strong></p></td></tr><tr><td><p><strong>1</strong></p></td><td><p><strong>16</strong></p></td></tr><tr><td><p><strong>Wednesday</strong></p></td><td><p><strong>Thursday</strong></p></td></tr><tr><td><p><strong>2</strong></p></td><td><p><strong>17</strong></p></td></tr><tr><td><p><strong>Thursday</strong></p></td><td><p><strong>Friday</strong></p></td></tr><tr><td><p><strong>3</strong></p></td><td><p><strong>18</strong></p></td></tr><tr><td><p><strong>Friday</strong></p></td><td><p><strong>Saturday</strong></p></td></tr><tr><td><p><strong>4</strong></p></td><td><p><strong>19</strong></p></td></tr><tr><td><p><strong>Saturday</strong></p></td><td><p><strong>Sunday</strong></p></td></tr><tr><td><p><strong>5</strong></p></td><td><p><strong>20</strong></p></td></tr><tr><td><p><strong>Sunday</strong></p></td><td><p><strong>Monday</strong></p></td></tr><tr><td><p><strong>6</strong></p></td><td><p><strong>21</strong></p></td></tr><tr><td><p><strong>Monday</strong></p></td><td><p><strong>Tuesday</strong></p></td></tr><tr><td><p><strong>7</strong></p></td><td><p><strong>22</strong></p></td></tr><tr><td><p><strong>Tuesday</strong></p></td><td><p><strong>Wednesday</strong></p></td></tr><tr><td><p><strong>8</strong></p></td><td><p><strong>23</strong></p></td></tr><tr><td><p><strong>Wednesday</strong></p></td><td><p><strong>Thursday</strong></p></td></tr><tr><td><p><strong>9</strong></p></td><td><p><strong>24</strong></p></td></tr><tr><td><p><strong>Thursday</strong></p></td><td><p><strong>Friday</strong></p></td></tr><tr><td><p><strong>10</strong></p></td><td><p><strong>25</strong></p></td></tr><tr><td><p><strong>Friday</strong></p></td><td><p><strong>Saturday</strong></p></td></tr><tr><td><p><strong>11</strong></p></td><td><p><strong>26</strong></p></td></tr><tr><td><p><strong>Saturday</strong></p></td><td><p><strong>Sunday</strong></p></td></tr><tr><td><p><strong>12</strong></p></td><td><p><strong>27</strong></p></td></tr><tr><td><p><strong>Sunday</strong></p></td><td><p><strong>Monday</strong></p></td></tr><tr><td><p><strong>13</strong></p></td><td><p><strong>28</strong></p></td></tr><tr><td><p><strong>Monday</strong></p></td><td><p><strong>Tuesday</strong></p></td></tr><tr><td><p><strong>14</strong></p></td><td><p><strong>29</strong></p></td></tr><tr><td><p><strong>Tuesday</strong></p></td><td><p><strong>Wednesday</strong></p></td></tr><tr><td><p><strong>15</strong></p></td><td><p><strong>30</strong></p></td></tr><tr><td><p><strong></strong></p></td><td><p><strong>Thursday</strong></p></td></tr><tr><td><p><strong></strong></p></td><td><p><strong>31</strong></p></td></tr></tbody></table><br /><p><strong></strong></p><h2>Matrix (No Header Rows Set)</h2><table border="1" style="width: 100%;"><tbody><tr><td><p>City or Town</p></td><td><p>Point A</p></td><td><p>Point B</p></td><td><p>Point C</p></td><td><p>Point D</p></td><td><p>Point E</p></td></tr><tr><td><p>Point A</p></td><td></td><td></td><td></td><td></td><td></td></tr><tr><td><p>Point B</p></td><td><p>87</p></td><td></td><td></td><td></td><td></td></tr><tr><td><p>Point C</p></td><td><p>64</p></td><td><p>56</p></td><td></td><td></td><td></td></tr><tr><td><p>Point D</p></td><td><p>37</p></td><td><p>32</p></td><td><p>91</p></td><td></td><td></td></tr><tr><td><p>Point E</p></td><td><p>93</p></td><td><p>35</p></td><td><p>54</p></td><td><p>43</p></td><td></td></tr></tbody></table><h2>Tabular List (No Header Rows Set)</h2><table border="1" style="width: 100%;"><tbody><tr><td><p><strong>ITEM</strong></p></td><td><p><strong>NEEDED</strong></p></td></tr><tr><td><p>Books</p></td><td><p>1</p></td></tr><tr><td><p>Magazines</p></td><td><p>3</p></td></tr><tr><td><p>Notebooks</p></td><td><p>1</p></td></tr><tr><td><p>Paper pads</p></td><td><p>1</p></td></tr><tr><td><p>Pens</p></td><td><p>3</p></td></tr><tr><td><p>Pencils</p></td><td><p>2</p></td></tr><tr><td><p>Highlighter</p></td><td><p>2 colors</p></td></tr><tr><td><p>Scissors</p></td><td><p>1 pair</p></td></tr></tbody></table><p><strong></strong></p><h2>With Subheads 1 (No Header Rows Set)</h2><p>Enrollment in local colleges, 2005</p><table border="1" style="width: 100%;"><tbody><tr><td><p><strong>College</strong></p></td><td><p><strong>New   students</strong></p></td><td><p><strong>Graduating   students</strong></p></td><td><p><strong>Change</strong></p></td></tr><tr><td></td><td><p>Undergraduate</p></td><td></td><td></td></tr><tr><td><p>Cedar University</p></td><td><p>110</p></td><td><p>103</p></td><td><p>+7</p></td></tr><tr><td><p>Elm College</p></td><td><p>223</p></td><td><p>214</p></td><td><p>+9</p></td></tr><tr><td><p>Maple Academy</p></td><td><p>197</p></td><td><p>120</p></td><td><p>+77</p></td></tr><tr><td><p>Pine College</p></td><td><p>134</p></td><td><p>121</p></td><td><p>+13</p></td></tr><tr><td><p>Oak Institute</p></td><td><p>202</p></td><td><p>210</p></td><td><p>-8</p></td></tr><tr><td></td><td><p>Graduate</p></td><td></td><td></td></tr><tr><td><p>Cedar University</p></td><td><p>24</p></td><td><p>20</p></td><td><p>+4</p></td></tr><tr><td><p>Elm College</p></td><td><p>43</p></td><td><p>53</p></td><td><p>-10</p></td></tr><tr><td><p>Maple Academy</p></td><td><p>3</p></td><td><p>11</p></td><td><p>-8</p></td></tr><tr><td><p>Pine College</p></td><td><p>9</p></td><td><p>4</p></td><td><p>+5</p></td></tr><tr><td><p>Oak Institute</p></td><td><p>53</p></td><td><p>52</p></td><td><p>+1</p></td></tr><tr><td><p><strong>Total</strong></p></td><td><p><strong>998</strong></p></td><td><p><strong>908</strong></p></td><td><p><strong>90</strong></p></td></tr></tbody></table><p>Source: Fictitious data, for illustration purposes only</p><p><strong></strong></p><h2>With Subheads 2 (No Header Rows Set)</h2><p>Enrollment in local colleges, 2005</p><table border="1" style="width: 100%;"><tbody><tr><td><p><strong>College</strong></p></td><td><p><strong>New students</strong></p></td><td><p><strong>Graduating students</strong></p></td><td><p><strong>Change</strong></p></td></tr><tr><td></td><td><p>Undergraduate</p></td><td></td><td></td></tr><tr><td><p>Cedar   University</p></td><td><p>110</p></td><td><p>103</p></td><td><p>+7</p></td></tr><tr><td><p>Elm College</p></td><td><p>223</p></td><td><p>214</p></td><td><p>+9</p></td></tr><tr><td><p>Maple Academy</p></td><td><p>197</p></td><td><p>120</p></td><td><p>+77</p></td></tr><tr><td><p>Pine College</p></td><td><p>134</p></td><td><p>121</p></td><td><p>+13</p></td></tr><tr><td><p>Oak Institute</p></td><td><p>202</p></td><td><p>210</p></td><td><p>-8</p></td></tr><tr><td></td><td><p>Graduate</p></td><td></td><td></td></tr><tr><td><p>Cedar   University</p></td><td><p>24</p></td><td><p>20</p></td><td><p>+4</p></td></tr><tr><td><p>Elm College</p></td><td><p>43</p></td><td><p>53</p></td><td><p>-10</p></td></tr><tr><td><p>Maple Academy</p></td><td><p>3</p></td><td><p>11</p></td><td><p>-8</p></td></tr><tr><td><p>Pine College</p></td><td><p>9</p></td><td><p>4</p></td><td><p>+5</p></td></tr><tr><td><p>Oak Institute</p></td><td><p>53</p></td><td><p>52</p></td><td><p>+1</p></td></tr><tr><td><p>Total</p></td><td><p>998</p></td><td><p>908</p></td><td><p>90</p></td></tr></tbody></table><p>Source: Fictitious data, for illustration purposes only</p><h2>Custom Table 1 (Row One as Header Row)</h2><table border="1" style="width: 100%;"><thead><tr><th><p>Heading One</p></th><th><p>Heading Two</p></th><th><p>Heading Three</p></th><th><p>Heading Four</p></th><th><p>Heading Five</p></th></tr></thead><tbody><tr><td><p>Col One, Row Two</p></td><td><p>Col Two, Row Two</p></td><td><p>Col Three, Row Two</p></td><td><p>Col Four, Row Two</p></td><td><p>Col Five, Row Two</p></td></tr><tr><td><p>Col One, Row Three</p></td><td><p>Col Two, Row Three</p></td><td><p>Col Three, Row Three</p></td><td><p>Col Four, Row Three</p></td><td><p>Col Five, Row Three</p></td></tr></tbody></table><h2>Custom Table 2 (Multiple Row Headers)</h2><p>Test special characters and symbols from Word &gt; Insert &gt; Symbols &gt; Special Characters.</p><table border="1" style="width: 100%;"><thead><tr><th colspan="4"><p>Special Characters (Including Smart Quotes)</p></th></tr><tr><th><p>Name</p></th><th><p>Character</p></th><th><p>Name</p></th><th><p>Character</p></th></tr></thead><tbody><tr><td><p>Em dash</p></td><td></td><td><p>En dash</p></td><td></td></tr><tr><td><p>Non breaking hyphen</p></td><td></td><td><p>Optional hyphen</p></td><td></td></tr><tr><td><p>Em space</p></td><td></td><td><p>En space</p></td><td></td></tr><tr><td><p>Quarter em space</p></td><td></td><td><p>Non breaking space</p></td><td></td></tr><tr><td><p>Copyright</p></td><td></td><td><p>Registered</p></td><td></td></tr><tr><td><p>Trademark</p></td><td></td><td><p>Section</p></td><td></td></tr><tr><td><p>Paragraph</p></td><td></td><td><p>Ellipses</p></td><td></td></tr><tr><td><p>Single opening quote</p></td><td></td><td><p>Single closing quote</p></td><td></td></tr><tr><td><p>Double opening quote</p></td><td></td><td><p>Double closing quote</p></td><td></td></tr><tr><td><p>No width optional break</p></td><td></td><td><p>No width non break</p></td><td></td></tr></tbody></table>');


    }//end testWordTableExamplesDocCopyPaste()


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
        $this->assertHTMLMatch('<h1>Lorem Ipsum</h1><p>Lorem Ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 1</p><p>Lorem ipsum&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 2</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien. <a href="http://www.google.com.au">Suspendisse</a> vehicula tortor a purus vestibulum eget bibendum est auctor. Donec neque turpis, dignissim et viverra nec, ultricies et libero. Suspendisse potenti.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien</p><h2>Lorem ipsum</h2><p><img alt="Description: Macintosh HD:Applications:Microsoft Office 2011:Office:Media:Clipart: Business.localized:AA006219.png" height="137" hspace="9" src="" width="92" />Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ul><li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit.</li><li>Phasellus ornare ipsum nec felis      lacinia a feugiat lectus pellentesque. <ul><li>Lorem ipsum dolor sit amet,       consectetur adipiscing elit.</li><li>Lorem ipsum dolor sit amet,       consectetur adipiscing elit.<ul><li>Praesent in sapien sapien</li></ul></li><li>Praesent in sapien sapien</li></ul></li><li>Praesent in sapien sapien.</li></ul><h3>Lorem ipsum</h3><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.e.</p><p>Social Networking ToolsLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien. Social Networking ToolsLorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><table border="1" style="width: 100%;"><thead><tr><th><p><strong>Col1 Header</strong></p></th><th><p><strong>Col2 Header</strong></p></th><th><p><strong>Col3 Header</strong></p></th></tr></thead><tbody><tr><td><p>nec porta ante</p></td><td><p>sapien vel aliquet</p></td><td><ul><li>purus neque luctus ligula, vel molestie  arcu</li><li>purus neque luctus</li><li>vel molestie arcu</li></ul></td></tr><tr><td><p>nec porta ante</p></td><td colspan="2"><p>purus neque luctus <a href="http://www.google.com"><strong>ligula</strong></a>,   vel molestie arcu</p></td></tr><tr><td><p>nec <strong>porta</strong> ante</p></td><td><p>sapien vel aliquet</p></td><td rowspan="2"><p>purus neque luctus   ligula, vel molestie arcu</p></td></tr><tr><td colspan="2"><p>sapien vel aliquet</p></td></tr></tbody></table><p><strong></strong></p><h2>Lorem ipsum</h2><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol><li>Lorem ipsum dolor sit amet, consectetur      adipiscing elit.</li><li>Phasellus ornare ipsum nec felis      lacinia a feugiat lectus pellentesque. <ol><li>Lorem ipsum dolor sit amet,       consectetur adipiscing elit</li><li>Lorem ipsum dolor sit amet,       consectetur adipiscing elit</li></ol></li><li>Praesent in sapien sapien.</li></ol><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</p><ol><li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit. <ul><li>Phasellus ornare ipsum nec felis       lacinia a feugiat lectus pellentesque.</li><li>Praesent in sapien sapien.</li></ul></li><li>Lorem ipsum dolor sit amet,      consectetur adipiscing elit</li></ol>');

    }//end testViperTestDocCopyPaste()


}//end class

?>
