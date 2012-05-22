<?php

require_once 'AbstractGeneralListUnitTest.php';

class Viper_Tests_ViperListPlugin_UnorderedListUnitTest extends AbstractGeneralListUnitTest
{


    /**
     * Test that unordered list is added and removed for the paragraph when you click inside a word.
     *
     * @return void
     */
    public function testListCreationFromClickingInText()
    {
        $this->click($this->find('VmumV'));

        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV</li></ul><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->click($this->find('VmumV'));
        $this->clickTopToolbarButton('listUL', 'active');
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListCreationFromClickingInText()


    /**
     * Test the list shortcuts.
     *
     * @return void
     */
    public function testListShortcuts()
    {
        $this->selectText('VmumV');
        $this->keyDown('Key.RIGHT');
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

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><ul><li>Item 1</li></ul><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testListShortcuts()


    /**
     * Test that you can create a list whne entering text.
     *
     * @return void
     */
    public function testCreatingAList()
    {
        $this->selectText('VmumV');
        $this->keyDown('Key.RIGHT');
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

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>Test list:</p><ul><li>Item 1</li><li>Item 2</li></ul><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testCreatingAList()


    /**
     * Test that you can create a list whne entering text.
     *
     * @return void
     */
    public function testCreatingAListWithASubList()
    {
        $this->selectText('VmumV');
        $this->keyDown('Key.RIGHT');
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

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>Test list:</p><ul><li>Item 1<ul><li>Item 2</li></ul></li><li>Item 3</li></ul><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testCreatingAListWithASubList()


    /**
     * Test that unordered list is added and removed for the paragraph when you only selected one word.
     *
     * @return void
     */
    public function testListCreationFromTextSelection()
    {
        $this->selectText('VmumV');

        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV</li></ul><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->selectText('VmumV');
        $this->clickTopToolbarButton('listUL', 'active');
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListCreationFromTextSelection()


    /**
     * Test that unordered list is added and removed when select a paragraph.
     *
     * @return void
     */
    public function testListCreationFromParaSelection()
    {
        $this->selectText('XabcX', 'VmumV');

        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV</li></ul><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListCreationFromParaSelection()


    /**
     * Test that outdent works for text selection.
     *
     * @return void
     */
    public function testOutdentTextSelection()
    {
        $this->selectText('VmumV');

        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV</li></ul><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->selectText('VmumV');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');

        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testOutdentTextSelection()


    /**
     * Test that outdent icon in enabled when selecting different text in a list item.
     *
     * @return void
     */
    public function testOutdentIconIsEnabled()
    {
        $this->selectText('XabcX', 'TicT');
        $this->clickTopToolbarButton('listUL');

        // Outdent icon is enabled when you click inside a list item.
        $this->click($this->find('VmumV'));
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        // Outdent icon is enabled when you select a word in a list item.
        $this->selectText('VmumV');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        // Outdent icon is enabled when you select a list item.
        $this->selectText('XabcX');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        // Outdent icon is enabled when you select the list.
        $this->selectText('XabcX');
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
        $this->selectText('XabcX', 'TicT');

        $this->clickTopToolbarButton('listUL');
        sleep(1);
        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->selectText('VmumV');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><ul><li>cPOc ccccc dddd. TicT</li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testOutdentFirstItemSelectionShortcut()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testOutdentLastItemSelectionShortcut()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickTopToolbarButton('listUL');
        sleep(1);
        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->selectText('TicT');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV</li></ul><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testOutdentLastItemSelectionShortcut()


    /**
     * Test that you can select a few items in the list and use the keyboard shortcuts to outdent and indent the items.
     *
     * @return void
     */
    public function testOutdentAndIndentListItemsUsingKeyboardShortcuts()
    {
        $this->selectText('bbbbb', 'XuT');
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><p>aaa bbbbb ccccc</p><p>4 oNo templates</p><p>Audit XuT content</p><ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->selectText('bbbbb', 'XuT');
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testOutdentAndIndentListItemsUsingKeyboardShortcuts()


    /**
     * Test that you can indent and outdent mulitple items multiple time.
     *
     * @return void
     */
    public function testOutdentAndIndentListItemsMultipleTimes()
    {
        $this->selectText('bbbbb', 'XuT');
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><p>aaa bbbbb ccccc</p><p>4 oNo templates</p><p>Audit XuT content</p>');

        $this->selectText('bbbbb', 'XuT');
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li></ul>');

        $this->selectText('bbbbb', 'XuT');
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><p>aaa bbbbb ccccc</p><p>4 oNo templates</p><p>Audit XuT content</p>');

        $this->selectText('bbbbb', 'XuT');
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li></ul>');

    }//end testOutdentAndIndentListItemsMultipleTimes()


    /**
     * Test that outdent works for the third list item and then its added back to the list when you click the indent icon.
     *
     * @return void
     */
    public function testOutdentThirdListItemAndAddBackToList()
    {
        $textLoc = $this->find('XuT');
        $this->click($textLoc);

        $this->clickTopToolbarButton('listOutdent');
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li></ul><p>Audit XuT content</p><ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testOutdentThirdListItemAndAddBackToList()


    /**
     * Test that you cannot indent the first item in the list.
     *
     * @return void
     */
    public function testCannotIndentFirstItemInList()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickInlineToolbarButton('listUL');
        sleep(1);
        $this->selectText('VmumV');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        $this->selectText('VmumV');
        // Make sure multiple tabs dont cause issues.
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testCannotIndentFirstItemInList()


    /**
     * Test that indent works for last item in the list using the shortcut.
     *
     * @return void
     */
    public function testIndentLastItemInTheListUsingShortcut()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickInlineToolbarButton('listUL');
        sleep(1);

        $this->selectText('TicT');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        sleep(1);
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV<ul><li>cPOc ccccc dddd. TicT</li></ul></li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');


    }//end testIndentLastItemInTheListUsingShortcut()


    /**
     * Test that indent works for last item in the list using the indent icon.
     *
     * @return void
     */
    public function testIndentLastItemInTheListUsingIndentIcon()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickInlineToolbarButton('listUL');
        sleep(1);

        $this->selectText('TicT');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->clickInlineToolbarButton('listIndent');

        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV<ul><li>cPOc ccccc dddd. TicT</li></ul></li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testIndentLastItemInTheListUsingIndentIcon()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testIndentOutdentLastItemSelectionShortcut()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickInlineToolbarButton('listUL');
        sleep(1);
        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->selectText('TicT');

        $this->keyDown('Key.TAB');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ul><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testIndentOutdentLastItemSelectionShortcut()


    /**
     * Test indent/outdent.
     *
     * @return void
     */
    public function testIndentOutdentItems()
    {
        $this->selectText('oNo', 'action');
        $this->keyDown('Key.TAB');

        sleep(1);
        $this->selectText('content');
        $this->keyDown('Key.TAB');

        $expected = array(
                     array(
                      'ul' => array(
                               array('ul' => array('li')),
                               'li',
                               'li',
                              ),
                     ),
                     'li',
                    );

        $this->assertListEqual($expected);

        sleep(1);
        $this->selectText('oNo');
        $this->keyDown('Key.SHIFT + Key.TAB');

        $expected = array(
                     'li',
                     array(
                      'ul' => array(
                               'li',
                               'li',
                               'li',
                              ),
                     ),
                     'li',
                    );

        $this->assertListEqual($expected);

    }//end testIndentOutdentItems()


    /**
     * Test indent keeps selection and styles can be applied to multiple list elements.
     *
     * @return void
     */
    public function testIndentSelectionKeptStyleApplied()
    {
        $this->selectText('oNo', 'action');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc<ul><li>4 <strong>oNo templates</strong></li><li><strong>Audit XuT content</strong></li><li><strong>Accessibility audit report</strong></li><li><strong>Recommendations action</strong> plan</li></ul></li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        sleep(1);

        $this->selectText('oNo', 'content');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content<ul><li><strong>Accessibility audit report</strong></li><li><strong>Recommendations action</strong> plan</li></ul></li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testIndentSelectionKeptStyleApplied()


    /**
     * Test that when you click the unordered list icon for one item in the list, that item is removed
     *
     * @return void
     */
    public function testRemoveAllListItemsWhenClickUnorderedListIcon()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><p>aaa bbbbb ccccc</p><p>4 oNo templates</p><p>Audit XuT content</p><p>Accessibility audit report</p><p>Recommendations action plan</p><p>Squiz Matrix guide</p><h2>SoD</h2>');

    }//end testRemoveOneListItemWhenClickUnorderedListIcon()


    /**
     * Test that you can use the unordered list icon to remove an item and then add it back to the list.
     *
     * @return void
     */
    public function testRemoveAndCreatingNewListUsingUnorderedListIcon()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li></ul><p>Audit XuT content</p><ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->selectText('XuT');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li></ul><ul><li>Audit XuT content</li></ul><ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testRemoveAndCreatingNewListUsingUnorderedListIcon()


    /**
     * Test remove list items.
     *
     * @return void
     */
    public function testRemoveListItems()
    {
        $this->selectText('oNo', 'action');
        $this->keyDown('Key.TAB');

        $this->selectText('oNo', 'content');
        $this->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc<ul><li>Accessibility audit report</li><li>Recommendations action plan</li></ul></li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testRemoveListItems()


    /**
     * Test keyboard navigation.
     *
     * @return void
     */
    public function testListKeyboardNav()
    {
        $this->selectText('oNo');

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

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc<ul><li>4 oNo templates</li></ul></li><li>Audit XuT content<ul><li>Accessibility audit report<ul><li>Recommendations action plan</li></ul></li><li>Squiz Matrix guide</li></ul></li></ul><h2>SoD</h2>');

    }//end testListKeyboardNav()


    /**
     * Test that the list is turned into separate paragraphs when you select all items and press the outdent icon.
     *
     * @return void
     */
    public function testListToParaUsingOutdentIcon()
    {
        $this->selectText('oNo');
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><p>aaa bbbbb ccccc</p><p>4 oNo templates</p><p>Audit XuT content</p><p>Accessibility audit report</p><p>Recommendations action plan</p><p>Squiz Matrix guide</p><h2>SoD</h2>');

    }//end testListToParaUsingOutdentIcon()


    /**
     * Test that the list is turned into separate paragraphs when you select all items and press the unordered list icon.
     *
     * @return void
     */
    public function testListToParaUsingUnorderedListIcon()
    {
        $this->selectText('oNo');
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><p>aaa bbbbb ccccc</p><p>4 oNo templates</p><p>Audit XuT content</p><p>Accessibility audit report</p><p>Recommendations action plan</p><p>Squiz Matrix guide</p><h2>SoD</h2>');

    }//end testListToParaUsingOutdentIcon()


    /**
     * Test that new items can be added to the list.
     *
     * @return void
     */
    public function testNewItemCreationForUnorderedLists()
    {
        $this->selectText('oNo');
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

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Test<ul><li>Test 2</li><li>Test 3<ul><li>Test 4</li></ul></li></ul></li><li>Test 5</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testNewItemCreation()


    /**
     * Test that an item can be removed from the list.
     *
     * @return void
     */
    public function testRemoveItemFromList()
    {
        $this->selectText('oNo');
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);

        // Remove whole item contents.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');
        sleep(1);

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');


    }//end testRemoveItemFromList()


    /**
     * Test that a sub list with single item is removed from the main list.
     *
     * @return void
     */
    public function testRemoveSubListFromList()
    {
        $this->selectText('oNo');
        $this->keyDown('Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc<ul><li>4 oNo templates</li></ul></li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->selectInlineToolbarLineageItem(3);
        sleep(1);

        // Remove whole item contents.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testRemoveSubListFromList()


    /**
     * Test that a sub list with single item is removed from the main list.
     *
     * @return void
     */
    public function testRemoveSubListItemFromList2()
    {
        $this->selectText('oNo');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');

        sleep(1);
        $this->selectText('XuT');

        $this->selectInlineToolbarLineageItem(3);
        sleep(1);

        // Remove whole item contents.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');
        sleep(1);

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc<ul><li>4 oNo templates</li></ul></li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testRemoveSubListItemFromList()


    /**
     * Test remove whole list.
     *
     * @return void
     */
    public function testRemoveWholeList()
    {
        $this->selectText('oNo');
        $this->selectInlineToolbarLineageItem(0);
        sleep(1);

        // Remove everything except the last list item.
        $this->keyDown('Key.BACKSPACE');

        // Remove the whole list.
        $this->keyDown('Key.BACKSPACE');

        sleep(1);
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><h2>SoD</h2>');

    }//end testRemoveWholeList()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListTypeFromUnOrderedToOrderedList()
    {
        $this->selectText('oNo');
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickTopToolbarButton('listOL');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

    }//end testConvertListTypeFromUnOrderedToOrderedList()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListFromUnorderedToOrderedWithItemSelection()
    {
        $this->selectText('XuT');
        $this->clickTopToolbarButton('listOL');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');


    }//end testConvertListFromUnorderedToOrderedWithItemSelection()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListFromUnorderedToOrderedWithSubList()
    {
        $this->selectText('oNo');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');

        sleep(1);
        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('listOL');

        $expected = array(
                     array(
                      'ul'      => array(
                                    array('content' => '4 oNo templates'),
                                    array('content' => 'Audit XuT content'),
                                   ),
                      'content' => 'aaa bbbbb ccccc',
                     ),
                     array('content' => 'Accessibility audit report'),
                     array('content' => 'Recommendations action plan'),
                     array('content' => 'Squiz Matrix guide'),
                    );

        $this->assertListEqual($expected, TRUE);

        sleep(1);
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc<ul><li>4 oNo templates</li><li>Audit XuT content</li></ul></li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');


    }//end testConvertListFromUnorderedToOrderedWithSubList()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertSubListType()
    {
        $this->selectText('XuT');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.UP');
        $this->keyDown('Key.TAB');

        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(2);

        sleep(1);
        $this->clickTopToolbarButton('listOL');

        sleep(1);
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc<ol><li>4 oNo templates</li><li>Audit XuT content</li></ol></li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testConvertSubListType()


    /**
     * Test that after you remove all items from the list, the undo icon is active and that when you click it the list is replaced.
     *
     * @return void
     */
    public function testClickUndoAfterRemovingList()
    {
        $this->click($this->find('oNo'));
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><p>aaa bbbbb ccccc</p><p>4 oNo templates</p><p>Audit XuT content</p><p>Accessibility audit report</p><p>Recommendations action plan</p><p>Squiz Matrix guide</p><h2>SoD</h2>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testHeadingIconNotAvailableForList()


    /**
     * Test copy and paste for part of a list.
     *
     * @return void
     */
    public function testCopyAndPastePartOfList()
    {
        $this->selectText('oNo', 'XuT');
        $this->keyDown('Key.CMD + c');

        $this->selectText('SoD');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2><ul><li>oNo templates</li><li>Audit XuT</li></ul><p></p>');

    }//end testCopyAndPastePartOfList()


    /**
     * Test copy and paste a list.
     *
     * @return void
     */
    public function testCopyAndPasteForAList()
    {
        $this->selectText('oNo');
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + c');

        $this->selectText('TicT');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.CMD + v');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><ul><li>aaa bbbbb ccccc</li><li>4&nbsp;oNo&nbsp;templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><p>&nbsp;</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testCopyAndPasteForAList()


    /**
     * Test that a paragraph is created after a list and before a div.
     *
     * @return void
     */
    public function testCreatingParagraphAfterListBeforeADiv()
    {
        $this->selectText('WoW');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('New paragraph');

        sleep(1);
        $this->assertHTMLMatch('<p>ajhsd sjsjwi hhhh:</p><ul><li>Recommendations action plan</li><li>Squiz Matrix guide WoW</li></ul><p>New paragraph</p><div>Test div</div>');

    }//end testCreatingParagraphAfterListBeforeADiv()


    /**
     * Test that a paragraph is created after a list and before a Pre.
     *
     * @return void
     */
    public function testCreatingParagraphAfterListBeforeAPre()
    {
        $this->selectText('WoW');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('New paragraph');

        sleep(1);
        $this->assertHTMLMatch('<p>ajhsd sjsjwi hhhh:</p><ul><li>Recommendations action plan</li><li>Squiz Matrix guide WoW</li></ul><p>New paragraph</p><pre>Test pre</pre>');

    }//end testCreatingParagraphAfterListBeforeAPre()


    /**
     * Test that a paragraph is created after a list and before a quote.
     *
     * @return void
     */
    public function testCreatingParagraphAfterListBeforeAQuote()
    {
        $this->selectText('WoW');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('New paragraph');

        sleep(1);
        $this->assertHTMLMatch('<p>ajhsd sjsjwi hhhh:</p><ul><li>Recommendations action plan</li><li>Squiz Matrix guide WoW</li></ul><p>New paragraph</p><blockquote>Test blockquote</blockquote>');

    }//end testCreatingParagraphAfterListBeforeAQuote()


    /**
     * Test that a paragraph is created after a list and before a paragraph.
     *
     * @return void
     */
    public function testCreatingParagraphAfterListBeforeAParagraph()
    {
        $this->selectText('WoW');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('New paragraph');

        sleep(1);
        $this->assertHTMLMatch('<p>ajhsd sjsjwi hhhh:</p><ul><li>Recommendations action plan</li><li>Squiz Matrix guide WoW</li></ul><p>New paragraph</p><p>Test para</p>');

    }//end testCreatingParagraphAfterListBeforeAParagraph()


}//end class

?>
