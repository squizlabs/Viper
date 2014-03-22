<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_IndentAndOutdentListTest extends AbstractViperListPluginUnitTest
{

    /**
     * Test outdent and indent a list item works.
     *
     * @return void
     */
    public function testOutdentAndIndentListItem()
    {
        //Test unordered list when clicking inside a list item
        $this->useTest(1);
        $this->moveToKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list when selecting a word in the list item and using the top toolbar icons
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list when selecting a word in the list item and using the inline toolbar icons
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list when selecting the whole list item
        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list using keyboard shortcuts
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test ordered list when clicking inside a list item
        $this->useTest(2);
        $this->moveToKeyword(2);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li></ol><p>second item %2%</p><ol><li>third %3% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

        //Test ordered list with top toolbar
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li></ol><p>second item %2%</p><ol><li>third %3% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

        //Test ordered list when selecting the whole list item
        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li></ol><p>second item %2%</p><ol><li>third %3% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

        //Test ordered list using keyboard shortcuts
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>XAX first item</li></ol><p>second item XBX</p><ol><li>third XCX item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

    }//end testOutdentAndIndentListItem()


    /**
     * Test that when you select a list, the outdent and indent icon works.
     *
     * @return void
     */
    public function testOutdentAndIndentAllItemsInAList()
    {
        //Test unordered list using icons
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><p>second item %2%</p><p>third %3% item</p>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list using keyboard shortcuts
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><p>second item %2%</p><p>third %3% item</p>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test ordered list using icons
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><p>second item %2%</p><p>third %3% item</p>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test ordered list using keyboard shortcuts
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><p>second item %2%</p><p>third %3% item</p>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

    }//end testOutdentAndIndentAllItemsInAList()


    /**
     * Test that outdent and indent works for the first item in the list.
     *
     * @return void
     */
    public function testOutdentAndIndentFirstItemInList()
    {
        //Test unordered list using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><ul><li>second item %2%</li><li>third %3% item</li></ul>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list using inline toolbar icons
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><ul><li>second item %2%</li><li>third %3% item</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list using top toolbar icons
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><ul><li>second item %2%</li><li>third %3% item</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test ordered list
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><ol><li>second item %2%</li><li>third %3% item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

        //Test ordered list using inline toolbar icons
        $this->useTest(2);
        $this->selectKeyword(1);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><ol><li>second item %2%</li><li>third %3% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

        //Test unordered list using top toolbar icons
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><ol><li>second item %2%</li><li>third %3% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

    }//end testOutdentAndIndentFirstItemInList()


    /**
     * Test that outdent and indent works for the last item in the list.
     *
     * @return void
     */
    public function testOutdentAndIndentLastItem()
    {
        //Test unordered list
        $this->useTest(1);
        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li></ul><p>third %3% item</p>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test ordered list
        $this->useTest(2);
        $this->selectKeyword(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li></ol><p>third %3% item</p>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

    }//end testOutdentAndIndentLastItem()


    /**
     * Test that indent creates a sub list and outdent adds it back to the master list.
     *
     * @return void
     */
    public function testIndentAndOutdentLastListItem()
    {
        //Test unordered list using keyboard shortcuts
        $this->useTest(1);
        $this->moveToKeyword(3);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%<ul><li>third %3% item</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list using icons
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%<ul><li>third %3% item</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test ordered list using keyboard shortcuts
        $this->useTest(2);
        $this->moveToKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%<ol><li>third %3% item</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

        //Test ordered list using icons
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%<ol><li>third %3% item</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

    }//end testIndentAndOutdentLastListItem()


    /**
     * Test that you can indent and outdent mulitple items multiple time.
     *
     * @return void
     */
    public function testOutdentAndIndentListItemsMultipleTimes()
    {
        //Test unordered list
        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><p>second item %2%</p><ul><li>third %3% item</li></ul>');
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><p>second item %2%</p><ul><li>third %3% item</li></ul>');
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test ordered list
        $this->useTest(2);

        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><p>second item %2%</p><ol><li>third %3% item</li></ol>');
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><p>second item %2%</p><ol><li>third %3% item</li></ol>');
        $this->selectKeyword(1, 2);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

    }//end testOutdentAndIndentListItemsMultipleTimes()


    /**
     * Test that you cannot indent the first item in the list.
     *
     * @return void
     */
    public function testCannotIndentFirstItemInList()
    {
        //Test unordered list
        $this->useTest(1);

        $this->moveToKeyword(1);
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        // Make sure multiple tabs dont cause issues.
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');

        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list
        $this->useTest(2);

        $this->moveToKeyword(1);
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        // Make sure multiple tabs dont cause issues.
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.TAB');

        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

    }//end testCannotIndentFirstItemInList()


    /**
     * Test indent and outdent keeps text selection and styles can be applied to multiple list elements.
     *
     * @return void
     */
    public function testIndentAndOutdentKeepsSelectionAndStylesApplied()
    {
        //Test unordered list
        $this->useTest(1);

        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item<ul><li>second item <strong>%2%</strong></li><li><strong>third %3%</strong> item</li></ul></li></ul>');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test ordered list
        $this->useTest(2);

        $this->selectKeyword(2, 3);
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item<ol><li>second item <strong>%2%</strong></li><li><strong>third %3%</strong> item</li></ol></li></ol>');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->sikuli->keyDown('Key.CMD + b');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

    }//end testIndentAndOutdentKeepsSelectionAndStylesApplied()


    /**
     * Tests that shift+tab in a non list item does nothing.
     *
     * @return void
     */
    public function testShiftTagInNonListItem()
    {
        //Test unordered list
        $this->useTest(1);

        $this->moveToKeyword(1);
        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test ordered list
        $this->useTest(2);

        $this->moveToKeyword(1);
        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

    }//end testShiftTagInNonListItem()


    /**
     * Test indenting and outdenting items in a list using keyboard navigation only.
     *
     * @return void
     */
    public function testListKeyboardNavForList()
    {
        //Test unordered list
        $this->useTest(1);

        $this->moveToKeyword(2);
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item<ul><li>second item %2%</li><li>third %3% item</li></ul></li></ul>');

        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%<ul><li>third %3% item</li></ul></li></ul>');

        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item<ul><li>second item %2%<ul><li>third %3% item</li></ul></li></ul></li></ul>');

        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%<ul><li>third %3% item</li></ul></li></ul>');

        //Test ordered list
        $this->useTest(2);

        $this->moveToKeyword(2);
        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item<ol><li>second item %2%</li><li>third %3% item</li></ol></li></ol>');

        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%<ol><li>third %3% item</li></ol></li></ol>');

        $this->sikuli->keyDown('Key.TAB');
        $this->sikuli->keyDown('Key.DOWN');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item<ol><li>second item %2%<ol><li>third %3% item</li></ol></li></ol></li></ol>');

        $this->sikuli->keyDown('Key.UP');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%<ol><li>third %3% item</li></ol></li></ol>');

    }//end testListKeyboardNavForList()


    /**
     * Test that you can outdent all items in the sub list and indent them again.
     *
     * @return void
     */
    public function testOutdentAllSubListItemsAndIndentAgain()
    {
        //Test unordered list with keyboard shortcuts
        $this->useTest(3);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item</li><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li><li>third item</li></ul>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item<br /><ul><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li></ul></li><li>third item</li></ul>');

        //Test unordered list with inline toolbar icons
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item</li><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li><li>third item</li></ul>');
        $this->clickInlineToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item<br /><ul><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li></ul></li><li>third item</li></ul>');

        //Test unordered list with top toolbar icons
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item</li><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li><li>third item</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item<br /><ul><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li></ul></li><li>third item</li></ul>');

        //Test ordered list with keyboard shortcuts
        $this->useTest(4);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item</li><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li><li>third item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item<br /><ol><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li></ol></li><li>third item</li></ol>');

        //Test ordered list with inline toolbar icons
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item</li><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li><li>third item</li></ol>');
        $this->clickInlineToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item<br /><ol><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li></ol></li><li>third item</li></ol>');

        //Test ordered list with top toolbar icons
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item</li><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li><li>third item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item<br /><ol><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li></ol></li><li>third item</li></ol>');

    }//end testOutdentAllSubListItemsAndIndentAgain()


    /**
     * Test outdent and indent first item in a sub lit.
     *
     * @return void
     */
    public function testOutdentAndIndentFirstItemInSubList()
    {
        //Test unordered list with keyboard shortcuts
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item</li><li>first sub item %1%<ul><li>second sub item %2%</li><li>third sub item %3%</li></ul></li><li>third item</li></ul>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item<br /><ul><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li></ul></li><li>third item</li></ul>');

        //Test unordered list with inline toolbar icons
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item</li><li>first sub item %1%<ul><li>second sub item %2%</li><li>third sub item %3%</li></ul></li><li>third item</li></ul>');
        $this->clickInlineToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item<br /><ul><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li></ul></li><li>third item</li></ul>');

        //Test unordered list with top toolbar icons
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item</li><li>first sub item %1%<ul><li>second sub item %2%</li><li>third sub item %3%</li></ul></li><li>third item</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item<br /><ul><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li></ul></li><li>third item</li></ul>');

        //Test ordered list with keyboard shortcuts
        $this->useTest(4);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item</li><li>first sub item %1%<ol><li>second sub item %2%</li><li>third sub item %3%</li></ol></li><li>third item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item<br /><ol><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li></ol></li><li>third item</li></ol>');

        //Test ordered list with inline toolbar icons
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item</li><li>first sub item %1%<ol><li>second sub item %2%</li><li>third sub item %3%</li></ol></li><li>third item</li></ol>');
        $this->clickInlineToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item<br /><ol><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li></ol></li><li>third item</li></ol>');

        //Test ordered list with top toolbar icons
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item</li><li>first sub item %1%<ol><li>second sub item %2%</li><li>third sub item %3%</li></ol></li><li>third item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item<br /><ol><li>first sub item %1%</li><li>second sub item %2%</li><li>third sub item %3%</li></ol></li><li>third item</li></ol>');

    }//end testOutdentAndIndentFirstItemInSubList()

}//end class

?>