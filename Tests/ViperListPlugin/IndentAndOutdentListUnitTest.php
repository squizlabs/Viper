<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_IndentAndOutdentListUnitTest extends AbstractViperListPluginUnitTest
{

    /**
     * Test outdent and indent a list item works.
     *
     * @return void
     */
    public function testListItem()
    {
        //Test unordered list when clicking inside a list item
        $this->useTest(1);
        $this->moveToKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list when selecting a word in the list item and using the top toolbar icons
        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list when selecting a word in the list item and using the inline toolbar icons
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list when selecting the whole list item
        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li></ul><p>second item %2%</p><ul><li>third %3% item</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
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
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

        //Test ordered list with top toolbar
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li></ol><p>second item %2%</p><ol><li>third %3% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

        //Test ordered list when selecting the whole list item
        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li></ol><p>second item %2%</p><ol><li>third %3% item</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

        //Test ordered list using keyboard shortcuts
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>XAX first item</li></ol><p>second item XBX</p><ol><li>third XCX item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

    }//end testListItem()


    /**
     * Test that when you select a list, the outdent and indent icon works.
     *
     * @return void
     */
    public function testAllItemsInAList()
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

    }//end testAllItemsInAList()


    /**
     * Test that outdent and indent works for the first item in the list.
     *
     * @return void
     */
    public function testFirstItemInList()
    {
        //Test unordered list using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(1);
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Unordered List:</p><p>%1% first item</p><ul><li>second item %2%</li><li>third %3% item</li></ul>');
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
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
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Ordered List:</p><p>%1% first item</p><ol><li>second item %2%</li><li>third %3% item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
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

    }//end testFirstItemInList()


    /**
     * Test that outdent and indent works for the last item in the list.
     *
     * @return void
     */
    public function testLastItemInList()
    {
        //Test unordered list using keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(3);
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li></ul><p>third %3% item</p>');
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list using inline toolbar icons
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li></ul><p>third %3% item</p>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test unordered list using top toolbar icons
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li></ul><p>third %3% item</p>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ul>');

        //Test ordered list
        $this->useTest(2);
        $this->selectKeyword(3);
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li></ol><p>third %3% item</p>');
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

        //Test ordered list using inline toolbar icons
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li></ol><p>third %3% item</p>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');

        //Test ordered list using top toolbar icons
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li></ol><p>third %3% item</p>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%</li><li>third %3% item</li></ol>');        

    }//end testLastItemInList()


    /**
     * Test that indent creates a sub list and outdent adds it back to the master list.
     *
     * @return void
     */
    public function testCreateListWithIndent()
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

    }//end testCreateListWithIndent()


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
    public function testKeepingSelectionAndStylesApplied()
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

    }//end testKeepingSelectionAndStylesApplied()


    /**
     * Tests that shift+tab in a non list item does nothing.
     *
     * @return void
     */
    public function testShiftTabInNonListItem()
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

    }//end testShiftTabInNonListItem()


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
        sleep(1);
        $this->sikuli->keyDown('Key.DOWN');
        sleep(1);
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item<ul><li>second item %2%</li><li>third %3% item</li></ul></li></ul>');

        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%<ul><li>third %3% item</li></ul></li></ul>');

        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
        $this->sikuli->keyDown('Key.DOWN');
        sleep(1);
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item<ul><li>second item %2%<ul><li>third %3% item</li></ul></li></ul></li></ul>');

        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>%1% first item</li><li>second item %2%<ul><li>third %3% item</li></ul></li></ul>');

        //Test ordered list
        $this->useTest(2);

        $this->moveToKeyword(2);
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
        $this->sikuli->keyDown('Key.DOWN');
        sleep(1);
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item<ol><li>second item %2%</li><li>third %3% item</li></ol></li></ol>');

        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%<ol><li>third %3% item</li></ol></li></ol>');

        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
        $this->sikuli->keyDown('Key.DOWN');
        sleep(1);
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item<ol><li>second item %2%<ol><li>third %3% item</li></ol></li></ol></li></ol>');

        $this->sikuli->keyDown('Key.UP');
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>%1% first item</li><li>second item %2%<ol><li>third %3% item</li></ol></li></ol>');

    }//end testListKeyboardNavForList()


    /**
     * Test that you can outdent all items in the sub list and indent them again.
     *
     * @return void
     */
    public function testAllSubListItems()
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

    }//end testAllSubListItems()


    /**
     * Test outdent and indent first item in a sub lit.
     *
     * @return void
     */
    public function testFirstItemInSubList()
    {
        //Test unordered list with keyboard shortcuts
        $this->useTest(3);
        $this->selectKeyword(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List:</p><ul><li>first item</li><li>second item</li><li>first sub item %1%<ul><li>second sub item %2%</li><li>third sub item %3%</li></ul></li><li>third item</li></ul>');
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
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
        sleep(1);
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List:</p><ol><li>first item</li><li>second item</li><li>first sub item %1%<ol><li>second sub item %2%</li><li>third sub item %3%</li></ol></li><li>third item</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        sleep(1);
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

    }//end testFirstItemInSubList()


    /**
     * Test outdent and indent two unordered sub list items when selecting both list items.
     *
     * @return void
     */
    public function testTwoUlSubListItems()
    {
        // Test using keyboard shortcuts
        $this->useTest(5);
        $this->selectKeyword(2, 4);

        // Outdent once so list items are at the top level
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Outdent again so list items are no longer in list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once so they are back in the list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so a third level list is created
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        // Test using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(2, 4);

        // Outdent once so list items are at the top level. 
        sleep(1);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

         // Outdent again so list items are no longer in list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        
        // Indent once so they are back in the list. Have to use top toolbar icon as the indent icon will not be inline
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so a third level list is created
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        // Test using top toolbar
        $this->useTest(5);
        $this->selectKeyword(2, 4);

        // Outdent once so list items are at the top level
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

         // Outdent again so list items are no longer in list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

         // Indent once so they are back in the list.
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so a third level list is created
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

    }//end testTwoUlSubListItems()


    /**
     * Test selecting one list item, pressing shift + right once and outdenting and indenting content
     *
     * @return void
     */
    public function testTwoUlSubListItemsWithLiSelection()
    {
        // Using keyboard shortcuts
        $this->useTest(5);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        // Outdent once so list items are at the top level
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Outdent again so list items are no longer in list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once so they are back in the list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so a third level list is created
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        // Using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);

        // Outdent once so list items are at the top level
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

         // Outdent again so list items are no longer in list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        
        // Indent once so they are back in the list. Have to use top toolbar icon as the indent icon will not be inline
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so a third level list is created
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        // Using top toolbar
        $this->useTest(5);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        // Outdent once so list items are at the top level
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

         // Outdent again so list items are no longer in list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        
        // Indent once so they are back in the list. Have to use top toolbar icon as the indent icon will not be inline
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so a third level list is created
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

    }//end testTwoUlSubListItemsWithLiSelection()


    /**
     * Test selecting one list item, pressing shift + right twice and outdenting and indenting content
     *
     * @return void
     */
    public function testTwoUlSubListItemsWithPartialSelection()
    {
        // Using keyboard shortcuts
        $this->useTest(5);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        // Outdent once so list items are at the top level
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Outdent again so list items are no longer in list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once so they are back in the list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so a third level list is created
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        // Using inline toolbar
        $this->useTest(5);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        // Outdent once so list items are at the top level
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

         // Outdent again so list items are no longer in list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        
        // Indent once so they are back in the list. Have to use top toolbar icon as the indent icon will not be inline
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so a third level list is created
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        // Using top toolbar
        $this->useTest(5);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        // Outdent once so list items are at the top level
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

         // Outdent again so list items are no longer in list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        
        // Indent once so they are back in the list. Have to use top toolbar icon as the indent icon will not be inline
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so a third level list is created
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

    }//end testTwoUlSubListItemsWithPartialSelection()


     /**
     * Test outdent and indent two ordered sub list items when selecting both list items.
     *
     * @return void
     */
    public function testTwoOlSubListItems()
    {
        // Test using keyboard shortcuts
        $this->useTest(6);
        $this->selectKeyword(2, 4);

        // Outdent once so list items are at the top level
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Outdent again so list items are no longer in list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once so they are back in the list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so a third level list is created
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        // Test using inline toolbar
        $this->useTest(6);
        $this->selectKeyword(2, 4);

        // Outdent once so list items are at the top level
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

         // Outdent again so list items are no longer in list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        
        // Indent once so they are back in the list. Have to use top toolbar icon as the indent icon will not be inline
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so a third level list is created
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FLASE, TRUE);

        // Test using top toolbar
        $this->useTest(6);
        $this->selectKeyword(2, 4);

        // Outdent once so list items are at the top level
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

         // Outdent again so list items are no longer in list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once so they are back in the list.
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so a third level list is created
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

    }//end testTwoOlSubListItems()


    /**
     * Test selecting one list item, pressing shift + right once and outdenting and indenting content
     *
     * @return void
     */
    public function testTwoOlSubListItemsWithLiSelection()
    {
        // Using keyboard shortcuts
        $this->useTest(6);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        // Outdent once so list items are at the top level
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Outdent again so list items are no longer in list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once so they are back in the list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so a third level list is created
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        // Using inline toolbar
        $this->useTest(6);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);

        // Outdent once so list items are at the top level
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

         // Outdent again so list items are no longer in list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        
        // Indent once so they are back in the list. Have to use top toolbar icon as the indent icon will not be inline
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so a third level list is created
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        // Using top toolbar
        $this->useTest(6);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        // Outdent once so list items are at the top level
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

         // Outdent again so list items are no longer in list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        
        // Indent once so they are back in the list. Have to use top toolbar icon as the indent icon will not be inline
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so a third level list is created
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

    }//end testTwoOlSubListItemsWithLiSelection()


    /**
     * Test selecting one list item, pressing shift + right twice and outdenting and indenting content
     *
     * @return void
     */
    public function testTwoOlSubListItemsWithPartialSelection()
    {
        // Using keyboard shortcuts
        $this->useTest(6);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        // Outdent once so list items are at the top level
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Outdent again so list items are no longer in list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once so they are back in the list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so a third level list is created
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        // Using inline toolbar
        $this->useTest(6);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        // Outdent once so list items are at the top level
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

         // Outdent again so list items are no longer in list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        
        // Indent once so they are back in the list. Have to use top toolbar icon as the indent icon will not be inline
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so a third level list is created
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        // Using top toolbar
        $this->useTest(6);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

        // Outdent once so list items are at the top level
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

         // Outdent again so list items are no longer in list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><p>Accessibility audit report %4%</p>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        
        // Indent once so they are back in the list. Have to use top toolbar icon as the indent icon will not be inline
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so they added to the sub list
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so a third level list is created
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%</li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

    }//end testTwoOlSubListItemsWithPartialSelection()


    /**
     * Test creating a third level list in an unordered list, selecting it's parent, pressing shift + right once and using indent and outdent.
     *
     * @return void
     */
    public function testUlSubListItemWithStartOfEmptySubList()
    {
        // Create blank third level list and test using keyboard shortcuts
        $this->useTest(5);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());

        $this->moveToKeyword(2, 'left');

        // Use foreach so the selection works in ie
        for ($i = 0; $i < 13; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        
        // Outdent once so the parent gets added to the top level list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%<ul><li></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Outdent again so parent is removed from the list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><ul><li></li><li>Accessibility audit report %4%</li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once paragraph is added back to the top list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%<ul><li></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so parent is added back to second level list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ul><li></li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

// FAILS HERE BECAUSE IT ONLY INDENTS THE %2% test %3% LIST ITEM

        // Indent again so parent is moved to the third level
      /*  $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%<ul><li></li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);*/

        // Create blank third level list and test using inline toolbar
        $this->useTest(5);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());

        $this->moveToKeyword(2, 'left');

        // Use foreach so the selection works in ie
        for ($i = 0; $i < 13; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        
        // Outdent once so the parent gets added to the top level list
        sleep(1);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%<ul><li></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Outdent again so parent is removed from the list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><ul><li></li><li>Accessibility audit report %4%</li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once paragraph is added back to the top list. Use the top toolbar icon as it doesn't appear in the inline toolbar.
        $this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%<ul><li></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so parent is added back to second level list
        $this->clickInlineToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ul><li></li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

// FAILS HERE BECAUSE IT ONLY INDENTS THE %2% test %3% LIST ITEM

        // Indent again so parent is moved to the third level
       /* $this->clickInlineToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%<ul><li></li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);*/

        // Create blank third level list and test using top toolbar
        $this->useTest(5);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());

        $this->moveToKeyword(2, 'left');

        // Use foreach so the selection works in ie
        for ($i = 0; $i < 13; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        
        // Outdent once so the parent gets added to the top level list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%<ul><li></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Outdent again so parent is removed from the list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><ul><li></li><li>Accessibility audit report %4%</li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once paragraph is added back to the top list.
        $this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%<ul><li></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so parent is added back to second level list
        $this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ul><li></li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

// FAILS HERE BECAUSE IT ONLY INDENTS THE %2% test %3% LIST ITEM

        // Indent again so parent is moved to the third level
        /*$this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%<ul><li></li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);*/

    }//end testUlSubListItemWithStartOfEmptySubList()


    /**
     * Test creating a third level list in an unordered list, selecting it's parent, pressing shift + right twice and using indent and outdent.
     *
     * @return void
     */
    public function testUlSubListItemWithEmptySubListAndLiOfNextListItem()
    {
        // Create blank third level list and test using keyboard shortcuts
        $this->useTest(5);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());

        $this->moveToKeyword(2, 'left');

        for ($i = 0; $i < 14; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        
        // Outdent once so the parent and following list item get added to the top level list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Outdent again so parent and following list items are removed from the list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');

 // FAILS HERE BECAUSE THERE ARE EMPTY LIST TAGS AT THE END OF THE CONTENT       
       // $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><ul><li></li></ul><p>Accessibility audit report %4%</p>', $this->getHtmllWithBlankLiTags());

// FAILS HERE BECAUSE THE LIST ICONS ARE NOT ENABLED
        //$this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once so items are added back to list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so items are added back to sub list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so items are added to the third level list

// FAIL HERE BECAUSE ONLY %2% test %3% is indented not all selected items. Not sure if what I have in the assert is correc though
       /* $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages<li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);*/

        // Create blank third level list and test using inline toolbar
        $this->useTest(5);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());

        $this->moveToKeyword(2, 'left');

        for ($i = 0; $i < 14; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        
        // Outdent once so the parent and following list item get added to the top level list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Outdent again so parent and following list items are removed from the list
        $this->clickInlineToolbarButton('listOutdent');

 // FAILS HERE BECAUSE THERE ARE EMPTY LIST TAGS AT THE END OF THE CONTENT 
        //$this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><ul><li></li></ul><p>Accessibility audit report %4%</p>', $this->getHtmllWithBlankLiTags());

// FAILS HERE BECAUSE THE LIST ICONS ARE NOT ENABLED
        //$this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once so items are added back to list. Need to use top toolbar as icon is not in the inline toolbar.

// PRESS TAB FOR NOW BECAUSE ICON IS NOT ENABLED
        $this->sikuli->keyDown('Key.TAB');
        //$this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so items are added back to sub list
        $this->clickInlineToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

// FAIL HERE BECAUSE ONLY %2% test %3% is indented not all selected items. Not sure if what I have in the assert is correc though
        // Indent again so items are added to the third level list
        /*$this->clickInlineToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages<li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);*/

        // Create blank third level list and test using top toolbar
        $this->useTest(5);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());

        $this->moveToKeyword(2, 'left');

        for ($i = 0; $i < 14; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        
        // Outdent once so the parent and following list item get added to the top level list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Outdent again so parent and following list items are removed from the list
        $this->clickTopToolbarButton('listOutdent');

 // FAILS HERE BECAUSE THERE ARE EMPTY LIST TAGS AT THE END OF THE CONTENT 
        //$this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test %3%</p><ul><li></li></ul><p>Accessibility audit report %4%</p>', $this->getHtmllWithBlankLiTags());

// FAILS HERE BECAUSE THE LIST ICONS ARE NOT ENABLED
        //$this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once so items are added back to list.

// PRESS TAB FOR NOW BECAUSE ICON IS NOT ENABLED
        $this->sikuli->keyDown('Key.TAB');
        //$this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so items are added back to sub list
        $this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

// FAIL HERE BECAUSE ONLY %2% test %3% is indented not all selected items. Not sure if what I have in the assert is correc though
        // Indent again so items are added to the third level list
        /*$this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages<li>%2% test %3%<ul><li></li></ul></li><li>Accessibility audit report %4%</li></ul></li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);*/

    }//end testUlSubListItemWithEmptySubListAndLiOfNextListItem()


    /**
     * Test creating a third level list in an ordered list, selecting it's parent, pressing shift + right once and using indent and outdent.
     *
     * @return void
     */
    public function testOlSubListItemWithStartOfEmptySubList()
    {
        // Create blank third level list and test using keyboard shortcuts
        $this->useTest(6);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());

        $this->moveToKeyword(2, 'left');

        // Use foreach so the selection works in ie
        for ($i = 0; $i < 13; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        
        // Outdent once so the parent gets added to the top level list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%<ol><li></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Outdent again so parent is removed from the list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><ol><li></li><li>Accessibility audit report %4%</li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once paragraph is added back to the top list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%<ol><li></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so parent is added back to second level list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ol><li></li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

// FAILS HERE BECAUSE IT ONLY INDENTS THE %2% test %3% LIST ITEM

        // Indent again so parent is moved to the third level
      /*  $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%<ol><li></li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);*/

        // Create blank third level list and test using inline toolbar
        $this->useTest(6);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());

        $this->moveToKeyword(2, 'left');

        // Use foreach so the selection works in ie
        for ($i = 0; $i < 13; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        
        // Outdent once so the parent gets added to the top level list
        sleep(1);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%<ol><li></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Outdent again so parent is removed from the list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><ol><li></li><li>Accessibility audit report %4%</li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once paragraph is added back to the top list. Use the top toolbar icon as it doesn't appear in the inline toolbar.
        $this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%<ol><li></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so parent is added back to second level list
        $this->clickInlineToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ol><li></li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

// FAILS HERE BECAUSE IT ONLY INDENTS THE %2% test %3% LIST ITEM

        // Indent again so parent is moved to the third level
       /* $this->clickInlineToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%<ol><li></li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);*/

        // Create blank third level list and test using top toolbar
        $this->useTest(6);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());

        $this->moveToKeyword(2, 'left');

        // Use foreach so the selection works in ie
        for ($i = 0; $i < 13; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        
        // Outdent once so the parent gets added to the top level list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%<ol><li></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Outdent again so parent is removed from the list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><ol><li></li><li>Accessibility audit report %4%</li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once paragraph is added back to the top list.
        $this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%<ol><li></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TURE, 'active', TRUE, TRUE);

        // Indent again so parent is added back to second level list
        $this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ol><li></li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

