<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_OrderedListUnitTest extends AbstractViperListPluginUnitTest
{


    /**
     * Test that unordered list is added and removed when toolbar icon is clicked.
     *
     * @return void
     */
    public function testListCreationFromTextSelection()
    {
        $this->selectText('VmumV');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');

        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->selectText('VmumV');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList_active.png');
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

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList_active.png');
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

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_outdent.png');
        $this->assertIconStatusesCorrect(TRUE, TRUE, NULL, NULL);

    }//end testOutdentTextSelection()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testOutdentFirstItemSelectionShortcut()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        sleep(1);

        $this->selectText('VmumV');

        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHasHTML(
            '<p>XabcX uuuuuu. VmumV</p><ol><li>cPOc ccccc dddd. TicT</li></ol><p>ZnnZ aaaa bbbb. YepeY</p>',
            0,
            'Outdent of first item in the list should convert it to P tag.'
        );

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

        $this->selectText('TicT');

        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHasHTML(
            '<ol><li>XabcX uuuuuu. VmumV</li></ol><p>cPOc ccccc dddd. TicT</p><p>ZnnZ aaaa bbbb. YepeY</p>',
            0,
            'Outdent of first item in the list should convert it to P tag.'
        );

    }//end testOutdentLastItemSelectionShortcut()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testIndentFirstItemSelectionShortcut()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        sleep(1);

        $this->selectText('VmumV');

        // Make sure multiple tabs dont cause issues.
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');

        $this->assertHasHTML(
            '<ol><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ol><p>ZnnZ aaaa bbbb. YepeY</p>',
            0,
            'Indent of first item should do nothing.'
        );

    }//end testIndentFirstItemSelectionShortcut()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testIndentLastItemSelectionShortcut()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');
        sleep(1);

        $this->selectText('TicT');

        $this->keyDown('Key.TAB');

        $this->assertHasHTML(
            '<ol><li>XabcX uuuuuu. VmumV<ol><li>cPOc ccccc dddd. TicT</li></ol></li></ol><p>ZnnZ aaaa bbbb. YepeY</p>',
            0,
            'Indent of last item should indent the last item.'
        );

    }//end testIndentLastItemSelectionShortcut()


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

        $this->selectText('TicT');

        $this->keyDown('Key.TAB');
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHasHTML(
            '<ol><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ol><p>ZnnZ aaaa bbbb. YepeY</p>',
            0,
            'Outdent of 2nd level list item should work.'
        );

    }//end testIndentOutdentLastItemSelectionShortcut()


    /**
     * Test indent/outdent.
     *
     * @return void
     */
    public function testIndentOutdentItems()
    {
        $rect1 = $this->getBoundingRectangle('li', 1);
        sleep(1);
        $rect2 = $this->getBoundingRectangle('li', 4);

        $this->dragDrop($this->getRegionOnPage($rect1), $this->getRegionOnPage($rect2));
        $this->keyDown('Key.TAB');

        $rect3 = $this->getBoundingRectangle('li', 2);
        $this->dragDrop($this->getRegionOnPage($rect3), $this->getRegionOnPage($rect3));
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
                                    array('content' => '<strong>Audit for content</strong>'),
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
                      'content' => 'Audit for content',
                     ),
                     array('content' => 'Squiz Matrix guide'),
                    );

        $this->assertListEqual($expected, TRUE);

    }//end testIndentSelectionKeptStyleApplied()


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
     * Test keyboard navigation.
     *
     * @return void
     */
    public function testListToPara()
    {
        $this->selectText('oNo');
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_outdent.png');

        $actTagCounts = $this->execJS('gTagCounts("p,ul,ol")');
        $expected     = array(
                         'p'  => 11,
                         'ol' => 0,
                         'ul' => 0,
                        );

        $this->assertEquals($expected, $actTagCounts, 'Content tag counts did not match');

    }//end testListToPara()


    /**
     * Test that new items can be added to the list.
     *
     * @return void
     */
    public function testNewItemCreation()
    {
        $this->selectText('oNo');
        $this->keyDown('Key.RIGHT + Key.RIGHT');
        $this->keyDown('Key.CMD + Key.RIGHT');
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
                     array('content' => 'Audit for content'),
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
                     array('content' => 'Audit for content'),
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
                     array('content' => 'Audit for content'),
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
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');

        $this->selectText('oNo');

        $this->selectInlineToolbarLineageItem(3);
        sleep(1);

        // Remove whole item contents.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');

        $expected = array(
                     array(
                      'ol'      => array(
                                    array('content' => 'Audit for content'),
                                   ),
                      'content' => 'aaa bbbbb ccccc',
                     ),
                     array('content' => 'Accessibility audit report'),
                     array('content' => 'Recommendations action plan'),
                     array('content' => 'Squiz Matrix guide'),
                    );
        $this->assertListEqual($expected, TRUE);

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

        $actTagCounts = $this->execJS('gTagCounts("p,ul,ol")');
        $expected     = array(
                         'p'  => 5,
                         'ol' => 0,
                         'ul' => 0,
                        );

        $this->assertEquals($expected, $actTagCounts, 'Content tag counts did not match');

    }//end testRemoveWholeList()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListType()
    {
        $this->selectText('oNo');
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');

        $actTagCounts = $this->execJS('gTagCounts("p,ul,ol")');
        $expected     = array(
                         'p'  => 5,
                         'ul' => 1,
                         'ol' => 0,
                        );

        $this->assertEquals($expected, $actTagCounts, 'Content tag counts did not match');

    }//end testConvertListType()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListTypeWithItemSelection()
    {
        $this->selectText('Matrix');
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');

        $actTagCounts = $this->execJS('gTagCounts("p,ul,ol")');
        $expected     = array(
                         'p'  => 5,
                         'ul' => 1,
                         'ol' => 0,
                        );

        $this->assertEquals($expected, $actTagCounts, 'Content tag counts did not match');

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
        $this->selectText('oNo');
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');

        $expected = array(
                     array(
                      'ol'      => array(
                                    array('content' => '4 oNo templates'),
                                    array('content' => 'Audit for content'),
                                   ),
                      'content' => 'aaa bbbbb ccccc',
                     ),
                     array('content' => 'Accessibility audit report'),
                     array('content' => 'Recommendations action plan'),
                     array('content' => 'Squiz Matrix guide'),
                    );

        $this->assertListEqual($expected, TRUE);

        sleep(1);
        $actTagCounts = $this->execJS('gTagCounts("p,ul,ol")');
        $expected     = array(
                         'p'  => 5,
                         'ul' => 1,
                         'ol' => 1,
                        );

        $this->assertEquals($expected, $actTagCounts, 'Content tag counts did not match');

    }//end testConvertListTypeWithSubList()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertSubListType()
    {
        $this->selectText('Matrix');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.UP');
        $this->keyDown('Key.TAB');

        $this->selectText('Matrix');
        $this->selectInlineToolbarLineageItem(2);

        sleep(1);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');

        $expected = array(
                     array('content' => 'aaa bbbbb ccccc'),
                     array('content' => '4 oNo templates'),
                     array('content' => 'Audit for content'),
                     array(
                      'ul'      => array(
                                    array('content' => 'Recommendations action plan'),
                                    array('content' => 'Squiz Matrix guide'),
                                   ),
                      'content' => 'Accessibility audit report',
                     ),
                    );

        $this->assertListEqual($expected, TRUE);

        sleep(1);
        $actTagCounts = $this->execJS('gTagCounts("p,ul,ol")');
        $expected     = array(
                         'p'  => 5,
                         'ul' => 1,
                         'ol' => 1,
                        );

        $this->assertEquals($expected, $actTagCounts, 'Content tag counts did not match');

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


}//end class

?>
