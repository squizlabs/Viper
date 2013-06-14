<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_OrderedListUnitTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test that you can create a list when entering text.
     *
     * @return void
     */
    public function testCreatingAList()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');

        $this->type('Test list:');
        $this->keyDown('Key.ENTER');
        sleep(1);
        $this->clickTopToolbarButton('listOL');
        $this->type('Item 1');
        $this->assertIconStatusesCorrect(TRUE, 'active', NULL, TRUE);
        sleep(1);
        $this->keyDown('Key.ENTER');
        $this->type('Item 2');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>Test list:</p><ol><li>Item 1</li><li>Item 2</li></ol><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

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
        $this->clickTopToolbarButton('listOL');
        $this->type('Item 1');
        $this->assertIconStatusesCorrect(TRUE, 'active', NULL, TRUE);
        sleep(1);
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('Item 2');
        $this->assertIconStatusesCorrect(TRUE, 'active', NULL, TRUE);
        sleep(1);
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->type('Item 3');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>Test list:</p><ol><li>Item 1<ol><li>Item 2</li></ol></li><li>Item 3</li></ol><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testCreatingAListWithASubList()


    /**
     * Test that you can create a list after starting with a new paragraph.
     *
     * @return void
     */
    public function testCreatingAListFromANewParagraph()
    {
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');

        $this->type('New list item');
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', NULL, TRUE);
        $this->keyDown('Key.ENTER');
        $this->type('Second list item');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><ol><li>New list item</li><li>Second list item</li></ol><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testCreatingAListFromANewParagraph()


    /**
     * Test that unordered list is added and removed for the paragraph when you click inside a word.
     *
     * @return void
     */
    public function testListCreationFromClickingInText()
    {
        $this->click($this->findKeyword(2));

        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%</li></ol><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->clickTopToolbarButton('listOL', 'active');
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListCreationFromClickingInText()


    /**
     * Test that ordered list is added and removed when toolbar icon is clicked.
     *
     * @return void
     */
    public function testListCreationFromTextSelection()
    {
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%</li></ol><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('listOL', 'active');
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListCreationFromTextSelection()


    /**
     * Test that unordered list is added and removed when toolbar icon is clicked.
     *
     * @return void
     */
    public function testListCreationFromParaSelection()
    {
        $this->selectKeyword(1, 3);

        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%</li><li>cPOc ccccc dddd. %3%</li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListCreationFromParaSelection()


    /**
     * Test that outdent works for text selection.
     *
     * @return void
     */
    public function testOutdentTextSelection()
    {
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%</li></ol><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');

        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testOutdentTextSelection()


    /**
     * Test that outdent icon in enabled when selecting different text in a list item.
     *
     * @return void
     */
    public function testOutdentIconIsEnabled()
    {
        $this->selectKeyword(1, 3);
        $this->clickTopToolbarButton('listOL');

        // Outdent icon is enabled when you click inside a list item.
        $this->click($this->findKeyword(6));
        $this->click($this->findKeyword(2));
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        // Outdent icon is enabled when you select a word in a list item.
        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Outdent icon is enabled when you select the list.
        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

    }//end testOutdentIconIsEnabled()


    /**
     * Test that you can select a few items in the list and use the keyboard shortcuts to outdent and indent the items.
     *
     * @return void
     */
    public function testOutdentAndIndentListItemsUsingKeyboardShortcuts()
    {
        $this->selectKeyword(4, 8);
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><p>aaa %4% ccccc</p><p>%5% %6% templates</p><p>Audit %7% %8%</p><ol><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testOutdentAndIndentListItemsUsingKeyboardShortcuts()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testOutdentFirstItemSelectionShortcut()
    {
        $this->selectKeyword(1, 3);

        $this->clickTopToolbarButton('listOL');
        sleep(1);
        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%</li><li>cPOc ccccc dddd. %3%</li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->selectKeyword(2);
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><ol><li>cPOc ccccc dddd. %3%</li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testOutdentFirstItemSelectionShortcut()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testOutdentLastItemSelectionShortcut2()
    {
        $this->selectKeyword(1, 3);

        $this->clickInlineToolbarButton('listOL');
        sleep(1);
        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%</li><li>cPOc ccccc dddd. %3%</li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->selectKeyword(3);
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%</li></ol><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testOutdentLastItemSelectionShortcut()


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

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li></ol><p>Audit %7% %8%</p><ol><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testOutdentThirdListItemAndAddBackToList()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testIndentFirstItemSelectionShortcut()
    {
        $this->selectKeyword(1, 3);

        $this->clickTopToolbarButton('listOL');
        sleep(1);

        $this->selectKeyword(3);

        // Make sure multiple tabs dont cause issues.
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%<ol><li>cPOc ccccc dddd. %3%</li></ol></li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testIndentFirstItemSelectionShortcut()


    /**
     * Test that indent works for last item in the list using the shortcut.
     *
     * @return void
     */
    public function testIndentLastItemInTheListUsingShortcut()
    {
        $this->selectKeyword(1, 3);

        $this->clickInlineToolbarButton('listOL');
        sleep(1);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        sleep(1);
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%<ol><li>cPOc ccccc dddd. %3%</li></ol></li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');


    }//end testIndentLastItemInTheListUsingShortcut()


    /**
     * Test that indent works for last item in the list using the indent icon.
     *
     * @return void
     */
    public function testIndentLastItemInTheListUsingIndentIcon()
    {
        $this->selectKeyword(1, 3);

        $this->clickInlineToolbarButton('listOL');
        sleep(1);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickInlineToolbarButton('listIndent');

        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%<ol><li>cPOc ccccc dddd. %3%</li></ol></li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testIndentLastItemInTheListUsingIndentIcon()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testIndentOutdentLastItemSelectionShortcut()
    {
        $this->selectKeyword(1, 3);

        $this->clickInlineToolbarButton('listOL');
        sleep(1);
        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%</li><li>cPOc ccccc dddd. %3%</li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->selectKeyword(5);

        $this->keyDown('Key.TAB');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%</li><li>cPOc ccccc dddd. %3%</li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testIndentOutdentLastItemSelectionShortcut()


    /**
     * Test that you can indent and outdent mulitple items multiple time.
     *
     * @return void
     */
    public function testOutdentAndIndentListItemsMultipleTimes()
    {
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<ol><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><p>aaa %1% ccccc</p><p>4 oNo templates</p><p>Audit %2% content</p>');

        $this->selectKeyword(1, 2);
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ol><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li><li>aaa %1% ccccc</li><li>4 oNo templates</li><li>Audit %2% content</li></ol>');

        $this->selectKeyword(1, 2);
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<ol><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><p>aaa %1% ccccc</p><p>4 oNo templates</p><p>Audit %2% content</p>');

        $this->selectKeyword(1, 2);
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ol><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li><li>aaa %1% ccccc</li><li>4 oNo templates</li><li>Audit %2% content</li></ol>');

    }//end testOutdentAndIndentListItemsMultipleTimes()


    /**
     * Test indent/outdent.
     *
     * @return void
     */
    public function testIndentOutdentItems()
    {
        $this->selectKeyword(5, 9);
        $this->keyDown('Key.TAB');

        $this->selectKeyword(9);
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc<ol><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report<ol><li>Recommendations %9% plan</li></ol></li></ol></li><li>Squiz Matrix guide</li></ol>');

        $this->selectKeyword(9);
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc<ol><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li></ol></li><li>Squiz Matrix guide</li></ol>');

        $this->selectKeyword(7);
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc<ol><li>%5% %6% templates</li></ol></li><li>Audit %7% %8%<ol><li>Accessibility audit report</li><li>Recommendations %9% plan</li></ol></li><li>Squiz Matrix guide</li></ol>');


    }//end testIndentOutdentItems()


    /**
     * Test indent keeps selection and styles can be applied to multiple list elements.
     *
     * @return void
     */
    public function testIndentSelectionKeptStyleApplied()
    {
        $this->selectKeyword(5, 9);
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc<ol><li><strong>%5% %6% templates</strong></li><li><strong>Audit %7% %8%</strong></li><li><strong>Accessibility audit report</strong></li><li><strong>Recommendations %9%</strong> plan</li></ol></li><li>Squiz Matrix guide</li></ol>');

        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testIndentSelectionKeptStyleApplied()


    /**
     * Test that when you click the ordered list icon for one item in the list, the whole list is removed
     *
     * @return void
     */
    public function testRemoveAllListItemsWhenClickOrderedListIcon()
    {
        $this->selectKeyword(7);

        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><p>aaa %4% ccccc</p><p>%5% %6% templates</p><p>Audit %7% %8%</p><p>Accessibility audit report</p><p>Recommendations %9% plan</p><p>Squiz Matrix guide</p>');

    }//end testRemoveAllListItemsWhenClickOrderedListIcon()


    /**
     * Test that you can use the ordered list icon to remove an item and then create a new list.
     *
     * @return void
     */
    public function testRemoveAndCreatingNewListItemUsingOrderedListIcon()
    {
        $this->selectKeyword(7);

        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><p>aaa %4% ccccc</p><p>%5% %6% templates</p><p>Audit %7% %8%</p><p>Accessibility audit report</p><p>Recommendations %9% plan</p><p>Squiz Matrix guide</p>');

        $this->selectKeyword(7);
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><p>aaa %4% ccccc</p><p>%5% %6% templates</p><ol><li>Audit %7% %8%</li></ol><p>Accessibility audit report</p><p>Recommendations %9% plan</p><p>Squiz Matrix guide</p>');

    }//end testRemoveOneListItemWhenClickUnorderedListIcon()


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
        } catch  (Exception $e) {
            $inlineToolbarFound = false;
        }

        $this->assertFalse($inlineToolbarFound, 'The inline toolbar was found');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

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

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testRemoveListItemsAndClickUndo()


    /**
     * Test creat list and click undo.
     *
     * @return void
     */
    public function testCreateListItemsAndClickUndo()
    {
        $this->click($this->findKeyword(2));

        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%</li></ol><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<ol><li>%1% uuuuuu. %2%</li></ol><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testCreateListItemsAndClickUndo()


    /**
     * Test keyboard navigation.
     *
     * @return void
     */
    public function testListKeyboardNav()
    {
        $this->moveToKeyword(2, 'right');
        usleep(50000);
        $this->keyDown('Key.TAB');
        usleep(50000);
        $this->keyDown('Key.DOWN');
        usleep(50000);

        $this->keyDown('Key.TAB');
        usleep(50000);

        $this->keyDown('Key.DOWN');
        usleep(50000);
        $this->keyDown('Key.TAB');
        usleep(50000);

        $this->keyDown('Key.UP');
        usleep(50000);
        $this->keyDown('Key.SHIFT + Key.TAB');
        usleep(50000);
        $this->keyDown('Key.DOWN');
        usleep(50000);
        $this->keyDown('Key.TAB');
        usleep(50000);
        $this->keyDown('Key.TAB');
        usleep(50000);

        $this->keyDown('Key.DOWN');
        usleep(50000);
        $this->keyDown('Key.TAB');
        usleep(50000);
        $this->keyDown('Key.TAB');
        usleep(50000);

        $this->keyDown('Key.DOWN');
        usleep(50000);
        $this->keyDown('Key.TAB');
        usleep(50000);

        $this->assertHTMLMatch('<ul><li>%1% uuuuuu. %2%</li></ul><p>cPOc ccccc dddd. %3%</p><ul><li>ajhsd sjsjwi hhhh:</li></ul><ol><li>aaa %4% ccccc<ol><li>%5% %6% templates</li></ol></li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');


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
     * Test that the list is turned into separate paragraphs when you select all items and press the ordered list icon.
     *
     * @return void
     */
    public function testListToParaUsingOrderedListIcon()
    {
        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><p>aaa %4% ccccc</p><p>%5% %6% templates</p><p>Audit %7% %8%</p><p>Accessibility audit report</p><p>Recommendations %9% plan</p><p>Squiz Matrix guide</p>');

    }//end testListToParaUsingOrderedListIcon()


    /**
     * Test that new items can be added to the list.
     *
     * @return void
     */
    public function testNewItemCreation()
    {
        $this->selectKeyword(6);
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

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Test<ol><li>Test 2</li><li>Test 3<ol><li>Test 4</li></ol></li></ol></li><li>Test 5</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testNewItemCreation()


    /**
     * Test that an item can be removed from the list.
     *
     * @return void
     */
    public function testRemoveItemFromList()
    {
        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);

        // Remove whole item.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');
        sleep(1);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testRemoveItemFromList()


    /**
     * Test that a sub list with single item is removed from the main list.
     *
     * @return void
     */
    public function testRemoveSubListFromList()
    {
        $this->selectKeyword(6);
        $this->keyDown('Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc<ol><li>%5% %6% templates</li></ol></li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

        $this->selectInlineToolbarLineageItem(3);
        sleep(1);

        // Remove whole item.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testRemoveSubListFromList()


    /**
     * Test that a sub list with single item is removed from the main list.
     *
     * @return void
     */
    public function testRemoveSubListItemFromList()
    {
        $this->selectKeyword(6);
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(7);

        $this->selectInlineToolbarLineageItem(3);
        sleep(1);

        // Remove whole item.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc<ol><li>%5% %6% templates</li></ol></li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testRemoveSubListItemFromList()


    /**
     * Test that a sub list with single item is removed from the main list.
     *
     * @return void
     */
    public function testRemoveSubListItemFromList2()
    {
        $this->selectKeyword(6);
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

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc<ol><li>%5% %6% templates</li></ol></li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testRemoveSubListItemFromList2()


    /**
     * Test remove whole list.
     *
     * @return void
     */
    public function testRemoveWholeList()
    {
        $this->selectKeyword(6);
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
    public function testConvertListTypeA()
    {
        $this->selectKeyword(7);
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickTopToolbarButton('listUL');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testConvertListType()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListTypeWithItemSelection()
    {
        $this->selectKeyword(7);
        $this->clickTopToolbarButton('listUL');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testConvertListTypeWithItemSelection()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListTypeWithSubList2()
    {
        $this->moveToKeyword(6, 'right');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');

        sleep(1);
        $this->selectKeyword(7);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('listUL');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa %4% ccccc<ol><li>%5% %6% templates</li><li>Audit %7% %8%</li></ol></li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ul>');

    }//end testConvertListTypeWithSubList2()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertSubListTypeA()
    {
        $this->moveToKeyword(7, 'right');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.UP');
        $this->keyDown('Key.TAB');
        sleep(1);

        $this->selectKeyword(7);
        $this->selectInlineToolbarLineageItem(2);

        sleep(1);
        $this->clickTopToolbarButton('listUL');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc<ul><li>%5% %6% templates</li><li>Audit %7% %8%</li></ul></li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testConvertSubListType()


    /**
     * Test that after you remove all items from the list, the undo icon is active and that when you click it the list is replaced.
     *
     * @return void
     */
    public function testClickUndoAfterRemovingList()
    {
        $this->click($this->findKeyword(6));
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><p>aaa %4% ccccc</p><p>%5% %6% templates</p><p>Audit %7% %8%</p><p>Accessibility audit report</p><p>Recommendations %9% plan</p><p>Squiz Matrix guide</p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testHeadingIconNotAvailableForList()


    /**
     * Test copy and paste for part of a list.
     *
     * @return void
     */
    public function testCopyAndPastePartOfList()
    {
        $this->selectKeyword(4, 8);
        $this->keyDown('Key.CMD + c');

        $this->moveToKeyword(3, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        sleep(1);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><ol><li>%4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li></ol><p></p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testCopyAndPastePartOfList()


    /**
     * Test copy and paste a list.
     *
     * @return void
     */
    public function testCopyAndPasteForAList2()
    {
        $this->selectKeyword(6);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + c');

        $this->moveToKeyword(3, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        sleep(1);

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol><p>&nbsp;</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

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
        sleep(1);
        $this->keyDown('Key.ENTER');
        sleep(1);
        $this->type('New paragraph');

        // Press the down arrow to make sure IE doesn't throw an exception
        $this->keyDown('Key.DOWN');

        sleep(1);
        $this->assertHTMLMatch('<p>ajhsd sjsjwi hhhh:</p><ol><li>Recommendations action plan</li><li>Squiz Matrix guide %1%</li></ol><p>New paragraph</p><div>Test div</div>');

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
        $this->assertHTMLMatch('<p>ajhsd sjsjwi hhhh:</p><ol><li>Recommendations action plan</li><li>Squiz Matrix guide %1%</li></ol><p>New paragraph</p><pre>Test pre</pre>');

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
        $this->assertHTMLMatch('<p>ajhsd sjsjwi hhhh:</p><ol><li>Recommendations action plan</li><li>Squiz Matrix guide %1%</li></ol><p>New paragraph</p><blockquote>Test blockquote</blockquote>');

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
        $this->assertHTMLMatch('<p>ajhsd sjsjwi hhhh:</p><ol><li>Recommendations action plan</li><li>Squiz Matrix guide %1%</li></ol><p>New paragraph</p><p>Test para</p>');

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

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><p>aaa %4% ccccc</p><ol><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testShiftTagInNonListItem()


    /**
     * Tests that pressing enter key at the end of a list item with sub list creats a new list item.
     *
     * @return void
     */
    public function testCreatingNewListItemBeforeASubList()
    {
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->clickTopToolbarButton('listOL');

        $this->type('abcde%10%');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('fghij');
        $this->moveToKeyword(10, 'right');
        $this->keyDown('Key.ENTER');
        $this->type('klmnop');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><ol><li>abcde%10%</li><li>klmnop<br /><ol><li>fghij</li></ol></li></ol><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testCreatingNewListItemBeforeASubList()


    /**
     * Tests that pressing enter key at the in an empty sub list item creates a new list item.
     *
     * @return void
     */
    public function testCreatingNewListItemFromEmptySubList()
    {
        $this->moveToKeyword(2, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->clickTopToolbarButton('listOL');
        $this->type('abcde');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.TAB');
        $this->type('fghij%10%');
        $this->keyDown('Key.ENTER');
        $this->type('klmnop');
        $this->moveToKeyword(10, 'right');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p>%1% uuuuuu. %2%</p><ol><li>abcde<ol><li>fghij%10%</li></ol></li><li><br /><ol><li>klmnop</li></ol></li></ol><p>cPOc ccccc dddd. %3%</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa %4% ccccc</li><li>%5% %6% templates</li><li>Audit %7% %8%</li><li>Accessibility audit report</li><li>Recommendations %9% plan</li><li>Squiz Matrix guide</li></ol>');

    }//end testCreatingNewListItemFromEmptySubList()


}//end class

?>