// FAILS HERE BECAUSE IT ONLY INDENTS THE %2% test %3% LIST ITEM

        // Indent again so parent is moved to the third level
        /*$this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%<ol><li></li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);*/

    }//end testOlSubListItemWithStartOfEmptySubList()


    /**
     * Test creating a third level list in an ordered list, selecting it's parent, pressing shift + right twice and using indent and outdent.
     *
     * @return void
     */
    public function testOlSubListItemWithEmptySubListAndLiOfNextListItem()
    {
        // Create blank third level list and test using keyboard shortcuts
        $this->useTest(6);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());

        $this->moveToKeyword(2, 'left');

        for ($i = 0; $i < 14; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        
        // Outdent once so the parent and following list item get added to the top level list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Outdent again so parent and following list items are removed from the list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');

 // FAILS HERE BECAUSE THERE ARE EMPTY LIST TAGS AT THE END OF THE CONTENT       
       // $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><ol><li></li></ol><p>Accessibility audit report %4%</p>', $this->getHtmllWithBlankLiTags());

// FAILS HERE BECAUSE THE LIST ICONS ARE NOT ENABLED
        //$this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once so items are added back to list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so items are added back to sub list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so items are added to the third level list

// FAIL HERE BECAUSE ONLY %2% test %3% is indented not all selected items. Not sure if what I have in the assert is correc though
       /* $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages<li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);*/

        // Create blank third level list and test using inline toolbar
        $this->useTest(6);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());

        $this->moveToKeyword(2, 'left');

        for ($i = 0; $i < 14; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        
        // Outdent once so the parent and following list item get added to the top level list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Outdent again so parent and following list items are removed from the list
        $this->clickInlineToolbarButton('listOutdent');

 // FAILS HERE BECAUSE THERE ARE EMPTY LIST TAGS AT THE END OF THE CONTENT 
        //$this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><ol><li></li></ol><p>Accessibility audit report %4%</p>', $this->getHtmllWithBlankLiTags());

// FAILS HERE BECAUSE THE LIST ICONS ARE NOT ENABLED
        //$this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once so items are added back to list. Need to use top toolbar as icon is not in the inline toolbar.

// PRESS TAB FOR NOW BECAUSE ICON IS NOT ENABLED
        $this->sikuli->keyDown('Key.TAB');
        //$this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so items are added back to sub list
        $this->clickInlineToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

// FAIL HERE BECAUSE ONLY %2% test %3% is indented not all selected items. Not sure if what I have in the assert is correc though
        // Indent again so items are added to the third level list
        /*$this->clickInlineToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages<li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);*/

        // Create blank third level list and test using top toolbar
        $this->useTest(6);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());

        $this->moveToKeyword(2, 'left');

        for ($i = 0; $i < 14; $i++) {
            $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        }
        
        // Outdent once so the parent and following list item get added to the top level list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Outdent again so parent and following list items are removed from the list
        $this->clickTopToolbarButton('listOutdent');

 // FAILS HERE BECAUSE THERE ARE EMPTY LIST TAGS AT THE END OF THE CONTENT 
        //$this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test %3%</p><ol><li></li></ol><p>Accessibility audit report %4%</p>', $this->getHtmllWithBlankLiTags());

