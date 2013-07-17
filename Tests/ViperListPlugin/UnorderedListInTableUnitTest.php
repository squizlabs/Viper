<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_UnorderedListInTableUnitTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test a list can be created inside a table cell.
     *
     * @return void
     */
    public function testCreatingAListInACell()
    {
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ul><li>UnaU %1% FoX Mnu</li></ul></td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1</li><li>%3%</li></ul></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1</li><li>%3%</li></ul></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testCreatingAListInACell()


    /**
     * Test a list can be indented and outdented using the top toolbar icons.
     *
     * @return void
     */
    public function testIndentingAndOutdentingAListItemUsingTopToolbar2()
    {
        $this->click($this->findKeyword(3));
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1<ul><li>%3%</li></ul></li></ul></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1</li><li>%3%</li></ul></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1</li></ul><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testIndentingAndOutdentingAListItemUsingTopToolbar()


    /**
     * Test a list can be indented and outdented using the inline toolbar icons.
     *
     * @return void
     */
    public function testIndentingAndOutdentingAListItemUsingInlineToolbar()
    {
        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1<ul><li>%3%</li></ul></li></ul></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1</li><li>%3%</li></ul></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1</li></ul><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testIndentingAndOutdentingAListItemUsingInlineToolbar()


    /**
     * Test a list can be indented and outdented using keyboard shortcuts.
     *
     * @return void
     */
    public function testIndentingAndOutdentingAListItemUsingShortcuts()
    {
        $this->click($this->findKeyword(3));
        $this->keyDown('Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1<ul><li>%3%</li></ul></li></ul></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(3));
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1</li><li>%3%</li></ul></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(3));
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1</li></ul><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        $this->click($this->getMouseLocation());
        sleep(1);
        $this->keyDown('Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1</li></ul><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, FALSE);

    }//end testIndentingAndOutdentingAListItemUsingShortcuts()


    /**
     * Test a list is removed using the unordered list icon.
     *
     * @return void
     */
    public function testRemovingListUsingUnorderedListIcon()
    {
        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><p>item1</p><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testRemovingListUsingUnorderedListIcon()


    /**
     * Test a list is removed using the outdent icon in the top toolbar.
     *
     * @return void
     */
    public function testRemovingListUsingOutdentIconInTopToolbar1()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(4);

        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><p>item1</p><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testRemovingListUsingOutdentIconInTopToolbar()


    /**
     * Test a list is removed using the outdent icon in the inline toolbar.
     *
     * @return void
     */
    public function testRemovingListUsingOutdentIconInInlineToolbar()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(4);

        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><p>item1</p><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testRemovingListUsingOutdentIconInInlineToolbar()


    /**
     * Test a removing a list and then clicking undo.
     *
     * @return void
     */
    public function testRemovingListAndClickingUndo()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(4);

        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><p>item1</p><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1</li><li>%3%</li></ul></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testRemovingListUsingOutdentIconInInlineToolbar()


    /**
     * Test a list can be created inside a table cell.
     *
     * @return void
     */
    public function testCreateListAndClickingUndo()
    {
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ul><li>UnaU %1% FoX Mnu</li></ul></td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1</li><li>%3%</li></ul></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1</li><li>%3%</li></ul></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ul><li>UnaU %1% FoX Mnu</li></ul></td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ul><li>item1</li><li>%3%</li></ul></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testCreateListAndClickingUndo()


    /**
     * Test list icon not available when you select all content in a row.
     *
     * @return void
     */
    public function testSelectingAllContentInARow()
    {
        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE);

    }//end testSelectingAllContentInARow()


}//end class

?>
