<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_UnorderedListUnitTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test that unordered list is added and removed for the paragraph when you click inside a word.
     *
     * @return void
     */
    public function testListCreationFromClickingInText()
    {
        $this->click($this->findKeyword(1));

        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<ul><li>%1% uuuuuu. %2%</li></ul><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testListCreationFromClickingInText()


    /**
     * Test the list shortcuts.
     *
     * @return void
     */
    public function testListShortcuts()
    {
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');

        $this->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, NULL, TRUE);
        sleep(1);
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        sleep(1);
        $this->keyDown('Key.TAB');
        $this->type('Item 1');
        $this->assertIconStatusesCorrect('active', TRUE, NULL, TRUE);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><ul><li>Item 1</li></ul><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testListShortcuts()


    /**
     * Test that you can create a list whne entering text.
     *
     * @return void
     */
    public function testCreatingAList()
    {
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');

        $this->type('Test list:');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('Item 1');
        $this->assertIconStatusesCorrect('active', TRUE, NULL, TRUE);
        sleep(1);
        $this->keyDown('Key.ENTER');
        $this->type('Item 2');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>Test list:</p><ul><li>Item 1</li><li>Item 2</li></ul><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testCreatingAList()


    /**
     * Test that you can create a list whne entering text.
     *
     * @return void
     */
    public function testCreatingAListWithASubList()
    {
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');

        $this->type('Test list:');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('Item 1');
        $this->assertIconStatusesCorrect('active', TRUE, NULL, TRUE);
        sleep(1);
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('Item 2');
        $this->assertIconStatusesCorrect('active', TRUE, NULL, TRUE);
        sleep(1);
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->type('Item 3');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>Test list:</p><ul><li>Item 1<ul><li>Item 2</li></ul></li><li>Item 3</li></ul><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testCreatingAListWithASubList()


    /**
     * Test that unordered list is added and removed for the paragraph when you only selected one word.
     *
     * @return void
     */
    public function testListCreationFromTextSelection()
    {
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<ul><li>%1% uuuuuu. %2%</li></ul><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('listUL', 'active');
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testListCreationFromTextSelection()


    /**
     * Test that unordered list is added and removed when select a paragraph.
     *
     * @return void
     */
    public function testListCreationFromParaSelection()
    {
        $this->selectKeyword(1, 2);

        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<ul><li>%1% uuuuuu. %2%</li></ul><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testListCreationFromParaSelection()


    /**
     * Test that outdent works for text selection.
     *
     * @return void
     */
    public function testOutdentTextSelection()
    {
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<ul><li>%1% uuuuuu. %2%</li></ul><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');

        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testOutdentTextSelection()


    /**
     * Test that outdent icon in enabled when selecting different text in a list item.
     *
     * @return void
     */
    public function testOutdentIconIsEnabled()
    {
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('listUL');

        // Outdent icon is enabled when you click inside a list item.
        $this->click($this->findKeyword(1));
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        // Outdent icon is enabled when you select a word in a list item.
        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        // Outdent icon is enabled when you select a list item.
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        // Outdent icon is enabled when you select the list.
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

    }//end testOutdentIconIsEnabled()


    /**
     * Test that outdent works for the first item in the list using the keyboard shortcut.
     *
     * @return void
     */
    public function testOutdentFirstItemSelectionShortcut()
    {
        $this->selectKeyword(1, 3);

        $this->clickTopToolbarButton('listUL');
        sleep(1);
        $this->assertHTMLMatch('<ul><li>%1% uuuuuu. %2%</li><li>cPOc ccccc dddd. %3%</li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

        $this->selectKeyword(1);
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><ul><li>cPOc ccccc dddd. %3%</li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testOutdentFirstItemSelectionShortcut()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testOutdentLastItemSelectionShortcut()
    {
        $this->selectKeyword(1, 3);

        $this->clickTopToolbarButton('listUL');
        sleep(1);
        $this->assertHTMLMatch('<ul><li>%1% uuuuuu. %2%</li><li>cPOc ccccc dddd. %3%</li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

        $this->selectKeyword(3);
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<ul><li>%1% uuuuuu. %2%</li></ul><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testOutdentLastItemSelectionShortcut()


    /**
     * Test that you can select a few items in the list and use the keyboard shortcuts to outdent and indent the items.
     *
     * @return void
     */
    public function testOutdentAndIndentListItemsUsingKeyboardShortcuts()
    {
        $this->selectKeyword(4, 7);
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><p>aaa %4% ccccc</p><p>%5% %6% templates</p><p>Audit %7% %8%</p><ul><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

        $this->selectKeyword(4, 7);
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testOutdentAndIndentListItemsUsingKeyboardShortcuts()


    /**
     * Test that you can indent and outdent mulitple items multiple time.
     *
     * @return void
     */
    public function testOutdentAndIndentListItemsMultipleTimes()
    {
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><p>aaa %1% ccccc</p><p>4 oNo templates</p><p>Audit %2% content</p>');

        $this->selectKeyword(1, 2);
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li><li>aaa %1% ccccc</li><li>4 oNo templates</li><li>Audit %2% content</li></ul>');

        $this->selectKeyword(1, 2);
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><p>aaa %1% ccccc</p><p>4 oNo templates</p><p>Audit %2% content</p>');

        $this->selectKeyword(1, 2);
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li><li>aaa %1% ccccc</li><li>4 oNo templates</li><li>Audit %2% content</li></ul>');

    }//end testOutdentAndIndentListItemsMultipleTimes()


    /**
     * Test that outdent works for the third list item and then its added back to the list when you click the indent icon.
     *
     * @return void
     */
    public function testOutdentThirdListItemAndAddBackToList()
    {
        $textLoc = $this->findKeyword(7);
        $this->click($textLoc);

        $this->clickTopToolbarButton('listOutdent');
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li></ul><p>Audit %7% %8%</p><ul><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testOutdentThirdListItemAndAddBackToList()


    /**
     * Test that you cannot indent the first item in the list.
     *
     * @return void
     */
    public function testCannotIndentFirstItemInList()
    {
        $this->selectKeyword(1, 3);

        $this->clickInlineToolbarButton('listUL');
        sleep(1);
        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->selectKeyword(1);
        // Make sure multiple tabs dont cause issues.
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ul><li>%1% uuuuuu. %2%</li><li>cPOc ccccc dddd. %3%</li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testCannotIndentFirstItemInList()


    /**
     * Test that indent works for last item in the list using the shortcut.
     *
     * @return void
     */
    public function testIndentLastItemInTheListUsingShortcut()
    {
        $this->selectKeyword(1, 3);

        $this->clickInlineToolbarButton('listUL');
        sleep(1);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        sleep(1);
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ul><li>%1% uuuuuu. %2%<ul><li>cPOc ccccc dddd. %3%</li></ul></li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');


    }//end testIndentLastItemInTheListUsingShortcut()


    /**
     * Test that indent works for last item in the list using the indent icon.
     *
     * @return void
     */
    public function testIndentLastItemInTheListUsingIndentIcon()
    {
        $this->selectKeyword(1, 3);

        $this->clickInlineToolbarButton('listUL');
        sleep(1);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickInlineToolbarButton('listIndent');

        $this->assertHTMLMatch('<ul><li>%1% uuuuuu. %2%<ul><li>cPOc ccccc dddd. %3%</li></ul></li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testIndentLastItemInTheListUsingIndentIcon()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testIndentOutdentLastItemSelectionShortcut()
    {
        $this->selectKeyword(1, 3);

        $this->clickInlineToolbarButton('listUL');
        sleep(1);
        $this->assertHTMLMatch('<ul><li>%1% uuuuuu. %2%</li><li>cPOc ccccc dddd. %3%</li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

        $this->selectKeyword(3);

        $this->keyDown('Key.TAB');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<ul><li>%1% uuuuuu. %2%</li><li>cPOc ccccc dddd. %3%</li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testIndentOutdentLastItemSelectionShortcut()


    /**
     * Test indent/outdent.
     *
     * @return void
     */
    public function testIndentOutdentItems()
    {
        $this->selectKeyword(6, 9);
        $this->keyDown('Key.TAB');

        sleep(1);
        $this->selectKeyword(8);
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc<ul><li>%5% %6% templates<ul><li>Audit %7% %8%</li></ul></li><li>Accessibility audit report</li><li>Recommendations %9% plan</li></ul></li><li>Squiz Matrix guide</li></ul>');

        sleep(1);
        $this->selectKeyword(5);
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates<ul><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li></ul></li><li>Squiz Matrix guide</li></ul>');

    }//end testIndentOutdentItems()


    /**
     * Test indent keeps selection and styles can be applied to multiple list elements.
     *
     * @return void
     */
    public function testIndentSelectionKeptStyleApplied()
    {
        $this->selectKeyword(6, 9);
        $this->keyDown('Key.TAB');
        sleep(1);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc<ul><li>%5% <strong>%6% templates</strong></li><li><strong>Audit %7% %8%</strong></li><li><strong>Accessibility audit report</strong></li><li><strong>Recommendations %9%</strong> plan</li></ul></li><li>Squiz Matrix guide</li></ul>');

        sleep(1);

        $this->selectKeyword(6, 9);
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testIndentSelectionKeptStyleApplied()


    /**
     * Test that when you click the unordered list icon for one item in the list, that item is removed
     *
     * @return void
     */
    public function testRemoveAllListItemsWhenClickUnorderedListIcon()
    {
        $this->selectKeyword(7);

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><p>aaa %4% ccccc</p><p>%5% %6% templates</p><p>Audit %7% %8%</p><p>Accessibility audit report</p><p>Recommendations %9% plan</p><p>Squiz Matrix guide</p>');

    }//end testRemoveOneListItemWhenClickUnorderedListIcon()


    /**
     * Test that you can use the unordered list icon to remove an item and then add it back to the list.
     *
     * @return void
     */
    public function testRemoveAndCreatingNewListUsingUnorderedListIcon()
    {
        $this->selectKeyword(7);

        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li></ul><p>Audit %7% %8%</p><ul><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li></ul><ul><li>Audit %7% %8%</li></ul><ul><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testRemoveAndCreatingNewListUsingUnorderedListIcon()


    /**
     * Test remove list items.
     *
     * @return void
     */
    public function testRemoveListItems()
    {
        $this->selectKeyword(5, 8);
        $this->keyDown('Key.BACKSPACE');
        sleep(1);

        // Check that the inline toolbar no longer appears  on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }

        $this->assertFalse($inlineToolbarFound, 'The inline toolbar was found');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testRemoveListItems()


    /**
     * Test remove list items and click undo.
     *
     * @return void
     */
    public function testRemoveListItemsAndClickUndo()
    {
        $this->selectKeyword(5, 8);
        $this->keyDown('Key.BACKSPACE');
        sleep(1);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testRemoveListItemsAndClickUndo()


    /**
     * Test keyboard navigation.
     *
     * @return void
     */
    public function testListKeyboardNav()
    {
        $this->click($this->findKeyword(6));

        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.DOWN');

        $this->keyDown('Key.TAB');

        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');

        $this->keyDown('Key.UP');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');

        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');

        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc<ul><li>%5% %6% templates</li></ul></li><li>Audit %7% %8%<ul><li>Accessibility audit report<ul><li>Recommendations %9% plan</li></ul></li><li>Squiz Matrix guide</li></ul></li></ul>');

    }//end testListKeyboardNav()


    /**
     * Test that the list is turned into separate paragraphs when you select all items and press the outdent icon.
     *
     * @return void
     */
    public function testListToParaUsingOutdentIcon()
    {
        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><p>aaa %4% ccccc</p><p>%5% %6% templates</p><p>Audit %7% %8%</p><p>Accessibility audit report</p><p>Recommendations %9% plan</p><p>Squiz Matrix guide</p>');

    }//end testListToParaUsingOutdentIcon()


    /**
     * Test that the list is turned into separate paragraphs when you select all items and press the unordered list icon.
     *
     * @return void
     */
    public function testListToParaUsingUnorderedListIcon()
    {
        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><p>aaa %4% ccccc</p><p>%5% %6% templates</p><p>Audit %7% %8%</p><p>Accessibility audit report</p><p>Recommendations %9% plan</p><p>Squiz Matrix guide</p>');

    }//end testListToParaUsingOutdentIcon()


    /**
     * Test that new items can be added to the list.
     *
     * @return void
     */
    public function testNewItemCreationForUnorderedLists()
    {
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('Test');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('Test 2');
        $this->keyDown('Key.ENTER');
        $this->type('Test 3');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('Test 4');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->type('Test 5');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Test<ul><li>Test 2</li><li>Test 3<ul><li>Test 4</li></ul></li></ul></li><li>Test 5</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testNewItemCreation()


    /**
     * Test that an item can be removed from the list.
     *
     * @return void
     */
    public function testRemoveItemFromList()
    {
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);

        // Remove whole item.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');
        sleep(1);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');


    }//end testRemoveItemFromList()


    /**
     * Test that a sub list with single item is removed from the main list.
     *
     * @return void
     */
    public function testRemoveSubListFromList()
    {
        $this->selectKeyword(5);
        sleep(1);
        $this->keyDown('Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc<ul><li>%5% %6% templates</li></ul></li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

        $this->selectInlineToolbarLineageItem(3);
        sleep(2);

        // Remove whole item .
        $this->keyDown('Key.BACKSPACE');
        sleep(1);

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testRemoveSubListFromList()


    /**
     * Test that a sub list with single item is removed from the main list.
     *
     * @return void
     */
    public function testRemoveSubListItemFromList2()
    {
        $this->selectKeyword(5);
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');

        sleep(1);
        $this->selectKeyword(7);

        $this->selectInlineToolbarLineageItem(3);
        sleep(1);

        // Remove whole item.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');
        sleep(1);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc<ul><li>%5% %6% templates</li></ul></li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testRemoveSubListItemFromList()


    /**
     * Test remove whole list.
     *
     * @return void
     */
    public function testRemoveWholeList()
    {
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);

        // Remove everything except the last list item.
        $this->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p>');

    }//end testRemoveWholeList()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListTypeFromUnOrderedToOrderedList()
    {
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickTopToolbarButton('listOL');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testConvertListTypeFromUnOrderedToOrderedList()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListFromUnorderedToOrderedWithItemSelection()
    {
        $this->selectKeyword(7);
        $this->clickTopToolbarButton('listOL');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');


    }//end testConvertListFromUnorderedToOrderedWithItemSelection()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListFromUnorderedToOrderedWithSubList()
    {
        $this->moveToKeyword(5, 'right');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');

        sleep(1);
        $this->selectKeyword(7);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('listOL');

        sleep(1);
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc<ul><li>%5% %6% templates</li><li>Audit %7% %8%</li></ul></li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');


    }//end testConvertListFromUnorderedToOrderedWithSubList()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertSubListType()
    {
        $this->moveToKeyword(7, 'right');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.UP');
        $this->keyDown('Key.TAB');
        sleep(1);

        $this->selectKeyword(7);
        $this->selectInlineToolbarLineageItem(2);

        sleep(1);
        $this->clickTopToolbarButton('listOL');

        sleep(1);
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc<ol><li>%5% %6% templates</li><li>Audit %7% %8%</li></ol></li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testConvertSubListType()


    /**
     * Test that after you remove all items from the list, the undo icon is active and that when you click it the list is replaced.
     *
     * @return void
     */
    public function testClickUndoAfterRemovingList()
    {
        $this->click($this->findKeyword(5));
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><p>aaa %4% ccccc</p><p>%5% %6% templates</p><p>Audit %7% %8%</p><p>Accessibility audit report</p><p>Recommendations %9% plan</p><p>Squiz Matrix guide</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testHeadingIconNotAvailableForList()


    /**
     * Test copy and paste for part of a list.
     *
     * @return void
     */
    public function testCopyAndPastePartOfList()
    {
        $this->selectKeyword(5, 8);
        $this->keyDown('Key.CMD + c');

        $this->moveToKeyword(3, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        sleep(1);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><ul><li>%5% %6% templates</li><li>Audit %7% %8%</li></ul><p></p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testCopyAndPastePartOfList()


    /**
     * Test copy and paste a list.
     *
     * @return void
     */
    public function testCopyAndPasteForAList2()
    {
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + c');

        $this->moveToKeyword(3, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        sleep(1);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul><p>&nbsp;</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testCopyAndPasteForAList()


    /**
     * Test that a paragraph is created after a list and before a div.
     *
     * @return void
     */
    public function testCreatingParagraphAfterListBeforeADiv()
    {
        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('New paragraph');

        // Press the down arrow to make sure IE doesn't throw an exception
        $this->keyDown('Key.DOWN');

        sleep(1);
        $this->assertHTMLMatch('<p>ajhsd sjsjwi hhhh:</p><ul><li>Recommendations action plan</li><li>Squiz Matrix guide %1%</li></ul><p>New paragraph</p><div>Test div</div>');

    }//end testCreatingParagraphAfterListBeforeADiv()


    /**
     * Test that a paragraph is created after a list and before a Pre.
     *
     * @return void
     */
    public function testCreatingParagraphAfterListBeforeAPre()
    {
        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('New paragraph');

        // Press the down arrow to make sure IE doesn't throw an exception
        $this->keyDown('Key.DOWN');

        sleep(1);
        $this->assertHTMLMatch('<p>ajhsd sjsjwi hhhh:</p><ul><li>Recommendations action plan</li><li>Squiz Matrix guide %1%</li></ul><p>New paragraph</p><pre>Test pre</pre>');

    }//end testCreatingParagraphAfterListBeforeAPre()


    /**
     * Test that a paragraph is created after a list and before a quote.
     *
     * @return void
     */
    public function testCreatingParagraphAfterListBeforeAQuote()
    {
        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('New paragraph');

        // Press the down arrow to make sure IE doesn't throw an exception
        $this->keyDown('Key.DOWN');

        sleep(1);
        $this->assertHTMLMatch('<p>ajhsd sjsjwi hhhh:</p><ul><li>Recommendations action plan</li><li>Squiz Matrix guide %1%</li></ul><p>New paragraph</p><blockquote>Test blockquote</blockquote>');

    }//end testCreatingParagraphAfterListBeforeAQuote()


    /**
     * Test that a paragraph is created after a list and before a paragraph.
     *
     * @return void
     */
    public function testCreatingParagraphAfterListBeforeAParagraph()
    {
        $this->moveToKeyword(1, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('New paragraph');

        // Press the down arrow to make sure IE doesn't throw an exception
        $this->keyDown('Key.DOWN');

        sleep(1);
        $this->assertHTMLMatch('<p>ajhsd sjsjwi hhhh:</p><ul><li>Recommendations action plan</li><li>Squiz Matrix guide %1%</li></ul><p>New paragraph</p><p>Test para</p>');

    }//end testCreatingParagraphAfterListBeforeAParagraph()


    /**
     * Tests that shift+tab in a non list item does nothing.
     *
     * @return void
     */
    public function testShiftTagInNonListItem()
    {
        $this->click($this->findKeyword(4));
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><p>aaa %4% ccccc</p><ul><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testShiftTagInNonListItem()


}//end class

?>