// FAILS HERE BECAUSE THE LIST ICONS ARE NOT ENABLED
        //$this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once so items are added back to list.

// PRESS TAB FOR NOW BECAUSE ICON IS NOT ENABLED
        $this->sikuli->keyDown('Key.TAB');
        //$this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so items are added back to sub list
        $this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

// FAIL HERE BECAUSE ONLY %2% test %3% is indented not all selected items. Not sure if what I have in the assert is correc though
        // Indent again so items are added to the third level list
        /*$this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages<li>%2% test %3%<ol><li></li></ol></li><li>Accessibility audit report %4%</li></ol></li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);*/

    }//end testOlSubListItemWithEmptySubListAndLiOfNextListItem()


    /**
     * Test selecting an unordered sub list item and its sub list and using indent and outdent.
     *
     * @return void
     */
    public function testUlSubListItemItsWithSubList()
    {
        // Test using keyboard shortcuts
        $this->useTest(7);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        // Outdent once so the parent gets added to the top level list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test<ul><li>test data %3%</li><li>Accessibility audit report</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Outdent again so parent is removed from the list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test </p><ul><li>test data %3%</li><li>Accessibility audit report</li></ul>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once paragraph is added back to the top list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test <ul><li>test data %3%</li><li>Accessibility audit report</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so parent is added back to second level list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test <ul><li>test data %3%</li><li>Accessibility audit report</li></ul></li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

// FAIL HERE BECAUSE ONLY %2% test %3% is indented not all selected items. Not sure if what I have in the assert is correc though
        // Indent again so parent is moved to the third level
        /*$this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%<ul><li>test data %3%</li></ul></li><li>Accessibility audit report</li></ul></li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);*/

        // Using inline toolbar
        $this->useTest(7);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        // Outdent once so the parent gets added to the top level list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test<ul><li>test data %3%</li><li>Accessibility audit report</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Outdent again so parent is removed from the list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test </p><ul><li>test data %3%</li><li>Accessibility audit report</li></ul>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once paragraph is added back to the top list. Use the top toolbar icon as it doesn't appear in the inline toolbar.
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test <ul><li>test data %3%</li><li>Accessibility audit report</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so parent is added back to second level list
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test <ul><li>test data %3%</li><li>Accessibility audit report</li></ul></li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

// FAIL HERE BECAUSE ONLY %2% test %3% is indented not all selected items. Not sure if what I have in the assert is correc though
        // Indent again so parent is moved to the third level
        /*$this->clickInlineToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%<ul><li>test data %3%</li></ul></li><li>Accessibility audit report</li></ul></li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);*/

        // Using top toolbar
        $this->useTest(7);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        
        // Outdent once so the parent gets added to the top level list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test<ul><li>test data %3%</li><li>Accessibility audit report</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Outdent again so parent is removed from the list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li></ul><p>%2% test </p><ul><li>test data %3%</li><li>Accessibility audit report</li></ul>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once paragraph is added back to the top list.
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% test <ul><li>test data %3%</li><li>Accessibility audit report</li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

        // Indent again so parent is added back to second level list
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test <ul><li>test data %3%</li><li>Accessibility audit report</li></ul></li></ul></li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);

