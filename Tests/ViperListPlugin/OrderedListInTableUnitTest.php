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
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LAbS');

        $this->clickTopToolbarButton($dir.'toolbarIcon_orderedList.png');

        $this->assertEquals('<ol><li>UnaU LAbS FoX Mnu</li></ol>', $this->getHtml('td', 0));
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->clickTopToolbarButton($dir.'toolbarIcon_orderedList_active.png');
        $this->assertEquals('UnaU LAbS FoX Mnu', $this->getHtml('td', 0));
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testCreatingAListInACell()


    /**
     * Test a list can be indented and outdented using the top toolbar icons.
     *
     * @return void
     */
    public function testIndentingAndOutdentingAListItemUsingTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->click($this->find('XuT'));
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->clickTopToolbarButton($dir.'toolbarIcon_indent.png');

        $this->assertEquals('            <ol><li>Item 1<ol><li>Item 2 XuT</li></ol></li></ol>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->clickTopToolbarButton($dir.'toolbarIcon_outdent.png');
        $this->assertEquals('            <ol><li>Item 1</li><li>Item 2 XuT</li></ol>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->clickTopToolbarButton($dir.'toolbarIcon_outdent.png');
        $this->assertEquals('            <ol><li>Item 1</li></ol><p>Item 2 XuT</p>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        $this->clickTopToolbarButton($dir.'toolbarIcon_indent.png');
        $this->assertEquals('            <ol><li>Item 1</li><li>Item 2 XuT</li></ol>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

    }//end testIndentingAndOutdentingAListItemUsingTopToolbar()


    /**
     * Test a list can be indented and outdented using the inline toolbar icons.
     *
     * @return void
     */
    public function testIndentingAndOutdentingAListItemUsingInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_indent.png');

        $this->assertEquals('            <ol><li>Item 1<ol><li>Item 2 XuT</li></ol></li></ol>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_outdent.png');
        $this->assertEquals('            <ol><li>Item 1</li><li>Item 2 XuT</li></ol>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_outdent.png');
        $this->assertEquals('            <ol><li>Item 1</li></ol><p>Item 2 XuT</p>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        $this->clickTopToolbarButton($dir.'toolbarIcon_indent.png');
        $this->assertEquals('            <ol><li>Item 1</li><li>Item 2 XuT</li></ol>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

    }//end testIndentingAndOutdentingAListItemUsingInlineToolbar()


    /**
     * Test a list can be indented and outdented using keyboard shortcuts.
     *
     * @return void
     */
    public function testIndentingAndOutdentingAListItemUsingShortcuts()
    {

        $this->click($this->find('XuT'));
        $this->keyDown('Key.TAB');
        $this->assertEquals('            <ol><li>Item 1<ol><li>Item 2 XuT</li></ol></li></ol>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->click($this->find('WoW'));
        $this->click($this->find('XuT'));
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertEquals('            <ol><li>Item 1</li><li>Item 2 XuT</li></ol>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->click($this->find('WoW'));
        $this->click($this->find('XuT'));
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertEquals('            <ol><li>Item 1</li></ol><p>Item 2 XuT</p>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        $this->click($this->find('WoW'));
        $this->click($this->find('XuT'));
        $this->keyDown('Key.TAB');
        $this->assertEquals('            <ol><li>Item 1</li><li>Item 2 XuT</li></ol>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

    }//end testIndentingAndOutdentingAListItemUsingShortcuts()


    /**
     * Test a list is removed using the ordered list icon.
     *
     * @return void
     */
    public function testRemovingListUsingOrderedListIcon()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->click($this->find('XuT'));
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->clickTopToolbarButton($dir.'toolbarIcon_orderedList_active.png');

        $this->assertEquals('            <p>Item 1</p><p>Item 2 XuT</p>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

    }//end testRemovingListUsingOrderedListIcon()


    /**
     * Test a list is removed using the outdent icon in the top toolbar.
     *
     * @return void
     */
    public function testRemovingListUsingOutdentIconInTopToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(4);

        $this->clickTopToolbarButton($dir.'toolbarIcon_outdent.png');

        $this->assertEquals('            <p>Item 1</p><p>Item 2 XuT</p>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testRemovingListUsingOutdentIconInTopToolbar()


    /**
     * Test a list is removed using the outdent icon in the inline toolbar.
     *
     * @return void
     */
    public function testRemovingListUsingOutdentIconInInlineToolbar()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(4);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_outdent.png');

        $this->assertEquals('            <p>Item 1</p><p>Item 2 XuT</p>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testRemovingListUsingOutdentIconInInlineToolbar()


    /**
     * Test a removing a list and then clicking undo.
     *
     * @return void
     */
    public function testRemovingListAndClickingUndo()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(4);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_outdent.png');

        $this->assertEquals('            <p>Item 1</p><p>Item 2 XuT</p>', $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undoIcon_active.png');

        $this->assertEquals('            <ol><li>Item 1</li><li>Item 2 XuT</li></ol>', $this->getHtml('td', 2));

    }//end testRemovingListUsingOutdentIconInInlineToolbar()


    /**
     * Test list icon not available when you select all content in a row.
     *
     * @return void
     */
    public function testSelectingAllContentInARow()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('XuT');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE);

        $this->selectText('WoW');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(FALSE, FALSE, FALSE, FALSE);

    }//end testSelectingAllContentInARow()


}//end class

?>
