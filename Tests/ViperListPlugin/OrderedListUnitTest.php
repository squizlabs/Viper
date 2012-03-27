<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_OrderedListUnitTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test that unordered list is added and removed for the paragraph when you click inside a word.
     *
     * @return void
     */
    public function testListCreationFromClickingInText()
    {
        $this->click($this->find('VmumV'));

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<ol><li>XabcX uuuuuu. VmumV</li></ol><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

        $this->click($this->find('VmumV'));
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList_active.png');
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

    }//end testListCreationFromClickingInText()


    /**
     * Test that ordered list is added and removed when toolbar icon is clicked.
     *
     * @return void
     */
    public function testListCreationFromTextSelection()
    {
        $this->selectText('VmumV');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<ol><li>XabcX uuuuuu. VmumV</li></ol><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

        $this->selectText('VmumV');
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png');
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

    }//end testListCreationFromTextSelection()


    /**
     * Test that unordered list is added and removed when toolbar icon is clicked.
     *
     * @return void
     */
    public function testListCreationFromParaSelection()
    {
        $this->selectText('XabcX', 'VmumV');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<ol><li>XabcX uuuuuu. VmumV</li></ol><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList_active.png');
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

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        $this->assertHTMLMatch('<ol><li>XabcX uuuuuu. VmumV</li></ol><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

        $this->selectText('VmumV');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_outdent.png');
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

    }//end testOutdentTextSelection()


    /**
     * Test that outdent icon in enabled when selecting different text in a list item.
     *
     * @return void
     */
    public function testOutdentIconIsEnabled()
    {
        $this->selectText('XabcX', 'TicT');
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');

        // Outdent icon is enabled when you click inside a list item.
        $this->click($this->find('VmumV'));
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        // Outdent icon is enabled when you select a word in a list item.
        $this->selectText('VmumV');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        // Outdent icon is enabled when you select a list item.
        $this->selectText('XabcX');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        // Outdent icon is enabled when you select the list.
        $this->selectText('XabcX');
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
        $this->selectText('bbbbb', 'XuT');
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><p>aaa bbbbb ccccc</p><p>4 oNo templates</p><p>Audit XuT content</p><ol><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

        $this->selectText('bbbbb', 'XuT');
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

    }//end testOutdentAndIndentListItemsUsingKeyboardShortcuts()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testOutdentFirstItemSelectionShortcut()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        sleep(1);
        $this->assertHTMLMatch('<ol><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

        $this->selectText('VmumV');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><ol><li>cPOc ccccc dddd. TicT</li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

    }//end testOutdentFirstItemSelectionShortcut()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testOutdentLastItemSelectionShortcut()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        sleep(1);
        $this->assertHTMLMatch('<ol><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

        $this->selectText('TicT');
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHTMLMatch('<ol><li>XabcX uuuuuu. VmumV</li></ol><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

    }//end testOutdentLastItemSelectionShortcut()


    /**
     * Test that outdent works for the third list item and then its added back to the list when you click the ordered list icon.
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

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li></ol><p>Audit XuT content</p><ol><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

        $this->click($textLoc);
        sleep(1);
        $this->clickTopToolbarButton($dir.'toolbarIcon_orderedList.png');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

    }//end testOutdentThirdListItemAndAddBackToList()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testIndentFirstItemSelectionShortcut()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        sleep(1);

        $this->selectText('VmumV');

        // Make sure multiple tabs dont cause issues.
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ol><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

    }//end testIndentFirstItemSelectionShortcut()


    /**
     * Test that indent works for last item in the list using the shortcut.
     *
     * @return void
     */
    public function testIndentLastItemInTheListUsingShortcut()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        sleep(1);

        $this->selectText('TicT');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->selectText('TicT');
        $this->keyDown('Key.TAB');

        $this->assertHTMLMatch('<ol><li>XabcX uuuuuu. VmumV<ol><li>cPOc ccccc dddd. TicT</li></ol></li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');


    }//end testIndentLastItemInTheListUsingShortcut()


    /**
     * Test that indent works for last item in the list using the indent icon.
     *
     * @return void
     */
    public function testIndentLastItemInTheListUsingIndentIcon()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        sleep(1);

        $this->selectText('TicT');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        $this->selectText('TicT');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_indent.png');

        $this->assertHTMLMatch('<ol><li>XabcX uuuuuu. VmumV<ol><li>cPOc ccccc dddd. TicT</li></ol></li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

    }//end testIndentLastItemInTheListUsingIndentIcon()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testIndentOutdentLastItemSelectionShortcut()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        sleep(1);
        $this->assertHTMLMatch('<ol><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

        $this->selectText('TicT');

        $this->keyDown('Key.TAB');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<ol><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ol><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

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
                      'ol' => array(
                               array('ol' => array('li')),
                               'li',
                               'li',
                              ),
                     ),
                     'li',
                    );

        $this->assertListEqual($expected);

        sleep(1);
        $rect4 = $this->getBoundingRectangle('li', 1);
        $this->click($this->getTopLeft($this->getRegionOnPage($rect4)));
        $this->keyDown('Key.SHIFT + Key.TAB');

        $expected = array(
                     'li',
                     array(
                      'ol' => array(
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
                      'ol'      => array(
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
                      'ol'      => array(
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
     * Test that when you click the ordered list icon for one item in the list, that item is removed
     *
     * @return void
     */
    public function testRemoveOneListItemWhenClickOrderedListIcon()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png');
        $this->assertIconStatusesCorrect(TRUE, TRUE, FALSE, FALSE);
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li></ol><p>Audit XuT content</p><ol><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

    }//end testRemoveOneListItemWhenClickUnorderedListIcon()


    /**
     * Test that you can use the ordered list icon to remove an item and then add it back to the list.
     *
     * @return void
     */
    public function testRemoveAndAddListItemUsingOrderedListIcon()
    {
        $this->selectText('XuT');

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li></ul><p>Audit XuT content</p><ul><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

        $this->selectText('XuT');
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

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
                      'ol'      => array(
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
                      'ol' => array('li'),
                     ),
                     array(
                      'ol' => array(
                               array(
                                'ol' => array('li'),
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
     * Test that the list is turned into separate paragraphs when you select all items and press the ordered list icon.
     *
     * @return void
     */
    public function testListToParaUsingOrderedListIcon()
    {
        $this->selectText('oNo');
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><p>aaa bbbbb ccccc</p><p>4 oNo templates</p><p>Audit XuT content</p><p>Accessibility audit report</p><p>Recommendations action plan</p><p>Squiz Matrix guide</p><h2>SoD</h2>');

    }//end testListToParaUsingOrderedListIcon()


    /**
     * Test that new items can be added to the list.
     *
     * @return void
     */
    public function testNewItemCreation()
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
                      'ol'      => array(
                                    array('content' => 'Test 2'),
                                    array(
                                     'ol'      => array(
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
    public function testRemoveSubListItemFromList()
    {
        $this->selectText('oNo');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');

        $this->selectText('XuT');

        $this->selectInlineToolbarLineageItem(3);
        sleep(1);

        // Remove whole item contents.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc<ol><li>4 oNo templates</li></ol></li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

    }//end testRemoveSubListItemFromList()


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

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc<ol><li>4 oNo templates</li></ol></li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

    }//end testRemoveSubListItemFromList2()


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

       $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><h2>SoD</h2>');

    }//end testRemoveWholeList()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListTypeA()
    {
        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testConvertListType()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListTypeWithItemSelection()
    {
        $this->selectText('XuT');
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testConvertListTypeWithItemSelection()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListTypeWithSubList2()
    {
        $this->selectText('oNo');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');

        sleep(1);
        $this->selectText('XuT');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ul><li>aaa bbbbb ccccc<ol><li>4 oNo templates</li><li>Audit XuT content</li></ol></li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ul><h2>SoD</h2>');

    }//end testConvertListTypeWithSubList2()


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
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');

        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc<ul><li>4 oNo templates</li><li>Audit XuT content</li></ul></li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

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

        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');

        $this->assertEquals('<ol><li>&nbsp;</li></ol>', $this->getHtml('td', 0));

    }//end testListIconsAvailableInTableCell()


    /**
     * Test that the heading icon is not available for a list.
     *
     * @return void
     */
    public function testHeadingIconNotAvailableForList()
    {
        $dir = dirname(dirname(__FILE__)).'/ViperFormatPlugin/Images/';

        $this->click($this->find('oNo'));
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading_disabled.png'), 'Heading icon should not appear in the top toolbar.');

        $this->selectText('oNo');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading_disabled.png'), 'Heading icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading_disabled.png'), 'Heading icon should not appear in the top toolbar.');

        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_heading_disabled.png'), 'Heading icon should not appear in the top toolbar.');

    }//end testHeadingIconNotAvailableForList()


    /**
     * Test that after you remove all items from the list, the undo icon is active and that when you click it the list is replaced.
     *
     * @return void
     */
    public function testClickUndoAfterRemovingList()
    {
        $this->click($this->find('oNo'));
        $this->clickTopToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList_active.png');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><p>aaa bbbbb ccccc</p><p>4 oNo templates</p><p>Audit XuT content</p><p>Accessibility audit report</p><p>Recommendations action plan</p><p>Squiz Matrix guide</p><h2>SoD</h2>');

        $this->clickTopToolbarButton(dirname(dirname(__FILE__)).'/Core/Images/undorIcon_active.png');
        $this->assertHTMLMatch('<p>XabcX uuuuuu. VmumV</p><p>cPOc ccccc dddd. TicT</p><p>ajhsd sjsjwi hhhh:</p><ol><li>aaa bbbbb ccccc</li><li>4 oNo templates</li><li>Audit XuT content</li><li>Accessibility audit report</li><li>Recommendations action plan</li><li>Squiz Matrix guide</li></ol><h2>SoD</h2>');

    }//end testHeadingIconNotAvailableForList()



}//end class

?>
