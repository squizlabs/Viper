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

        $this->assertEquals($this->replaceKeywords('<ul><li>UnaU %1% FoX Mnu</li></ul>'), $this->getHtml('td', 0));
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertEquals($this->replaceKeywords('UnaU %1% FoX Mnu'), $this->getHtml('td', 0));
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testCreatingAListInACell()


    /**
     * Test a list can be indented and outdented using the top toolbar icons.
     *
     * @return void
     */
    public function testIndentingAndOutdentingAListItemUsingTopToolbar()
    {
        $this->click($this->findKeyword(2));
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickTopToolbarButton('listIndent');

        $this->assertEquals($this->replaceKeywords('            <ul><li>Item 1<ul><li>Item 2 %2%</li></ul></li></ul>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->clickTopToolbarButton('listOutdent');
        $this->assertEquals($this->replaceKeywords('            <ul><li>Item 1</li><li>Item 2 %2%</li></ul>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickTopToolbarButton('listOutdent');
        $this->assertEquals($this->replaceKeywords('            <ul><li>Item 1</li></ul><p>Item 2 %2%</p>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testIndentingAndOutdentingAListItemUsingTopToolbar()


    /**
     * Test a list can be indented and outdented using the inline toolbar icons.
     *
     * @return void
     */
    public function testIndentingAndOutdentingAListItemUsingInlineToolbar()
    {
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickInlineToolbarButton('listIndent');

        $this->assertEquals($this->replaceKeywords('            <ul><li>Item 1<ul><li>Item 2 %2%</li></ul></li></ul>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->clickInlineToolbarButton('listOutdent');
        $this->assertEquals($this->replaceKeywords('            <ul><li>Item 1</li><li>Item 2 %2%</li></ul>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickInlineToolbarButton('listOutdent');
        $this->assertEquals($this->replaceKeywords('            <ul><li>Item 1</li></ul><p>Item 2 %2%</p>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testIndentingAndOutdentingAListItemUsingInlineToolbar()


    /**
     * Test a list can be indented and outdented using keyboard shortcuts.
     *
     * @return void
     */
    public function testIndentingAndOutdentingAListItemUsingShortcuts()
    {

        $this->click($this->findKeyword(2));
        $this->keyDown('Key.TAB');
        $this->assertEquals($this->replaceKeywords('            <ul><li>Item 1<ul><li>Item 2 %2%</li></ul></li></ul>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->click($this->findKeyword(3));
        $this->click($this->findKeyword(2));
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertEquals($this->replaceKeywords('            <ul><li>Item 1</li><li>Item 2 %2%</li></ul>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->click($this->findKeyword(3));
        $this->click($this->findKeyword(2));
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertEquals($this->replaceKeywords('            <ul><li>Item 1</li></ul><p>Item 2 %2%</p>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        $this->click($this->findKeyword(3));
        $this->click($this->findKeyword(2));
        $this->keyDown('Key.TAB');
        $this->assertEquals($this->replaceKeywords('            <ul><li>Item 1</li></ul><p>Item 2 %2%</p>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testIndentingAndOutdentingAListItemUsingShortcuts()


    /**
     * Test a list is removed using the unordered list icon.
     *
     * @return void
     */
    public function testRemovingListUsingUnorderedListIcon()
    {
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickTopToolbarButton('listUL', 'active');

        $this->assertEquals($this->replaceKeywords('            <p>Item 1</p><p>Item 2 %2%</p>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testRemovingListUsingUnorderedListIcon()


    /**
     * Test a list is removed using the outdent icon in the top toolbar.
     *
     * @return void
     */
    public function testRemovingListUsingOutdentIconInTopToolbar()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);

        $this->clickTopToolbarButton('listOutdent');

        $this->assertEquals($this->replaceKeywords('            <p>Item 1</p><p>Item 2 %2%</p>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testRemovingListUsingOutdentIconInTopToolbar()


    /**
     * Test a list is removed using the outdent icon in the inline toolbar.
     *
     * @return void
     */
    public function testRemovingListUsingOutdentIconInInlineToolbar()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);

        $this->clickInlineToolbarButton('listOutdent');

        $this->assertEquals($this->replaceKeywords('            <p>Item 1</p><p>Item 2 %2%</p>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

    }//end testRemovingListUsingOutdentIconInInlineToolbar()


    /**
     * Test a removing a list and then clicking undo.
     *
     * @return void
     */
    public function testRemovingListAndClickingUndo()
    {
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(4);

        $this->clickInlineToolbarButton('listOutdent');

        $this->assertEquals($this->replaceKeywords('            <p>Item 1</p><p>Item 2 %2%</p>'), $this->getHtml('td', 2));
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);

        $this->clickTopToolbarButton('historyUndo');

        $this->assertEquals($this->replaceKeywords('            <ul><li>Item 1</li><li>Item 2 %2%</li></ul>'), $this->getHtml('td', 2));

    }//end testRemovingListUsingOutdentIconInInlineToolbar()


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
