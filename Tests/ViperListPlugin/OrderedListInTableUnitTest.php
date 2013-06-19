<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_OrderedListInTableUnitTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test a list can be created inside a table cell.
     *
     * @return void
     */
    public function testCreatingAListInACell()
    {
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ol><li>UnaU %1% FoX Mnu</li></ol></td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1</li><li>%3%</li></ol></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1</li><li>%3%</li></ol></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testCreatingAListInACell()


    /**
     * Test a list can be indented and outdented using the top toolbar icons.
     *
     * @return void
     */
    public function testIndentingAndOutdentingAListItemUsingTopToolbar()
    {
        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1<ol><li>%3%</li></ol></li></ol></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1</li><li>%3%</li></ol></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1</li></ol><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
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
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1<ol><li>%3%</li></ol></li></ol></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1</li><li>%3%</li></ol></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1</li></ol><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
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
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1<ol><li>%3%</li></ol></li></ol></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(3));
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1</li><li>%3%</li></ol></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->click($this->findKeyword(2));
        $this->click($this->findKeyword(3));
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1</li></ol><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        $this->click($this->getMouseLocation());
        sleep(1);
        $this->keyDown('Key.TAB');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1</li></ol><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, FALSE);

    }//end testIndentingAndOutdentingAListItemUsingShortcuts()


    /**
     * Test a list is removed using the ordered list icon.
     *
     * @return void
     */
    public function testRemovingListUsingOrderedListIcon()
    {
        $this->click($this->findKeyword(3));
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickTopToolbarButton('listOL', 'active');

        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><p>item1</p><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testRemovingListUsingOrderedListIcon()


    /**
     * Test a list is removed using the outdent icon.
     *
     * @return void
     */
    public function testRemovingListUsingOutdentIcon()
    {
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><p>item1</p><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        // Click undo so we can test the top toolbar
        $this->clickTopToolbarButton('historyUndo');

        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(4);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><p>item1</p><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testRemovingListUsingOutdentIcon()


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

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1</li><li>%3%</li></ol></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><p>item1</p><p>%3%</p></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testRemovingListAndClickingUndo()


    /**
     * Test a list can be created inside a table cell.
     *
     * @return void
     */
    public function testCreateListAndClickingUndo()
    {
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ol><li>UnaU %1% FoX Mnu</li></ol></td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1</li><li>%3%</li></ol></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td>UnaU %1% FoX Mnu</td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1</li><li>%3%</li></ol></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatchNoHeaders('<table border="1" cellpadding="2" cellspacing="3"><caption><strong>Table 1.2:</strong> The table caption text goes here la</caption><tbody><tr><th>Col1 Header</th><th>Col2 Header</th><th>Col3 Header</th></tr><tr><td><ol><li>UnaU %1% FoX Mnu</li></ol></td><td><strong><em>%2%</em></strong> sapien vel aliquet</td><td><ol><li>item1</li><li>%3%</li></ol></td></tr><tr><td><h3>blah</h3></td><td colspan="2">purus neque luctus <strong><a href="http://www.google.com">ligula</a></strong>, vel molestie arcu</td></tr></tbody></table>');

    }//end testCreateListAndClickingUndo()


    /**
     * Test list icon not available when you select all content in a row.
     *
     * @return void
     */
    public function testSelectingAllContentInARow()
    {
        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE);

    }//end testSelectingAllContentInARow()


}//end class

?>