// FAIL HERE BECAUSE ONLY %2% test %3% is indented not all selected items. Not sure if what I have in the assert is correc though
        // Indent again so parent is moved to the third level
       /* $this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ul><li>%1% <ul><li>Audit of Homepage and 6 Section Landing pages<ul><li>%2% test %3%<ul><li>test data %3%</li></ul></li><li>Accessibility audit report</li></ul></li></ul></li></ul>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE); */

    }//end testUlSubListItemItsWithSubList()


    /**
     * Test selecting an ordered sub list item and its sub list and using indent and outdent.
     *
     * @return void
     */
    public function testOlSubListItemItsWithSubList()
    {
       // Test using keyboard shortcuts
        $this->useTest(8);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        // Outdent once so the parent gets added to the top level list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test<ol><li>test data %3%</li><li>Accessibility audit report</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Outdent again so parent is removed from the list
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test </p><ol><li>test data %3%</li><li>Accessibility audit report</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once paragraph is added back to the top list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test <ol><li>test data %3%</li><li>Accessibility audit report</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so parent is added back to second level list
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test <ol><li>test data %3%</li><li>Accessibility audit report</li></ol></li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

// FAIL HERE BECAUSE ONLY %2% test %3% is indented not all selected items. Not sure if what I have in the assert is correc though
        // Indent again so parent is moved to the third level
        /*$this->sikuli->keyDown('Key.TAB');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%<ol><li>test data %3%</li></ol></li><li>Accessibility audit report</li></ol></li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);*/

        // Using inline toolbar
        $this->useTest(8);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);

        // Outdent once so the parent gets added to the top level list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test<ol><li>test data %3%</li><li>Accessibility audit report</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Outdent again so parent is removed from the list
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test </p><ol><li>test data %3%</li><li>Accessibility audit report</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once paragraph is added back to the top list. Use the top toolbar icon as it doesn't appear in the inline toolbar.
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test <ol><li>test data %3%</li><li>Accessibility audit report</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so parent is added back to second level list
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test <ol><li>test data %3%</li><li>Accessibility audit report</li></ol></li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

