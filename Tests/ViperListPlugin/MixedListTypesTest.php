<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_MixedListTypesTest extends AbstractViperListPluginUnitTest
{


	/**
     * Test adding a new list items to the parent list
     *
     * @return void
     */
    public function testAddingNewItemsToParentList()
    {
        //Test unordered list
        $this->moveToKeyword(1, 'right');
		$this->sikuli->keyDown('Key.ENTER');
		$this->type('new item');
        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('third item');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%</li><li>new item<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li><li>third item</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

        //Test unordered list
        $this->moveToKeyword(4, 'right');
		$this->sikuli->keyDown('Key.ENTER');
		$this->type('new item');
        $this->moveToKeyword(6, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('third item');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%</li><li>new item<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li><li>third item</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%</li><li>new item<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li><li>third item</li></ol>');

    }//end testAddingNewItemsToParentList()


    /**
     * Test adding a new list items to the sub list
     *
     * @return void
     */
    public function testAddingNewItemsToSubList()
    {
        //Test unordered list
        $this->moveToKeyword(2, 'right');
		$this->sikuli->keyDown('Key.ENTER');
		$this->type('new item');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li><li>new item</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

        //Test unordered list
        $this->moveToKeyword(5, 'right');
		$this->sikuli->keyDown('Key.ENTER');
		$this->type('new item');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li><li>new item</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li><li>new item</li></ul></li><li>second item %6%</li></ol>');

    }//end testAddingNewItemsToSubList()


	/**
     * Test that when you indent and outdent an item in the sub list using keyboard shotcuts, it remains the sub list list type.
     *
     * @return void
     */
    public function testIndentAndOutdentSubListItemWithKeyboardShortcuts()
    {
        //Test ordered sub list
        $this->moveToKeyword(2);
		$this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item<ol><li>second sub item %2%</li></ol></li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

        //Test unordered sub list
        $this->moveToKeyword(5);
		$this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item<ul><li>second sub item %5%</li></ul></li></ul></li><li>second item %6%</li></ol>');
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

    }//end testIndentAndOutdentSubListItemWithKeyboardShortcuts()


    /**
     * Test that when you indent and outdent an item in the sub list using inline toolbar icons, it remains the sub list list type.
     *
     * @return void
     */
    public function testIndentAndOutdentSubListItemWithInlineToolbarIcons()
    {
        //Test ordered sub list
        $this->selectKeyword(2);
		$this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item<ol><li>second sub item %2%</li></ol></li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

        //Test unordered sub list
        $this->selectKeyword(5);
		$this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item<ul><li>second sub item %5%</li></ul></li></ul></li><li>second item %6%</li></ol>');
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

    }//end testIndentAndOutdentSubListItemWithInlineToolbarIcons()


    /**
     * Test that when you indent and outdent an item in the sub list using top toolbar icons, it remains the sub list list type.
     *
     * @return void
     */
    public function testIndentAndOutdentSubListItemWithTopToolbarIcons()
    {
        //Test ordered sub list
        $this->selectKeyword(2);
		$this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item<ol><li>second sub item %2%</li></ol></li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

        //Test unordered sub list
        $this->selectKeyword(5);
		$this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item<ul><li>second sub item %5%</li></ul></li></ul></li><li>second item %6%</li></ol>');
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

    }//end testIndentAndOutdentSubListItemWithTopToolbarIcons()


	/**
     * Test that when you outdent and indent an item in the sub list using keyboard shotcuts, it changes to the parent type and back again.
     *
     * @return void
     */
    public function testOutdentAndIndentSubListItemWithKeyboardShortcuts()
    {
        //Test ordered sub list
        $this->moveToKeyword(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
		$this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li></ol></li><li>second sub item %2%</li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');
		$this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

        //Test unordered sub list
        $this->moveToKeyword(5);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
		$this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li></ul></li><li>second sub item %5%</li><li>second item %6%</li></ol>');
		$this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

    }//end testIndentAndOutdentSubListItemWithKeyboardShortcuts()


    /**
     * Test that when you outdent and indent an item in the sub list using inline toolbar icons, it changes to the parent type and back again.
     *
     * @return void
     */
    public function testOutdentAndIndentSubListItemWithInlineToolbarIcons()
    {
        //Test ordered sub list
        $this->selectKeyword(2);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li></ol></li><li>second sub item %2%</li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');
		$this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

        //Test unordered sub list
        $this->selectKeyword(5);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li></ul></li><li>second sub item %5%</li><li>second item %6%</li></ol>');
		$this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

    }//end testOutdentAndIndentSubListItemWithInlineToolbarIcons()


    /**
     * Test that when you outdent and indent an item in the sub list using top toolbar icons, it changes to the parent type and back again.
     *
     * @return void
     */
    public function testOutdentAndIndentSubListItemWithTopToolbarIcons()
    {
        //Test ordered sub list
        $this->moveToKeyword(2);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li></ol></li><li>second sub item %2%</li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');
		$this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

        //Test unordered sub list
        $this->moveToKeyword(5);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li></ul></li><li>second sub item %5%</li><li>second item %6%</li></ol>');
		$this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ol><li>first sub item</li><li>second sub item %2%</li></ol></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

    }//end testOutdentAndIndentSubListItemWithTopToolbarIcons()


	/**
     * Test that when you outdent all items in the sub list and indent them again using keyboard shortcuts, it uses the parent list type.
     *
     * @return void
     */
    public function testOutdentAllSubListItemsAndThenIndentAgainUsngKeyboardShortcuts()
    {
        //Test ordered sub list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%</li><li>first sub item</li><li>second sub item %2%</li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');
		$this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

        //Test unordered sub list
        $this->moveToKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $this->sikuli->keyDown('Key.SHIFT + Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%</li><li>first sub item</li><li>second sub item %5%</li><li>second item %6%</li></ol>');
		$this->sikuli->keyDown('Key.TAB');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ol><li>first sub item</li><li>second sub item %5%</li></ol></li><li>second item %6%</li></ol>');

    }//end testOutdentAllSubListItemsAndThenIndentAgainUsngKeyboardShortcuts()


    /**
     * Test that when you outdent all items in the sub list and indent them again using the inline toolbar, it uses the parent list type.
     *
     * @return void
     */
    public function testOutdentAllSubListItemsAndThenIndentAgainUsngInlineToolbar()
    {
        //Test ordered sub list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%</li><li>first sub item</li><li>second sub item %2%</li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');
		$this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

        //Test unordered sub list
        $this->moveToKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickInlineToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%</li><li>first sub item</li><li>second sub item %5%</li><li>second item %6%</li></ol>');
		$this->clickInlineToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ol><li>first sub item</li><li>second sub item %5%</li></ol></li><li>second item %6%</li></ol>');

    }//end testOutdentAllSubListItemsAndThenIndentAgainUsngInlineToolbar()


    /**
     * Test that when you outdent all items in the sub list and indent them again using the top toolbar, it uses the parent list type.
     *
     * @return void
     */
    public function testOutdentAllSubListItemsAndThenIndentAgainUsngTopToolbar()
    {
        //Test ordered sub list
        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%</li><li>first sub item</li><li>second sub item %2%</li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');
		$this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ul><li>first sub item</li><li>second sub item %5%</li></ul></li><li>second item %6%</li></ol>');

        //Test unordered sub list
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(2);
        $this->clickTopToolbarButton('listOutdent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%</li><li>first sub item</li><li>second sub item %5%</li><li>second item %6%</li></ol>');
		$this->clickTopToolbarButton('listIndent');
        $this->assertHTMLMatch('<p>Unordered List with ordered sub list:</p><ul><li>First item %1%<br /><ul><li>first sub item</li><li>second sub item %2%</li></ul></li><li>second item %3%</li></ul><p>Ordered List with unordered sub list:</p><ol><li>First item %4%<br /><ol><li>first sub item</li><li>second sub item %5%</li></ol></li><li>second item %6%</li></ol>');

    }//end testOutdentAllSubListItemsAndThenIndentAgainUsngTopToolbar()


}//end class

?>