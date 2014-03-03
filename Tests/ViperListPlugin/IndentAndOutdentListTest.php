<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_IndentAndOutdentListTest extends AbstractViperListPluginUnitTest
{

    /**
     * Test that when you click inside a list item, the outdent and indent icon works.
     *
     * @return void
     */
    public function testOutdentAndIndentListItem()
    {
        //Test unordered list
        $this->moveToKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test unordered list
        $this->moveToKeyword(5);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li></ol><p>second item %5%</p><ol><li>third %6% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testOutdentAndIndentListItem()


	/**
     * Test that when you select a word in a list item, the outdent and indent icon works.
     *
     * @return void
     */
    public function testOutdentAndIndentWithTextSelection()
    {
        //Test unordered list
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test unordered list
        $this->selectKeyword(5);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li></ol><p>second item %5%</p><ol><li>third %6% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testOutdentAndIndentWithTextSelection()


    /**
     * Test that when you select a list item, the outdent and indent icon works.
     *
     * @return void
     */
    public function testOutdentAndIndentWhenSelectingListItem()
    {
        //Test unordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test unordered list
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li></ol><p>second item %5%</p><ol><li>third %6% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testOutdentAndIndentWhenSelectingListItem()


    /**
     * Test that when you select a list, the outdent and indent icon works.
     *
     * @return void
     */
    public function testOutdentAndIndentWhenSelectingList()
    {
        //Test unordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><p>second item %2%</p><p>third %3% item</p><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test unordered list
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><p>%4% first item</p><p>second item %5%</p><p>third %6% item</p>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ul><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ul>');

    }//end testOutdentAndIndentWhenSelectingList()


    /**
     * Test that when you click inside a list item, the keyboard shortcuts work to outdent and indent the item.
     *
     * @return void
     */
    public function testOutdentAndIndentListItemUsingKeyboardShorts()
    {
        //Test unordered list
        $this->moveToKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test unordered list
        $this->moveToKeyword(5);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li></ol><p>second item %5%</p><ol><li>third %6% item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testOutdentAndIndentListItemUsingKeyboardShorts()


    /**
     * Test that when you select a word in a list item, the keyboard shortcuts work to outdent and indent the item.
     *
     * @return void
     */
    public function testOutdentAndIndentWithTextSelectionUsingKeyboardShortcuts()
    {
        //Test unordered list
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test unordered list
        $this->selectKeyword(5);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li></ol><p>second item %5%</p><ol><li>third %6% item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testOutdentAndIndentWithTextSelectionUsingKeyboardShortcuts()


    /**
     * Test that when you select a list item, the keyboard shortcuts work to outdent and indent the item.
     *
     * @return void
     */
    public function testOutdentAndIndentWhenSelectingListItemUsingKeyboardShortcuts()
    {
        //Test unordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test unordered list
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li></ol><p>second item %5%</p><ol><li>third %6% item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testOutdentAndIndentWhenSelectingListItemUsingKeyboardShortcuts()


    /**
     * Test that when you select a list, the keyboard shortcuts work to outdent and indent icon works.
     *
     * @return void
     */
    public function testOutdentAndIndentWhenSelectingListUsingKeyboardShortcuts()
    {
        //Test unordered list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><p>second item %2%</p><p>third %3% item</p><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test unordered list
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><p>%4% first item</p><p>second item %5%</p><p>third %6% item</p>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ul><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ul>');

    }//end testOutdentAndIndentWhenSelectingListUsingKeyboardShortcuts()


    /**
     * Test that outdent and indent works for the first item in the list using the keyboard shortcut.
     *
     * @return void
     */
    public function testOutdentAndIndentFirstItemUsingKeyboardShortcut()
    {
        //Test unordered list
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><ul><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test ordered list
        $this->selectKeyword(4);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><p>%4% first item</p><ol><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testOutdentAndIndentFirstItemUsingKeyboardShortcut()


    /**
     * Test that outdent and indent works for the last item in the list using the keyboard shortcut.
     *
     * @return void
     */
    public function testOutdentAndIndentLastItemUsingKeyboardShortcut()
    {
        //Test unordered list
        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li></ul><p>third %3% item</p><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test ordered list
        $this->selectKeyword(6);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li></ol><p>third %6% item</p>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testOutdentAndIndentLastItemUsingKeyboardShortcut()


    /**
     * Test that you can indent and outdent mulitple items multiple time.
     *
     * @return void
     */
    public function testOutdentAndIndentListItemsMultipleTimes()
    {
        //Test unordered list
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><p>second item %2%</p><ul><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><p>second item %2%</p><ul><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test ordered list
        $this->selectKeyword(4, 5);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><p>%4% first item</p><p>second item %5%</p><ol><li>third %6% item</li></ol>');
        $this->selectKeyword(4, 5);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->selectKeyword(4, 5);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><p>%4% first item</p><p>second item %5%</p><ol><li>third %6% item</li></ol>');
        $this->selectKeyword(4, 5);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testOutdentAndIndentListItemsMultipleTimes()


    /**
     * Test that you cannot indent the first item in the list.
     *
     * @return void
     */
    public function testCannotIndentFirstItemInList()
    {
        //Test unordered list
        $this->moveToKeyword(1);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        // Make sure multiple tabs dont cause issues.
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test unordered list
        $this->moveToKeyword(4);
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        // Make sure multiple tabs dont cause issues.
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testCannotIndentFirstItemInList()


    /**
     * Test that indent creates a sub list and outdent adds it back to the master list for the last item in the list.
     *
     * @return void
     */
    public function testIndentAndOutdentLastItemInTheListUsingKeyboardShortcut()
    {
        //Test unordered list
        $this->moveToKeyword(3);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%<ul><li>third %3% item</li></ul></li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test ordered list
        $this->moveToKeyword(6);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%<ol><li>third %6% item</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testIndentLastItemInTheListUsingKeyboardShortcut()


    /**
     * Test that indent works for last item in the list using the indent icon.
     *
     * @return void
     */
    public function testIndentLastItemInTheListUsingIndentIcon()
    {
        //Test unordered list
        $this->moveToKeyword(3);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%<ul><li>third %3% item</li></ul></li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test ordered list
        $this->moveToKeyword(6);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%<ol><li>third %6% item</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testIndentLastItemInTheListUsingIndentIcon()


    /**
     * Test indent and outdent keeps text selection and styles can be applied to multiple list elements.
     *
     * @return void
     */
    public function testIndentAndOutdentKeepsSelectionAndStylesApplied()
    {
        //Test unordered list
        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item<ul><li>second item <strong>%2%</strong></li><li><strong>third %3%</strong> item</li></ul></li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test ordered list
        $this->selectKeyword(5, 6);
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item<ol><li>second item <strong>%5%</strong></li><li><strong>third %6%</strong> item</li></ol></li></ol>');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testIndentAndOutdentKeepsSelectionAndStylesApplied()


    /**
     * Tests that shift+tab in a non list item does nothing.
     *
     * @return void
     */
    public function testShiftTagInNonListItem()
    {
        //Test unordered list
        $this->moveToKeyword(1);
        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        //Test ordered list
        $this->moveToKeyword(4);
        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testShiftTagInNonListItem()


    /**
     * Test indenting and outdenting items in an unordered list using keyboard navigation only.
     *
     * @return void
     */
    public function testListKeyboardNavForUnorderedList()
    {
        $this->moveToKeyword(2);

        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item<ul><li>second item %2%</li><li>third %3% item</li></ul></li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%<ul><li>third %3% item</li></ul></li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item<ul><li>second item %2%<ul><li>third %3% item</li></ul></li></ul></li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%<ul><li>third %3% item</li></ul></li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%</li><li>third %6% item</li></ol>');

    }//end testListKeyboardNavForUnorderedList()


    /**
     * Test indenting and outdenting items in an ordered list using keyboard navigation only.
     *
     * @return void
     */
    public function testListKeyboardNavForOrderedList()
    {
        $this->moveToKeyword(5);

        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item<ol><li>second item %5%</li><li>third %6% item</li></ol></li></ol>');

        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%<ol><li>third %6% item</li></ol></li></ol>');

        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item<ol><li>second item %5%<ol><li>third %6% item</li></ol></li></ol></li></ol>');

        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul><p>Ordered List:</p><ol><li>%4% first item</li><li>second item %5%<ol><li>third %6% item</li></ol></li></ol>');

    }//end testListKeyboardNavForOrderedList()


}//end class

?>