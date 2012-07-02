<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_FormatInTablesUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that heading styles can be applied to the text in a cell.
     *
     * @return void
     */
    public function testHeadingStylesInTable()
    {
        $this->click($this->findKeyword(2));
        $this->clickTopToolbarButton('headings');
        $this->clickTopToolbarButton('H3', NULL, TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><h3>aa %2% kk</h3></td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('headings', 'active');
        $this->clickTopToolbarButton('H2', NULL, TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><h2>aa %2% kk</h2></td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->clickTopToolbarButton('headings', 'active');
        $this->clickTopToolbarButton('H1', NULL, TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><h1>aa %2% kk</h1></td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('headings', 'active');
        $this->clickTopToolbarButton('H1', 'active', TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><p>aa %2% kk</p></td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testHeadingStylesInTableMouseSelect()


    /**
     * Test that classes can be applied to a word in a table cell.
     *
     * @return void
     */
    public function testClassesOnWordInTable()
    {
        $this->selectKeyword(4);

        $this->clickInlineToolbarButton('cssClass');
        $this->type('abc');
        $this->clickInlineToolbarButton('Update Changes', NULL, TRUE);
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');

        $this->clickInlineToolbarButton('cssClass', 'selected');

        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>aa %2% kk</td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec <span class="abc">%4%</span> ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->click($this->findKeyword(3));
        $this->selectKeyword(2);

        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');
        $this->assertTrue($this->inlineToolbarButtonExists('Update Changes', 'disabled', TRUE), 'Update Changes button should be disabled.');

        $this->clickInlineToolbarButton('cssClass', 'selected');

        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists('cssClass', 'active'), 'Class icon in VITP should be active.');

        $this->removeTableHeaders();
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>aa <span class="test">%2%</span> kk</td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec <span class="abc">%4%</span> ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testClassesOnWordInTable()


    /**
     * Test that classes can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testClassesOnContentInACellOfATable()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickInlineToolbarButton('cssClass');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertTrue($this->topToolbarButtonExists('cssClass', 'active'), 'Class icon in Top Toolbar should be active.');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td class="test">aa %2% kk</td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testClassesOnContentInACellOfATable()


    /**
     * Test that left alignment can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testLeftAlignmentInATable()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyLeft');

        $this->assertTrue($this->topToolbarButtonExists('justifyLeft', 'active'), 'Left align icon is not acitve in the top toolbar');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td style="text-align: left;">aa %2% kk</td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testLeftAlignmentInATable()


    /**
     * Test that right alignment can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testRightAlignmentInATable()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyRight');

        $this->assertTrue($this->topToolbarButtonExists('justifyRight', 'active'), 'Right align icon is not acitve in the top toolbar');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td style="text-align: right;">aa %2% kk</td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testRightAlignmentInATable()


    /**
     * Test that centre alignment can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testCentreAlignmentInATable()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyCenter');

        $this->assertTrue($this->topToolbarButtonExists('justifyCenter', 'active'), 'Centre align icon is not acitve in the top toolbar');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td style="text-align: center;">aa %2% kk</td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testCentreAlignmentInATable()


    /**
     * Test that justify alignment can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testJustifyAlignmentInATable()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('justifyLeft');
        sleep(1);
        $this->clickTopToolbarButton('justifyBlock');

        $this->assertTrue($this->topToolbarButtonExists('justifyBlock', 'active'), 'Justify align icon is not acitve in the top toolbar');

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td style="text-align: justify;">aa %2% kk</td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testJustifyAlignmentInATable()


    /**
     * Test that the P tag can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testPInATable()
    {

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('P', NULL, TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><p>aa %2% kk</p></td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('P', 'active', TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>aa %2% kk</td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testPInATable()


    /**
     * Test that the PRE tag can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testPreInATable()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><pre>aa %2% kk</pre></td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('PRE', 'active', TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>aa %2% kk</td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testPreInATable()


    /**
     * Test that the DIV tag can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testDivInATable()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><div>aa %2% kk</div></td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>aa %2% kk</td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testDivInATable()


    /**
     * Test that the Quote tag can be applied to the content in a table cell.
     *
     * @return void
     */
    public function testQuoteInATable()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('Quote', NULL, TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><blockquote>aa %2% kk</blockquote></td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table %1% text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>aa %2% kk</td><td>%3%</td><td>            <ul><li>purus neque luctus ligula, vel molestie arcu</li><li>purus neque luctus</li></ul>        </td></tr><tr><td>nec %4% ante</td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testQuoteInATable()


    /**
     * Test applying the Pre tag to a cell that has a single word in it.
     *
     * @return void
     */
    public function testPreInATableWithOneWord()
    {
        $this->click($this->findKeyword(1));

        $this->clickTopToolbarButton('formats');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><tbody><tr><th>Col1 Header</th><th>Col2 Header</th></tr><tr><td>XuT is in a table</td><td><pre>%1%</pre></td></tr></tbody></table>');

        $this->clickTopToolbarButton('PRE', 'active', TRUE);

        $this->execJS('rmTableHeaders(0,true)');
        $this->assertHTMLMatch('<table border="1" cellpadding="2" cellspacing="3"><tbody><tr><th>Col1 Header</th><th>Col2 Header</th></tr><tr><td>XuT is in a table</td><td>%1%</td></tr></tbody></table>');

    }//end testPreInATableWithOneWord()


    /**
     * Test heading and format is disabled in a table caption.
     *
     * @return void
     */
    public function testHeadingAndFormatsIsDisabledInCaption()
    {

        $this->click($this->findKeyword(1));
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled');

        $this->selectKeyword(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists('headings', 'disabled'), 'Heading icon should be disabled');
        $this->assertTrue($this->topToolbarButtonExists('formats', 'disabled'), 'Formats icon should be disabled');

    }//end testHeadingAndFormatsIsDisabled()


}//end class

?>
