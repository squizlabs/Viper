<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_UnorderedListUnitTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test that unordered list is added and removed for the paragraph when you only selected one word.
     *
     * @return void
     */
    public function testListCreationFromTextSelection()
    {
        $this->selectText('VmumV');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV</li></ul><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->selectText('VmumV');
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png');
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

    }//end testListCreationFromTextSelection()


    /**
     * Test that unordered list is added and removed when select a paragraph.
     *
     * @return void
     */
    public function testListCreationFromParaSelection()
    {
        $this->selectText('XabcX', 'VmumV');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV</li></ul><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png');
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

    }//end testListCreationFromParaSelection()


    /**
     * Test that outdent works for text selection.
     *
     * @return void
     */
    public function testOutdentTextSelection()
    {
        $this->selectText('VmumV');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
        $this->assertHTMLMatch('<ul><li>XabcX uuuuuu. VmumV</li></ul><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->selectText('VmumV');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_outdent.png');
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);
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
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');

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

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
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

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
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
     * Test that outdent works for the third list item and then its added back to the list when you click the unordered list icon.
     *
     * @return void
     */
    public function testOutdentThirdListItemAndAddBackToList()
    {
        $dir = dirname(__FILE__).'/Images/';

        $textLoc = $this->find('XuT');
        $this->click($textLoc);

        $this->clickTopToolbarButton($dir.'toolbarIcon_outdent.png');
        sleep(1);
        $this->selectText('XuT');
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li></ul><p>Audit XuT content</p><ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->click($textLoc);
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_unorderedList.png');
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

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
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

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
        sleep(1);

        $this->selectText('TicT');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->selectText('TicT');
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

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
        sleep(1);

        $this->selectText('TicT');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        $this->selectText('TicT');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_indent.png');

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

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
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

        $expected = array(
                     array(
                      'ul'      => array(
                                    array('content' => '4 <strong>oNo templates</strong>'),
                                    array('content' => '<strong>Audit XuT content</strong>'),
                                    array('content' => '<strong>Accessibility audit report</strong>'),
                                    array('content' => '<strong>Recommendations action</strong> plan'),
                                   ),
                      'content' => 'aaa bbbbb ccccc',
                     ),
                     array('content' => 'Squiz Matrix guide'),
                    );

        $this->assertListEqual($expected, TRUE);

        sleep(1);

        $this->selectText('oNo', 'content');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->keyDown('Key.CMD + b');

        $expected = array(
                     array('content' => 'aaa bbbbb ccccc'),
                     array('content' => '4 oNo templates'),
                     array(
                      'ul'      => array(
                                    array('content' => '<strong>Accessibility audit report</strong>'),
                                    array('content' => '<strong>Recommendations action</strong> plan'),
                                   ),
                      'content' => 'Audit XuT content',
                     ),
                     array('content' => 'Squiz Matrix guide'),
                    );

        $this->assertListEqual($expected, TRUE);

    }//end testIndentSelectionKeptStyleApplied()


    /**
     * Test that when you click the unordered list icon for one item in the list, that item is removed
     *
     * @return void
     */
    public function testRemoveOneListItemWhenClickUnorderedListIcon()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li></ul><p>Audit XuT content</p><ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testRemoveOneListItemWhenClickUnorderedListIcon()


    /**
     * Test that you can use the unordered list icon to remove an item and then add it back to the list.
     *
     * @return void
     */
    public function testRemoveAndAddListItemUsingUnorderedListIcon()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li></ul><p>Audit XuT content</p><ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

        $this->selectText('XuT');
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testRemoveOneListItemWhenClickUnorderedListIcon()


    /**
     * Test remove list items.
     *
     * @return void
     */
    public function testRemoveListItems()
    {
        $this->selectText('oNo', 'action');
        $this->keyDown('Key.TAB');

        sleep(1);
        $this->selectText('oNo', 'content');
        $this->keyDown('Key.BACKSPACE');
        sleep(1);

        $expected = array(
                     array(
                      'ul'      => array(
                                    array('content' => '4 '),
                                    array('content' => 'Accessibility audit report'),
                                    array('content' => 'Recommendations action plan'),
                                   ),
                      'content' => 'aaa bbbbb ccccc',
                     ),
                     array('content' => 'Squiz Matrix guide'),
                    );

        $this->assertListEqual($expected, TRUE);

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

        $expected = array(
                     array(
                      'ul' => array('li'),
                     ),
                     array(
                      'ul' => array(
                               array(
                                'ul' => array('li'),
                               ),
                               'li',
                              ),
                     ),
                    );

        $this->assertListEqual($expected);

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
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_outdent.png');
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
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png');
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

        $expected = array(
                     array('content' => 'aaa bbbbb ccccc'),
                     array('content' => '4 oNo templates'),
                     array(
                      'ul'      => array(
                                    array('content' => 'Test 2'),
                                    array(
                                     'ul'      => array(
                                                   array('content' => 'Test 4'),
                                                  ),
                                     'content' => 'Test 3',
                                    ),
                                   ),
                      'content' => 'Test',
                     ),
                     array('content' => 'Test 5'),
                     array('content' => 'Audit XuT content'),
                     array('content' => 'Accessibility audit report'),
                     array('content' => 'Recommendations action plan'),
                     array('content' => 'Squiz Matrix guide'),
                    );
        $this->assertListEqual($expected, TRUE);

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

        $expected = array(
                     array('content' => 'aaa bbbbb ccccc'),
                     array('content' => 'Audit XuT content'),
                     array('content' => 'Accessibility audit report'),
                     array('content' => 'Recommendations action plan'),
                     array('content' => 'Squiz Matrix guide'),
                    );
        $this->assertListEqual($expected, TRUE);

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

        $this->selectInlineToolbarLineageItem(3);
        sleep(1);

        // Remove whole item contents.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');

        $expected = array(
                     array('content' => 'aaa bbbbb ccccc'),
                     array('content' => 'Audit XuT content'),
                     array('content' => 'Accessibility audit report'),
                     array('content' => 'Recommendations action plan'),
                     array('content' => 'Squiz Matrix guide'),
                    );
        $this->assertListEqual($expected, TRUE);

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
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');

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
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');

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
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');

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
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');

        sleep(1);
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc<ol><li>4 oNo templates</li><li>Audit XuT content</li></ol></li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testConvertSubListType()


    /**
     * Test a list can be created inside a table cell.
     *
     * @return void
     */
    public function testListIconsAvailableInTableCell()
    {
        $this->selectText('XabcX');
        $this->execJS('insTable(3, 3)');

        $cellRect = $this->getBoundingRectangle('td', 0);
        $region   = $this->getRegionOnPage($cellRect);

        // Click inside the cell.
        $this->click($region);

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');

        $this->assertEquals('<ul><li>&nbsp;</li></ul>', $this->getHtml('td', 0));

    }//end testListIconsAvailableInTableCell()


}//end class

?>
