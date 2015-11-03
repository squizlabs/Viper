<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_CopyAndCutFormatsUnitTest extends AbstractViperUnitTest
{

    /**
     * Test that you can copy and paste inside different formats.
     *
     * @return void
     */
    public function testCopyAndPasteInsideFormats()
    {
        // Test copy and paste inside a pre section
        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><pre>Lorum this is more content %1% to test %2%%1% to test %2%</pre>');

        // Test copy and paste inside a div section
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%%1% to test %2%</div>');

        // Test copy and paste inside a quoote section
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><blockquote><p>Lorum this is more content %1% to test %2%%1% to test %2%</p></blockquote>');

        // Test copy and paste inside a p section
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>Lorum this is more content %1% to test %2%%1% to test %2%</p>');

    }//end testCopyAndPasteInsideFormats()


    /**
     * Test copy and paste a section of different formats.
     *
     * @return void
     */
    public function testCopyAndPasteASectionOfAFormat()
    {
        // Test copyd and paste a pre section
        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(2);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<p>First paragraph</p><pre>Lorum this is more content %1% to test %2%</pre><p>%1% to test %2%</p>');

        // Test copy and paste a div section
        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%</div><p>%1% to test %2%</p>');

        // Test copy and paste a quote section
        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<p>First paragraph</p><blockquote><p>Lorum this is more content %1% to test %2%</p><p>%1% to test %2%</p></blockquote>');

        // Test copy and paste a paragraph section
        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<p>Lorum this is more content %1% to test %2%</p><p>%1% to test %2%</p>');

    }//end testCopyAndPasteASectionOfAFormat()


    /**
     * Test copy and paste a format section.
     *
     * @return void
     */
    public function testCopyAndPasteFormats()
    {
        // Test copy and paste a pre
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        $this->assertHTMLMatch('<p>First paragraph</p><pre>Lorum this is more content %1% to test %2%</pre><pre>Lorum this is more content %1% to test %2%</pre>');
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'));
        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'));

        // Test copy and paste a div section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%</div><div>Lorum this is more content %1% to test %2%</div>');
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'));
        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('formats-div', 'active'));

        // Test copy and paste a quote section
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><blockquote><p>Lorum this is more content %1% to test %2%</p></blockquote><blockquote><p>Lorum this is more content %1% to test %2%</p></blockquote>');
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'));
        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('formats-blockquote', 'active'));

        // Test copy and paste a paragraph section
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>Lorum this is more content %1% to test %2%</p><p>Lorum this is more content %1% to test %2%</p>');
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));
        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->assertTrue($this->topToolbarButtonExists('formats-p', 'active'));

    }//end testCopyAndPasteASectionOfAFormats()


    /**
     * Test copy and paste a Pre section inside a pre section.
     *
     * @return void
     */
    public function testCopyAndPastePreFormat()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->type('First paste ');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><pre>Lorum this is more content %1% to test %2% First paste &lt;pre&gt;Lorum this is more content %1% to test %2%&lt;/pre&gt;</pre>');

        // Paste again to make sure the character is still there.
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->type('Second paste ');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><pre>Lorum this is more content %1% to test %2% First paste &lt;pre&gt;Lorum this is more content %1% to test %2%&lt;/pre&gt; Second paste &lt;pre&gt;Lorum this is more content %1% to test %2%&lt;/pre&gt;   </pre>');

        // Paste again in a new pre section
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><pre>Lorum this is more content %1% to test %2% First paste &lt;pre&gt;Lorum this is more content %1% to test %2%&lt;/pre&gt; Second paste &lt;pre&gt;Lorum this is more content %1% to test %2%&lt;/pre&gt;</pre><pre>Lorum this is more content %1% to test %2%</pre>');

    }//end testCopyAndPastePreFormat()


    /**
     * Test pasting HTML into a Pre section.
     *
     * @return void
     */
    public function testPastingHtmlIntoPre()
    {
        $this->useTest(7);
        $this->selectKeyword(3);
        $this->pasteFromURL($this->getTestURL('/ViperCopyPastePlugin/CopyPasteFiles/HtmlCode.txt'));
        sleep(5);
        $this->assertHTMLMatch('<p>First paragraph<strong>%1% bold content %2%</strong></p><pre>Lorum this is more content &lt;strong&gt;strong tags&lt;/strong&gt; &lt;ul&gt;&lt;li&gt;List item&lt;/li&gt;&lt;li&gt;List item&lt;/li&gt;&lt;/ul&gt;  to test</pre>');

        $this->useTest(7);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.CMD + c');
        $this->sikuli->keyDown('Key.RIGHT');
        $this->sikuli->keyDown('Key.ENTER');
        $this->clickTopToolbarButton('formats-p', 'active');
        sleep(1);
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph<strong>%1% bold content %2%</strong></p><pre>&lt;strong&gt;%1% bold content %2%&lt;/strong&gt;</pre><pre>Lorum this is more content %3% to test</pre>');
        $this->clickTopToolbarButton('P', NULL, TRUE);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph<strong>%1% bold content %2%</strong></p><p>&lt;strong&gt;%1% bold content %2%&lt;/strong&gt;<strong>%1% bold content %2%</strong></p><pre>Lorum this is more content %3% to test</pre>');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);
        sleep(1);
        $this->type(' ');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);

        if ($this->sikuli->getBrowserid() === 'safari') {
            $this->assertHTMLMatch('<p>First paragraph<strong>XAX bold content XBX</strong></p><pre>&lt;strong&gt;XAX bold content XBX&lt;/strong&gt;<strong>XAX bold content XBX &lt;strong&gt;XAX bold content XBX&lt;/strong&gt;</strong></pre><pre>Lorum this is more content XCX to test</pre>');
            $this->clickTopToolbarButton('PRE', 'active', TRUE);
            sleep(1);
            $this->assertHTMLMatch('<p>First paragraph<strong>XAX bold content XBX</strong></p><p>&lt;strong&gt;XAX bold content XBX&lt;/strong&gt;<strong>XAX bold content XBX &lt;strong&gt;XAX bold content XBX&lt;/strong&gt;</strong></p><pre>Lorum this is more content XCX to test</pre>');
        } else {
            $this->assertHTMLMatch('<p>First paragraph<strong>XAX bold content XBX</strong></p><pre>&lt;strong&gt;XAX bold content XBX&lt;/strong&gt;<strong>XAX bold content XBX</strong> &lt;strong&gt;XAX bold content XBX&lt;/strong&gt;</pre><pre>Lorum this is more content XCX to test</pre>');
            $this->clickTopToolbarButton('PRE', 'active', TRUE);
            sleep(1);
            $this->assertHTMLMatch('<p>First paragraph<strong>XAX bold content XBX</strong></p><p>&lt;strong&gt;XAX bold content XBX&lt;/strong&gt;<strong>XAX bold content XBX</strong> &lt;strong&gt;XAX bold content XBX&lt;/strong&gt;</p><pre>Lorum this is more content XCX to test</pre>');
        }

    }//end testPastingHtmlIntoPre()


    /**
     * Test copying and pasting different block elements.
     *
     * @return void
     */
    public function testCopyPasteBlockElements()
    {
        // Test paragraph
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(2);
        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<p>This is a paragraph section %1%</p><div>This is a div section %2%</div><pre>This is a pre section %3%</pre><blockquote><p>This is a quote section %4%</p></blockquote><p>Space paragraph</p><p>Another paragraph %5%</p><p>This is a paragraph section %1%</p>');

        // Test div
        $this->useTest(5);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(2);
        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<p>This is a paragraph section %1%</p><div>This is a div section %2%</div><pre>This is a pre section %3%</pre><blockquote><p>This is a quote section %4%</p></blockquote><p>Space paragraph</p><p>Another paragraph %5%</p><div>This is a div section %2%</div>');

        // Test pre
        $this->useTest(5);
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(2);
        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<p>This is a paragraph section %1%</p><div>This is a div section %2%</div><pre>This is a pre section %3%</pre><blockquote><p>This is a quote section %4%</p></blockquote><p>Space paragraph</p><p>Another paragraph %5%</p><pre>This is a pre section %3%</pre>');

        // Test quote
        $this->useTest(5);
        $this->selectKeyword(4);
        sleep(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(2);
        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<p>This is a paragraph section %1%</p><div>This is a div section %2%</div><pre>This is a pre section %3%</pre><blockquote><p>This is a quote section %4%</p></blockquote><p>Space paragraph</p><p>Another paragraph %5%</p><blockquote><p>This is a quote section %4%</p></blockquote>');

    }//end testCopyPasteBlockElements()


    /**
     * Test copy and pasting a heading.
     *
     * @return void
     */
    public function testCopyPasteHeading()
    {
        $this->useTest(6);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<h1>Heading One %1%</h1><p>This is a paragraph %2%</p><h1>Heading One %1%</h1><h2>Heading Two %3%</h2><p>This is another paragraph %4%</p>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + c');
        sleep(1);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<h1>Heading One %1%</h1><p>This is a paragraph %2%</p><h1>Heading One %1%</h1><h2>Heading Two %3%</h2><p>This is another paragraph %4%</p><h2>Heading Two %3%</h2>');

    }//end testCopyPasteHeading()





    /**
     * Test that you can cut and paste inside different formats.
     *
     * @return void
     */
    public function testCutAndPasteInsideFormats()
    {
        // Test cut and paste inside a pre section
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><pre>Lorum this is more content  to test %2%%1%</pre>');

        // Test cut and paste inside a div section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<div>Lorum this is more content&nbsp;&nbsp;to test %2%%1%</div>');

        // Test cut and paste inside a quote section
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><blockquote><p>Lorum this is more content&nbsp;&nbsp;to test %2%%1%</p></blockquote>');

        // Test cut and paste inside a p section
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>Lorum this is more content&nbsp;&nbsp;to test %2%%1%</p>');

    }//end testCutAndPasteInsideFormats()


    /**
     * Test cut and paste a section of different formats.
     *
     * @return void
     */
    public function testCutAndPasteASectionOfAFormat()
    {
        // Test cut and paste a pre section
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(2);
        $this->sikuli->keyDown('Key.ENTER');
        sleep(2);
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<p>First paragraph</p><pre>Lorum this is more content  to test %2%</pre><p>%1%</p>');

        // Test cut and paste a div section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<div>Lorum this is more content&nbsp;&nbsp;to test %2%</div><p>%1%</p>');

        // Test cut and paste a quote section
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<p>First paragraph</p><blockquote><p>Lorum this is more content&nbsp;&nbsp;to test %2%</p><p>%1%</p></blockquote>');

        // Test cut and paste a paragraph section
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<p>Lorum this is more content&nbsp;&nbsp;to test %2%</p><p>%1%</p>');

    }//end testCutAndPasteASectionOfAFormat()


    /**
     * Test cut and paste a format section.
     *
     * @return void
     */
    public function testCutAndPasteFormats()
    {
        // Test cut and paste a pre
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><pre>Lorum this is more content %1% to test %2%</pre>');

        // Test cut and paste a div section
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<div>Lorum this is more content %1% to test %2%</div>');

        // Test cut and paste a quote section
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><blockquote><p>Lorum this is more content %1% to test %2%</p></blockquote>');

        // Test cut and paste a paragraph section
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>Lorum this is more content %1% to test %2%</p>');

    }//end testCopyAndPasteASectionOfAFormats()


    /**
     * Test cut and paste a Pre section inside a pre section.
     *
     * @return void
     */
    public function testCutAndPastePreFormat()
    {
        $this->useTest(1);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + x');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->type('First paste ');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><p>First paste </p><pre>Lorum this is more content %1% to test %2%</pre>');

        // Paste again to make sure the character is still there.
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->type('Second paste ');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><p>First paste </p><pre>Lorum this is more content %1% to test %2% Second paste &lt;pre&gt;Lorum this is more content %1% to test %2%&lt;/pre&gt; </pre>');

        // Paste again in a new pre section
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        sleep(1);
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>First paragraph</p><p>First paste </p><pre>Lorum this is more content %1% to test %2% Second paste &lt;pre&gt;Lorum this is more content %1% to test %2%&lt;/pre&gt;</pre><pre>Lorum this is more content %1% to test %2%</pre>');

    }//end testCutAndPastePreFormat()


    /**
     * Test cutting and pasting different block elements.
     *
     * @return void
     */
    public function testCutPasteBlockElements()
    {
        // Test paragraph
        $this->useTest(5);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + x');
        sleep(2);
        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<div>This is a div section %2%</div><pre>This is a pre section %3%</pre><blockquote><p>This is a quote section %4%</p></blockquote><p>Space paragraph</p><p>Another paragraph %5%</p><p>This is a paragraph section %1%</p>');

        // Test div
        $this->useTest(5);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + x');
        sleep(2);
        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<p>This is a paragraph section %1%</p><pre>This is a pre section %3%</pre><blockquote><p>This is a quote section %4%</p></blockquote><p>Space paragraph</p><p>Another paragraph %5%</p><div>This is a div section %2%</div>');

        // Test pre
        $this->useTest(5);
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + x');
        sleep(2);
        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<p>This is a paragraph section %1%</p><div>This is a div section %2%</div><blockquote><p>This is a quote section %4%</p></blockquote><p>Space paragraph</p><p>Another paragraph %5%</p><pre>This is a pre section %3%</pre>');

        // Test quote
        $this->useTest(5);
        $this->selectKeyword(4);
        sleep(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + x');
        sleep(2);
        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(2);
        $this->assertHTMLMatch('<p>This is a paragraph section %1%</p><div>This is a div section %2%</div><pre>This is a pre section %3%</pre><p>Space paragraph</p><p>Another paragraph %5%</p><blockquote><p>This is a quote section %4%</p></blockquote>');

    }//end testCutPasteBlockElements()


    /**
     * Test cut and pasting a heading.
     *
     * @return void
     */
    public function testCutPasteHeading()
    {
        $this->useTest(6);

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + x');
        sleep(1);
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>This is a paragraph %2%</p><h1>Heading One %1%</h1><h2>Heading Two %3%</h2><p>This is another paragraph %4%</p>');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->sikuli->keyDown('Key.CMD + x');
        sleep(1);
        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.CMD + v');
        sleep(1);
        $this->assertHTMLMatch('<p>This is a paragraph %2%</p><h1>Heading One %1%</h1><p>This is another paragraph %4%</p><h2>Heading Two %3%</h2>');

    }//end testCutPasteHeading()


}//end class

?>