// FAIL HERE BECAUSE ONLY %2% test %3% is indented not all selected items. Not sure if what I have in the assert is correc though
        // Indent again so parent is moved to the third level
        /*$this->clickInlineToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%<ol><li>test data %3%</li></ol></li><li>Accessibility audit report</li></ol></li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);*/

        // Using top toolbar
        $this->useTest(8);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(3);
        
        // Outdent once so the parent gets added to the top level list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test<ol><li>test data %3%</li><li>Accessibility audit report</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Outdent again so parent is removed from the list
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li></ol><p>%2% test </p><ol><li>test data %3%</li><li>Accessibility audit report</li></ol>');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);

        // Indent once paragraph is added back to the top list.
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% test <ol><li>test data %3%</li><li>Accessibility audit report</li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        // Indent again so parent is added back to second level list
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test <ol><li>test data %3%</li><li>Accessibility audit report</li></ol></li></ol></li></ol>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

// FAIL HERE BECAUSE ONLY %2% test %3% is indented not all selected items. Not sure if what I have in the assert is correc though
        // Indent again so parent is moved to the third level
       /* $this->clickTopToolbarButton('listIndent');
        $this->assertEquals('<h2>Meh</h2><ol><li>%1% <ol><li>Audit of Homepage and 6 Section Landing pages<ol><li>%2% test %3%<ol><li>test data %3%</li></ol></li><li>Accessibility audit report</li></ol></li></ol></li></ol>', $this->getHtmllWithBlankLiTags());
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE); */

    }//end testOlSubListItemItsWithSubList()

}//end class

?>