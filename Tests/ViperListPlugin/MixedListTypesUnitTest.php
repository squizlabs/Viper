<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_MixedListTypesUnitTest extends AbstractViperListPluginUnitTest
{


	/**
     * Test adding a new list item to the parent list
     *
     * @return void
     */
    public function testAddingNewItemsToParentList()
    {
        //Test unordered list
        $this->useTest(1);
        $this->moveToKeyword(1, 'right');
		$this->sikuli->keyDown('Key.ENTER');
		$this->type('new item');
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('third item');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%</li><li>new item<ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li><li>third item</li></ul>');

        //Test ordered list
        $this->useTest(2);
        $this->moveToKeyword(1, 'right');
		$this->sikuli->keyDown('Key.ENTER');
		$this->type('new item');
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('third item');
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%</li><li>new item<ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li><li>third item</li></ol>');

    }//end testAddingNewItemsToParentList()


    /**
     * Test adding a new list item to the sub list
     *
     * @return void
     */
    public function testAddingNewItemsToSubList()
    {
        //Test unordered list
        $this->useTest(1);
        $this->moveToKeyword(2, 'right');
		$this->sikuli->keyDown('Key.ENTER');
		$this->type('new item');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li><li>new item</li></ol></li><li>second item %3%</li></ul>');

        //Test ordered list
        $this->useTest(2);
        $this->moveToKeyword(2, 'right');
		$this->sikuli->keyDown('Key.ENTER');
		$this->type('new item');
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li><li>new item</li></ul></li><li>second item %3%</li></ol>');

    }//end testAddingNewItemsToSubList()


	/**
     * Test that when you indent and outdent an item in the sub list, it remains the sub list list type.
     *
     * @return void
     */
    public function testIndentAndOutdentSubListItem()
    {
        //Test ordered sub list with keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(2);
		$this->sikuli->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item<ol><li>second sub item %2%</li></ol></li></ol></li><li>second item %3%</li></ul>');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul>');

        //Test ordered sub list with inline toolbar icons
        $this->clickInlineToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item<ol><li>second sub item %2%</li></ol></li></ol></li><li>second item %3%</li></ul>');
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul>');

        //Test ordered sub list with top toolbar icons
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item<ol><li>second sub item %2%</li></ol></li></ol></li><li>second item %3%</li></ul>');
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul>');

        //Test unordered sub list with keyboard shortcuts
        $this->useTest(2);
        $this->selectKeyword(2);
		$this->sikuli->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item<ul><li>second sub item %2%</li></ul></li></ul></li><li>second item %3%</li></ol>');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ol>');

        //Test unordered sub list with inline toolbar icons
        $this->clickInlineToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item<ul><li>second sub item %2%</li></ul></li></ul></li><li>second item %3%</li></ol>');
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ol>');

        //Test unordered sub list with top toolbar icons
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item<ul><li>second sub item %2%</li></ul></li></ul></li><li>second item %3%</li></ol>');
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ol>');

    }//end testIndentAndOutdentSubListItem()


	/**
     * Test that when you outdent and indent an item in the sub list, it changes to the parent type and back again.
     *
     * @return void
     */
    public function testOutdentAndIndentSubListItem()
    {
        //Test ordered sub list with keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
		$this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li></ol></li><li>second sub item %2%</li><li>second item %3%</li></ul>');
		$this->sikuli->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul>');

        //Test ordered sub list with inline toolbar icons
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li></ol></li><li>second sub item %2%</li><li>second item %3%</li></ul>');
        $this->clickInlineToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul>');

        //Test ordered sub list with top toolbar icons
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li></ol></li><li>second sub item %2%</li><li>second item %3%</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul>');

        //Test unordered sub list with keyboard shortcuts
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
		$this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li></ul></li><li>second sub item %2%</li><li>second item %3%</li></ol>');
		$this->sikuli->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ol>');

        //Test unordered sub list with inline toolbar icons
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li></ul></li><li>second sub item %2%</li><li>second item %3%</li></ol>');
        $this->clickInlineToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ol>');

        //Test unordered sub list with top toolbar icons
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li></ul></li><li>second sub item %2%</li><li>second item %3%</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ol>');

    }//end testOutdentAndIndentSubListItem()


    /**
     * Test that you can remove an item from the list using the list icon and then add it back to the sub list by clicking the same list icon again.
     *
     * @return void
     */
    public function testRemovingAnItemFromTheSubListAndAddingItBackUsingTheSameListIcon()
    {
        //Test ordered sub list with top toolbar icon
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->selectKeyword(2);
        sleep(1);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li></ol><p>second sub item %2%</p></li><li>second item %3%</li></ul>');
        $this->clickTopToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul>');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);

        //Test ordered sub list with inline toolbar icon
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li></ol><p>second sub item %2%</p></li><li>second item %3%</li></ul>');
        $this->clickInlineToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul>');

        //Test unordered sub list with top toolbar icon
        $this->useTest(2);
        $this->selectKeyword(2);
        sleep(1);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item XAX<br /><ul><li>first sub item</li></ul><p>second sub item XBX</p></li><li>second item XCX</li></ol>');
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ol>');

        //Test unordered sub list with inline toolbar icon
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item XAX<br /><ul><li>first sub item</li></ul><p>second sub item XBX</p></li><li>second item XCX</li></ol>');
        $this->clickInlineToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ol>');

    }//end testRemovingAnItemFromTheSubListAndAddingItBackUsingTheSameListIcon()


    /**
     * Test that you can remove an item from the list using the list icon and then add create another sub list using the different list type.
     *
     * @return void
     */
    public function testRemovingAnItemFromTheSubListUsingTheListIconAndCreatingANewSubListWithANewListType()
    {
        //Test ordered sub list with top toolbar icon
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li></ol><p>second sub item %2%</p></li><li>second item %3%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li></ol><ul><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul>');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);

        //Test ordered sub list with inline toolbar icon
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li></ol><p>second sub item %2%</p></li><li>second item %3%</li></ul>');
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li></ol><ul><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul>');

        //Test unordered sub list with top toolbar icon
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li></ul><p>second sub item %2%</p></li><li>second item %3%</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li></ul><ol><li>second sub item %2%</li></ol></li><li>second item %3%</li></ol>');

        //Test unordered sub list with inline toolbar icon
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li></ul><p>second sub item %2%</p></li><li>second item %3%</li></ol>');
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li></ul><ol><li>second sub item %2%</li></ol></li><li>second item %3%</li></ol>');

    }//end testRemovingAnItemFromTheSubListUsingTheListIconAndCreatingANewSubListWithANewListType()


	/**
     * Test that when you outdent all items in the sub list and indent them again, it uses the parent list type.
     *
     * @return void
     */
    public function testOutdentAllSubListItemsAndIndentAgain()
    {
        //Test ordered sub list with keyboard shortcuts
        $this->useTest(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%</li><li>first sub item</li><li>second sub item %2%</li><li>second item %3%</li></ul>');
		$this->sikuli->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul>');

        //Test ordered sub list with inline toolbar icons
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%</li><li>first sub item</li><li>second sub item %2%</li><li>second item %3%</li></ul>');
        $this->clickInlineToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul>');

        //Test ordered sub list with top toolbar icons
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%</li><li>first sub item</li><li>second sub item %2%</li><li>second item %3%</li></ul>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul>');

        //Test unordered sub list with keyboard shortcuts
        $this->useTest(2);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%</li><li>first sub item</li><li>second sub item %2%</li><li>second item %3%</li></ol>');
		$this->sikuli->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ol>');

        //Test unordered sub list with inline toolbar icons
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%</li><li>first sub item</li><li>second sub item %2%</li><li>second item %3%</li></ol>');
        $this->clickInlineToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ol>');

        //Test unordered sub list with top toolbar icons
        $this->clickTopToolbarButton('listOutdent');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%</li><li>first sub item</li><li>second sub item %2%</li><li>second item %3%</li></ol>');
        $this->clickTopToolbarButton('listIndent');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ol>');

    }//end testOutdentAllSubListItemsAndIndentAgain()


    /**
     * Test that when you can remove all items from the sub list and re-create the sub list using the list icons.
     *
     * @return void
     */
    public function testRemoveAllSubListItemsAndAddItBackAgainUsingListIcons()
    {
        //Test ordered sub list with inline toolbar icons
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><p>first sub item</p><p>second sub item %2%</p></li><li>second item %3%</li></ul>');
        $this->clickInlineToolbarButton('listOL');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul>');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);

        //Test ordered sub list with top toolbar icons
        $this->clickTopToolbarButton('listOL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><p>first sub item</p><p>second sub item %2%</p></li><li>second item %3%</li></ul>');
        $this->clickTopToolbarButton('listOL');
        $this->assertIconStatusesCorrect(TRUE, 'active', FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul>');

        //Test unordered sub list with inline toolbar icons
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, FALSE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><p>first sub item</p><p>second sub item %2%</p></li><li>second item %3%</li></ol>');
        $this->clickInlineToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ol>');

        //Test unordered sub list with top toolbar icons
        $this->clickTopToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect(TRUE, 'active', TRUE, FALSE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><p>first sub item</p><p>second sub item %2%</p></li><li>second item %3%</li></ol>');
        $this->clickTopToolbarButton('listUL');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ol>');

    }//end testRemoveAllSubListItemsAndAddItBackAgainUsingListIcons()


    /**
     * Test that when you can remove all items from the sub list using the list icon and create a new sub list using the parent list type by pressing tab.
     *
     * @return void
     */
    public function testRemoveAllSubListItemsUsingListIconsAndCreatingNewSubListByPressingTab()
    {
        //Test ordered sub list
        $this->useTest(1);
        $this->moveToKeyword(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('listOL', 'active');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><p>first sub item</p><p>second sub item %2%</p></li><li>second item %3%</li></ul>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul>');

        //Test unordered sub list
        $this->useTest(2);
        $this->moveToKeyword(1);
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('listUL', 'active');
        $this->assertIconStatusesCorrect('active', TRUE, TRUE, FALSE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><p>first sub item</p><p>second sub item %2%</p></li><li>second item %3%</li></ol>');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
        $this->assertHTMLMatch('<p>Ordered List with unordered sub list:</p><ol><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ol>');

    }//end testRemoveAllSubListItemsUsingListIconsAndCreatingNewSubListByPressingTab()


    /**
     * Test outdent multiple items and then indent a single item within a unordered parent and ordered sub list.
     *
     * @return void
     */
    public function testOutdentAndIndentOrderedListItemWithinUnorderedListItem()
    {
        // Test right once
        // Test using keyboard shortcuts
        $this->useTest(3);
        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul>');

        sleep(3);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol></li></ul>');

        // Test using top toolbar
        $this->useTest(3);
        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul>');

        sleep(1);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol></li></ul>');

        // Test using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(2,3);
        sleep(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(3);
        $this->clickInlineToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul>');

        sleep(1);
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol></li></ul>');
    
        // Test right twice
        // Test using keyboard shortcuts
        $this->useTest(3);
        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul>');

        sleep(3);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol></li></ul>');

        // Test using top toolbar
        $this->useTest(3);
        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul>');

        sleep(1);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol></li></ul>');

        // Test using inline toolbar
        $this->useTest(3);
        $this->selectKeyword(2,3);
        sleep(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(3);
        $this->clickInlineToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul>');

        sleep(1);
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol></li></ul>');
    }//end testOutdentAndIndentOrderedListItemWithinUnorderedListItem()


    /**
     * Test outdent multiple items and then indent a single item within a ordered parent and unordered sub list.
     *
     * @return void
     */
    public function testOutdentAndIndentUnorderedListItemWithinOrderedListItem()
    {
        // Test right once
        // Test using keyboard shortcuts
        $this->useTest(4);
        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol>');

        sleep(1);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul></li></ol>');

        // Test using top toolbar
        $this->useTest(4);
        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol>');

        sleep(1);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul></li></ol>');

        // Test using inline toolbar
        $this->useTest(4);
        $this->selectKeyword(2,3);
        sleep(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(3);
        $this->clickInlineToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol>');

        sleep(1);
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul></li></ol>');
    
        // Test right twice
        // Test using keyboard shortcuts
        $this->useTest(4);
        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(1);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol>');

        sleep(1);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul></li></ol>');

        // Test using top toolbar
        $this->useTest(4);
        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol>');

        sleep(1);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul></li></ol>');

        // Test using inline toolbar
        $this->useTest(4);
        $this->selectKeyword(2,3);
        sleep(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(3);
        $this->clickInlineToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol>');

        sleep(1);
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul></li></ol>');
    }//end testOutdentAndIndentOrderedListItemWithinUnorderedListItem()


    /**
     * Test outdent multiple items and then indent a single item within a ordered parent and unordered sub list.
     *
     * @return void
     */
    public function testAddingNewListItemThenIndentAndOutdentOrderedParentList()
    {
        // Test using keyboard shortcuts
        $this->useTest(3);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol></li></ul>');

        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% additional %3%<ol><li>Accessibility audit report</li></ol></li></ul>');

        sleep(1);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% additional %3%<ol><li>Accessibility audit report</li></ol></li></ul>');

        // Test using top toolbar
        $this->useTest(3);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol></li></ul>');

        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% additional %3%<ol><li>Accessibility audit report</li></ol></li></ul>');

        sleep(1);
        $this->selectKeyword(2,3);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%<ol><li>Accessibility audit report</li></ol></li></ol></li></ul>');

        // Test using inline toolbar
        $this->useTest(3);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol></li></ul>');

        $this->selectKeyword(2,3);
        sleep(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(3);
        $this->clickInlineToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% additional %3%<ol><li>Accessibility audit report</li></ol></li></ul>');

        sleep(1);
        $this->selectKeyword(2,3);
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%<ol><li>Accessibility audit report</li></ol></li></ol></li></ul>');

        // Test using keyboard shortcuts
        $this->useTest(3);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol></li></ul>');

        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% additional %3%</li></ul><p>Accessibility audit report</p>');

        sleep(1);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li></ol></li></ul><p>Accessibility audit report</p>');

        // Test using top toolbar
        $this->useTest(3);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol></li></ul>');

        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% additional %3%</li></ul><p>Accessibility audit report</p>');

        sleep(1);
        $this->selectKeyword(2,3);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li></ol></li></ul><p>Accessibility audit report</p>');

        // Test using inline toolbar
        $this->useTest(3);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ol></li></ul>');

        $this->selectKeyword(2,3);
        sleep(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(3);
        $this->clickInlineToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li></ol></li><li>%2% additional %3%</li></ul><p>Accessibility audit report</p>');

        sleep(1);
        $this->selectKeyword(2,3);
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ul><li>%1%<ol><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li></ol></li></ul><p>Accessibility audit report</p>');

    }//end testAddingNewListItemThenIndentAndOutdentOrderedParentList()


    /**
     * Test outdent multiple items and then indent a single item within a ordered parent and unordered sub list.
     *
     * @return void
     */
    public function testAddingNewListItemThenIndentAndOutdentUnorderedParentList()
    {
        // Test using keyboard shortcuts
        $this->useTest(4);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul></li></ol>');

        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% additional %3%<ul><li>Accessibility audit report</li></ul></li></ol>');

        sleep(1);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% additional %3%<ul><li>Accessibility audit report</li></ul></li></ol>');

        // Test using top toolbar
        $this->useTest(4);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul></li></ol>');

        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% additional %3%<ul><li>Accessibility audit report</li></ul></li></ol>');

        sleep(1);
        $this->selectKeyword(2,3);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%<ul><li>Accessibility audit report</li></ul></li></ul></li></ol>');

        // Test using inline toolbar
        $this->useTest(4);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul></li></ol>');

        $this->selectKeyword(2,3);
        sleep(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(3);
        $this->clickInlineToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% additional %3%<ul><li>Accessibility audit report</li></ul></li></ol>');

        sleep(1);
        $this->selectKeyword(2,3);
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%<ul><li>Accessibility audit report</li></ul></li></ul></li></ol>');

        // Test using keyboard shortcuts
        $this->useTest(4);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul></li></ol>');

        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% additional %3%</li></ol><p>Accessibility audit report</p>');

        sleep(1);
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li></ul></li></ol><p>Accessibility audit report</p>');

        // Test using top toolbar
        $this->useTest(4);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul></li></ol>');

        $this->selectKeyword(2,3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->clickTopToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% additional %3%</li></ol><p>Accessibility audit report</p>');

        sleep(1);
        $this->selectKeyword(2,3);
        $this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li></ul></li></ol><p>Accessibility audit report</p>');

        // Test using inline toolbar
        $this->useTest(4);
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report</li></ul></li></ol>');

        $this->selectKeyword(2,3);
        sleep(3);
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
        sleep(3);
        $this->clickInlineToolbarButton('listOutdent');
        sleep(1);
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li></ul></li><li>%2% additional %3%</li></ol><p>Accessibility audit report</p>');

        sleep(1);
        $this->selectKeyword(2,3);
        $this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<h2>Meh</h2><ol><li>%1%<ul><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li></ul></li></ol><p>Accessibility audit report</p>');

    }//end testAddingNewListItemThenIndentAndOutdentUnorderedParentList()

}//end class

?>