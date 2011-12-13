<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperListPlugin_UnorderedListUnitTest extends AbstractViperUnitTest
{


    /**
     * Overrides the default window size of the browser for list tests.
     *
     * @return array
     */
    protected function getDefaultWindowSize()
    {
        $size = array(
                 'w' => 1300,
                 'h' => 1100,
                );

        return $size;

    }//end getDefaultWindowSize()


    /**
     * Test that unordered list icon is displayed for paragraph and text selection.
     *
     * @return void
     */
    public function testListIconsOnSelection()
    {
        $this->selectText('XabcX', 'VmumV');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png'));

        $this->selectText('XabcX', 'TicT');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png'));

        $this->selectText('VmumV');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png'));

    }//end testListIconsOnSelection()


    /**
     * Test that unordered list is added and removed when toolbar icon is clicked.
     *
     * @return void
     */
    public function testListCreationFromTextSelection()
    {
        $this->selectText('VmumV');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_indent_disabled.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_indent_disabled.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_outdent.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_outdent.png'));

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png');
        sleep(1);

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_indent_disabled.png'));
        $this->assertFalse($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_indent_disabled.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_outdent.png'));
        $this->assertFalse($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_outdent.png'));

    }//end testListCreationFromTextSelection()


    /**
     * Test that unordered list is added and removed when toolbar icon is clicked.
     *
     * @return void
     */
    public function testListCreationFromParaSelection()
    {
        $this->selectText('XabcX', 'VmumV');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_indent_disabled.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_indent_disabled.png'));
        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_outdent.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_outdent.png'));

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList_active.png');
        sleep(1);

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_indent_disabled.png'));
        $this->assertFalse($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_indent_disabled.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_outdent.png'));
        $this->assertFalse($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_outdent.png'));

    }//end testListCreationFromParaSelection()


    /**
     * Test that outdent works for text selection.
     *
     * @return void
     */
    public function testOutdentTextSelection()
    {
        $this->selectText('VmumV');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_outdent.png');
        sleep(1);

        $this->assertTrue($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png'));
        $this->assertTrue($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_indent_disabled.png'));
        $this->assertFalse($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_indent_disabled.png'));
        $this->assertFalse($this->inlineToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_outdent.png'));
        $this->assertFalse($this->topToolbarButtonExists(dirname(__FILE__).'/Images/toolbarIcon_outdent.png'));

    }//end testOutdentTextSelection()


    /**
     * Test that outdent works for text selection using shortcut.
     *
     * @return void
     */
    public function testOutdentFirstItemSelectionShortcut()
    {
        $this->selectText('XabcX', 'TicT');

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
        sleep(1);

        $this->selectText('VmumV');

        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHasHTML(
            '<p>XabcX uuuuuu. VmumV</p><ul><li>cPOc ccccc dddd. TicT</li></ul><p>ZnnZ aaaa bbbb. YepeY</p>',
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

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
        sleep(1);

        $this->selectText('TicT');

        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHasHTML(
            '<ul><li>XabcX uuuuuu. VmumV</li></ul><p>cPOc ccccc dddd. TicT</p><p>ZnnZ aaaa bbbb. YepeY</p>',
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

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
        sleep(1);

        $this->selectText('VmumV');

        // Make sure multiple tabs dont cause issues.
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.TAB');

        $this->assertHasHTML(
            '<ul><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ul><p>ZnnZ aaaa bbbb. YepeY</p>',
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

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
        sleep(1);

        $this->selectText('TicT');

        $this->keyDown('Key.TAB');

        $this->assertHasHTML(
            '<ul><li>XabcX uuuuuu. VmumV<ul><li>cPOc ccccc dddd. TicT</li></ul></li></ul><p>ZnnZ aaaa bbbb. YepeY</p>',
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

        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_unorderedList.png');
        sleep(1);

        $this->selectText('TicT');

        $this->keyDown('Key.TAB');
        $this->keyDown('Key.SHIFT + Key.TAB');

        $this->assertHasHTML(
            '<ul><li>XabcX uuuuuu. VmumV</li><li>cPOc ccccc dddd. TicT</li></ul><p>ZnnZ aaaa bbbb. YepeY</p>',
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
        $rect4 = $this->getBoundingRectangle('li', 1);
        $this->click($this->getTopLeft($this->getRegionOnPage($rect4)));
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
        $this->selectText('additional', 'action');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.CMD + b');

        $expected = array(
                     array(
                      'ul'      => array(
                                    array('content' => '4 <strong>additional templates</strong>'),
                                    array('content' => '<strong>Audit for content</strong>'),
                                    array('content' => '<strong>Accessibility audit report</strong>'),
                                    array('content' => '<strong>Recommendations action</strong> plan'),
                                   ),
                      'content' => 'Audit Landing pages',
                     ),
                     array('content' => 'Squiz Matrix guide'),
                    );

        $this->assertListEqual($expected, TRUE);

        sleep(1);

        $this->selectText('additional', 'content');
        $this->keyDown('Key.SHIFT + Key.TAB');
        $this->keyDown('Key.CMD + b');

        $expected = array(
                     array('content' => 'Audit Landing pages'),
                     array('content' => '4 additional templates'),
                     array(
                      'ul'      => array(
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
        $this->selectText('additional', 'action');
        $this->keyDown('Key.TAB');

        sleep(1);
        $this->selectText('additional', 'content');
        $this->keyDown('Key.BACKSPACE');
        sleep(1);

        $expected = array(
                     array(
                      'ul'      => array(
                                    array('content' => '4 '),
                                    array('content' => 'Accessibility audit report'),
                                    array('content' => 'Recommendations action plan'),
                                   ),
                      'content' => 'Audit Landing pages',
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
        $this->selectText('additional');

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
     * Test keyboard navigation.
     *
     * @return void
     */
    public function testListToPara()
    {
        $this->selectText('additional');
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_outdent.png');

        $actTagCounts = $this->execJS('gTagCounts("p,ul,ol")');
        $expected     = array(
                         'p'  => 11,
                         'ul' => 0,
                         'ol' => 0,
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
        $this->selectText('additional');
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
                     array('content' => 'Audit Landing pages'),
                     array('content' => '4 additional templates'),
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
        $this->selectText('additional');
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);

        // Remove whole item contents.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');

        $expected = array(
                     array('content' => 'Audit Landing pages'),
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
        $this->selectText('additional');
        $this->keyDown('Key.TAB');
        sleep(1);

        $this->selectInlineToolbarLineageItem(3);
        sleep(1);

        // Remove whole item contents.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');

        $expected = array(
                     array('content' => 'Audit Landing pages'),
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
        $this->selectText('additional');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');

        $this->selectText('additional');

        $this->selectInlineToolbarLineageItem(3);
        sleep(1);

        // Remove whole item contents.
        $this->keyDown('Key.BACKSPACE');

        // Remove the item element.
        $this->keyDown('Key.BACKSPACE');

        $expected = array(
                     array(
                      'ul'      => array(
                                    array('content' => 'Audit for content'),
                                   ),
                      'content' => 'Audit Landing pages',
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
        $this->selectText('additional');
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);

        // Remove everything except the last list item.
        $this->keyDown('Key.BACKSPACE');

        // Remove the whole list.
        $this->keyDown('Key.BACKSPACE');

        $actTagCounts = $this->execJS('gTagCounts("p,ul,ol")');
        $expected     = array(
                         'p'  => 5,
                         'ul' => 0,
                         'ol' => 0,
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
        $this->selectText('additional');
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');

        $actTagCounts = $this->execJS('gTagCounts("p,ul,ol")');
        $expected     = array(
                         'p'  => 5,
                         'ul' => 0,
                         'ol' => 1,
                        );

        $this->assertEquals($expected, $actTagCounts, 'Content tag counts did not match');

    }//end testConvertListType()


    /**
     * Test a list can be converted to another list type.
     *
     * @return void
     */
    public function testConvertListTypeWithSubList()
    {
        $this->selectText('additional');
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.DOWN');
        $this->keyDown('Key.TAB');

        $this->selectText('additional');
        $this->selectInlineToolbarLineageItem(0);

        sleep(1);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');

        $expected = array(
                     array(
                      'ul'      => array(
                                    array('content' => '4 additional templates'),
                                    array('content' => 'Audit for content'),
                                   ),
                      'content' => 'Audit Landing pages',
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
        $this->keyDown('Key.TAB');
        $this->keyDown('Key.UP');
        $this->keyDown('Key.TAB');

        $this->selectText('Matrix');
        $this->selectInlineToolbarLineageItem(2);

        sleep(1);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_orderedList.png');

        $expected = array(
                     array('content' => 'Audit Landing pages'),
                     array('content' => '4 additional templates'),
                     array('content' => 'Audit for content'),
                     array(
                      'ol'      => array(
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


}//end class

?>
