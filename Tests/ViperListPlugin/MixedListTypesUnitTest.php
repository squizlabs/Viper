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
        foreach (array('ol', 'ul') as $listType) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                    $subListType = 'ol';
                } else {
                    $this->useTest(2);
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                    $subListType = 'ul';
                }

            $this->moveToKeyword(1, 'right');
    		$this->sikuli->keyDown('Key.ENTER');
    		$this->type('new item');
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
            $this->moveToKeyword(3, 'right');
            $this->sikuli->keyDown('Key.ENTER');
            $this->type('third item');
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%</li><li>new item<'.$subListType.'><li>first sub item</li><li>second sub item %2%</li><li>third sub item</li></'.$subListType.'></li><li>second item %3%</li><li>third item</li></'.$listType.'>');
        }

    }//end testAddingNewItemsToParentList()


    /**
     * Test adding a new list item to the sub list
     *
     * @return void
     */
    public function testAddingNewItemsToSubList()
    {
        foreach (array('ol', 'ul') as $listType) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $subListType = 'ol';

                    // Status is reserve as we are testing the sub list
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                } else {
                    $this->useTest(2);
                    $subListType = 'ul';

                    // Status is reserve as we are testing the sub list
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                }

            $this->moveToKeyword(2, 'right');
    		$this->sikuli->keyDown('Key.ENTER');
    		$this->type('new item');
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<'.$subListType.'><li>first sub item</li><li>second sub item %2%</li><li>new item</li><li>third sub item</li></'.$subListType.'></li><li>second item %3%</li></'.$listType.'>');
        }

    }//end testAddingNewItemsToSubList()


	/**
     * Test that when you outdent and indent an item in the sub list, it changes to the parent type and back again.
     *
     * @return void
     */
    public function testOutdentAndIndentSubListItem()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $subListType = 'ol';

                    $ulStatusForParent = 'active';
                    $olStatusForParent = TRUE;
                    $ulStatusForSub = TRUE;
                    $olStatusForSub = 'active';

                } else {
                    $this->useTest(2);
                    $subListType = 'ul';

                    $ulStatusForParent = TRUE;
                    $olStatusForParent = 'active';
                    $ulStatusForSub = 'active';
                    $olStatusForSub = TRUE;
                }

                $this->selectKeyword(2);
                sleep(1);
                $this->selectInlineToolbarLineageItem(3);

                // Try pressing shift + right once to make sure the selection reamins at the single list item.
                $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

                // Outdent once so list items are at the top level
                $this->doAction($method, 'listOutdent');
        		$this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<'.$subListType.'><li>first sub item</li></'.$subListType.'></li><li>second sub item %2%<'.$subListType.'><li>third sub item</li></'.$subListType.'></li><li>second item %3%</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Outdent again so list items are no longer in list
                $this->doAction($method, 'listOutdent');
                sleep(1);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<'.$subListType.'><li>first sub item</li></'.$subListType.'></li></'.$listType.'><p>second sub item %2%</p><'.$subListType.'><li>third sub item</li></'.$subListType.'><'.$listType.'><li>second item %3%</li></'.$listType.'>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                // Indent once so it is back in the parent list
                $this->doTopToolbarAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<'.$subListType.'><li>first sub item</li></'.$subListType.'></li><li>second sub item %2%</li></'.$listType.'><'.$subListType.'><li>third sub item</li></'.$subListType.'><'.$listType.'><li>second item %3%</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Indent again so it is added to the sub list
        		$this->doAction($method, 'listIndent');
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<'.$subListType.'><li>first sub item</li><li>second sub item %2%</li></'.$subListType.'></li></'.$listType.'><'.$subListType.'><li>third sub item</li></'.$subListType.'><'.$listType.'><li>second item %3%</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, TRUE, TRUE);

                // Indent again so a third level list is created
                $this->doAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<'.$subListType.'><li>first sub item<'.$subListType.'><li>second sub item %2%</li></'.$subListType.'></li></'.$subListType.'></li></'.$listType.'><'.$subListType.'><li>third sub item</li></'.$subListType.'><'.$listType.'><li>second item %3%</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, FALSE, TRUE);
            }
        }

    }//end testOutdentAndIndentSubListItem()


    /**
     * Test that you can remove an item from the list using the list icon and then add it back to the sub list by clicking the same list icon again.
     *
     * @return void
     */
    public function testRemoveAndAddingSubItemsUsingIcons()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $subListType = 'ol';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                    $listIconToClick = 'listOL';
                } else {
                    $this->useTest(2);
                    $subListType = 'ul';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                    $listIconToClick = 'listUL';
                }

                $this->selectKeyword(2);
                sleep(1);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<'.$subListType.'><li>first sub item</li></'.$subListType.'><p>second sub item %2%</p><'.$subListType.'><li>third sub item</li></'.$subListType.'></li><li>second item %3%</li></'.$listType.'>');
                $this->doAction($method, $listIconToClick);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<'.$subListType.'><li>first sub item</li><li>second sub item %2%</li><li>third sub item</li></'.$subListType.'></li><li>second item %3%</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
            }
        }

    }//end testRemoveAndAddingSubItemsUsingIcons()


    /**
     * Test that you can remove a sub list item by clicking the active list icon in the toolbar and then create a different type of list by 
     * using the other list icon
     *
     * @return void
     */
    public function testRemoveItemFromSubListAndCreateNewSubListType()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $subListType = 'ol';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                    $activeListIconToClick = 'listOL';
                    $listIconToClick = 'listUL';
                } else {
                    $this->useTest(2);
                    $subListType = 'ul';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                    $activeListIconToClick = 'listUL';
                    $listIconToClick = 'listOL';
                }

                $this->selectKeyword(2);
                $this->doAction($method, $activeListIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<'.$subListType.'><li>first sub item</li></'.$subListType.'><p>second sub item %2%</p><'.$subListType.'><li>third sub item</li></'.$subListType.'></li><li>second item %3%</li></'.$listType.'>');
                $this->doAction($method, $listIconToClick);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<'.$subListType.'><li>first sub item</li></'.$subListType.'><'.$listType.'><li>second sub item %2%</li></'.$listType.'><'.$subListType.'><li>third sub item</li></'.$subListType.'></li><li>second item %3%</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
            }
        }

    }//end testRemoveItemFromSubListAndCreateNewSubListType()


	/**
     * Test that when you outdent all items in the sub list and indent them again, it uses the parent list type.
     *
     * @return void
     */
    public function testOutdentAllSubListItemsAndIndentAgain()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(2);
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(2);
                $this->selectInlineToolbarLineageItem(2);
                $this->doAction($method, 'listOutdent');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%</li><li>first sub item</li><li>second sub item %2%</li><li>third sub item</li><li>second item %3%</li></'.$listType.'>');
        		$this->doAction($method, 'listIndent');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<'.$listType.'><li>first sub item</li><li>second sub item %2%</li><li>third sub item</li></'.$listType.'></li><li>second item %3%</li></'.$listType.'>');
            }
        }

    }//end testOutdentAllSubListItemsAndIndentAgain()


    /**
     * Test that you can remove all items from the sub list and re-create the sub list using the list icons.
     *
     * @return void
     */
    public function testRemoveAndRecreateSubList()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $subListType = 'ol';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                    $listIconToClick = 'listOL';
                } else {
                    $this->useTest(2);
                    $subListType = 'ul';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                    $listIconToClick = 'listUL';
                }

                $this->selectKeyword(2);
                $this->selectInlineToolbarLineageItem(2);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<br /><p>first sub item</p><p>second sub item %2%</p><p>third sub item</p></li><li>second item %3%</li></'.$listType.'>');
                $this->doAction($method, $listIconToClick);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<'.$subListType.'><li>first sub item</li><li>second sub item %2%</li><li>third sub item</li></'.$subListType.'></li><li>second item %3%</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
            }
        }

    }//end testRemoveAndRecreateSubList()


    /**
     * Test that you can remove all items from the sub list using the list icon and create a new sub list using the parent list type by pressing tab.
     *
     * @return void
     */
    public function testRemoveSubListAndCreateNewListWithTabKey()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $listIconToClick = 'listOL';
                } else {
                    $this->useTest(2);
                    $listIconToClick = 'listUL';
                }

                $this->selectKeyword(2);
                $this->selectInlineToolbarLineageItem(2);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<br /><p>first sub item</p><p>second sub item %2%</p><p>third sub item</p></li><li>second item %3%</li></'.$listType.'>');
                $this->sikuli->keyDown('Key.TAB');
                $this->assertIconStatusesCorrect('active', TRUE, FALSE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>First item %1%<ul><li>first sub item</li><li>second sub item %2%</li><li>third sub item</li></ul></li><li>second item %3%</li></'.$listType.'>');
            }
        }

    }//end testRemoveSubListAndCreateNewListWithTabKey()


    /**
     * Test outdent and indent two sub list items when selecting both list items.
     *
     * @return void
     */
    public function testOutdentAndIndentTwoSubListItems()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(3);
                    $subListType = 'ol';
                    $ulStatusForParent = 'active';
                    $olStatusForParent = TRUE;
                    $ulStatusForSub = TRUE;
                    $olStatusForSub = 'active';
                } else {
                    $this->useTest(4);
                    $subListType = 'ul';
                    $ulStatusForParent = TRUE;
                    $olStatusForParent = 'active';
                    $ulStatusForSub = 'active';
                    $olStatusForSub = TRUE;
                }

                // Outdent once so list items are at the top level
                $this->selectKeyword(2, 4);
                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li><li>%2% additional %3%</li><li>Accessibility audit report %4%</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Outdent again so list items are no longer in list
                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li></'.$listType.'><p>%2% additional %3%</p><p>Accessibility audit report %4%</p>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);

                // Indent once so they are back in the list
                $this->doTopToolbarAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li><li>%2% additional %3%</li><li>Accessibility audit report %4%</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Indent again so they added to the sub list
                $this->doAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report %4%</li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, TRUE, TRUE);

                // Indent again so a third level list is created
                $this->doAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages<'.$subListType.'><li>%2% additional %3%</li><li>Accessibility audit report %4%</li></'.$subListType.'></li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, FALSE, TRUE);
            }
        }

    }//end testOutdentAndIndentTwoSubListItems()


    /**
     * Test selecting one list item, pressing shift + right twice and outdenting and indenting content
     *
     * @return void
     */
    public function testOutdentAndIndentTwoSubListItemsWithPartialSelection()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {

                if ($listType === 'ul') {
                    $this->useTest(3);
                    $subListType = 'ol';
                    $ulStatusForParent = 'active';
                    $olStatusForParent = TRUE;
                    $ulStatusForSub = TRUE;
                    $olStatusForSub = 'active';
                } else {
                    $this->useTest(4);
                    $subListType = 'ul';
                    $ulStatusForParent = TRUE;
                    $olStatusForParent = 'active';
                    $ulStatusForSub = 'active';
                    $olStatusForSub = TRUE;
                }

                $this->selectKeyword(2);
                $this->selectInlineToolbarLineageItem(3);
                $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
                $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

                // Outdent once so list items are at the top level
                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li><li>%2% additional %3%</li><li>Accessibility audit report %4%</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Outdent again so list items are no longer in list
                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li></'.$listType.'><p>%2% additional %3%</p><p>Accessibility audit report %4%</p>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);

                // Indent once so they are back in the list
                $this->doTopToolbarAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li><li>%2% additional %3%</li><li>Accessibility audit report %4%</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Indent again so they added to the sub list
                $this->doAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% additional %3%</li><li>Accessibility audit report %4%</li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, TRUE, TRUE);

                // Indent again so a third level list is created
                $this->doAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages<'.$subListType.'><li>%2% additional %3%</li><li>Accessibility audit report %4%</li></'.$subListType.'></li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, FALSE, TRUE);
            }
        }

    }//end testOutdentAndIndentTwoSubListItemsWithPartialSelection()


    /**
     * Test selecting a second level sub list item and using indent
     * and outdent.
     *
     * @return void
     */
    public function testOutdentAndIndentSubListItemThatHasEmptySubList()
    {

        // Test when the sub list is the same list type as the empty list
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {

                if ($listType === 'ul') {
                    $this->useTest(5);
                    $subListType = 'ol';
                    $ulStatusForParent = 'active';
                    $olStatusForParent = TRUE;
                    $ulStatusForSub = TRUE;
                    $olStatusForSub = 'active';
                } else {
                    $this->useTest(6);
                    $subListType = 'ul';
                    $ulStatusForParent = TRUE;
                    $olStatusForParent = 'active';
                    $ulStatusForSub = 'active';
                    $olStatusForSub = TRUE;
                }

                $this->sikuli->tripleClick($this->findKeyword(2));

                // Press shift + right once to make sure the selection is maintained. It should not select the next list item.
                $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

                // Outdent once so the parent and following list item get added to the top level list.
                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li><li>%2% test<'.$subListType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Outdent again so parent and following list items are removed from the list.
                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li></'.$listType.'><p>%2% test</p><'.$subListType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$subListType.'>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                // Indent once so items are added back to list
                $this->doTopToolbarAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li><li>%2% test</li></'.$listType.'><'.$subListType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$subListType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Indent again so items are added back to sub list
                $this->doAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test</li></'.$subListType.'></li></'.$listType.'><'.$subListType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$subListType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, TRUE, TRUE);

                // Indent again so items are added to the third level list
                $this->doAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages<'.$subListType.'><li>%2% test</li></'.$subListType.'></li></'.$subListType.'></li></'.$listType.'><'.$subListType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$subListType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, FALSE, TRUE);
            }
        }

        // Test when the sub list is a different list type to the empty list
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {

                if ($listType === 'ul') {
                    $this->useTest(7);
                    $subListType = 'ol';
                    $ulStatusForParent = 'active';
                    $olStatusForParent = TRUE;
                    $ulStatusForSub = TRUE;
                    $olStatusForSub = 'active';
                } else {
                    $this->useTest(8);
                    $subListType = 'ul';
                    $ulStatusForParent = TRUE;
                    $olStatusForParent = 'active';
                    $ulStatusForSub = 'active';
                    $olStatusForSub = TRUE;
                }

                $this->sikuli->tripleClick($this->findKeyword(2));

                // Press shift + right once to make sure the selection is maintained. It should not select the next list item.
                $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');

                // Outdent once so the parent and following list item get added to the top level list.
                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li><li>%2% test<'.$listType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$listType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Outdent again so parent and following list items are removed from the list.
                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li></'.$listType.'><p>%2% test</p><'.$listType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$listType.'>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                // Indent once so items are added back to list
                $this->doTopToolbarAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li><li>%2% test</li><li>&nbsp;</li><li>Accessibility audit report</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Indent again so items are added back to sub list
                $this->doAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test</li></'.$subListType.'></li><li>&nbsp;</li><li>Accessibility audit report</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, TRUE, TRUE);

                // Indent again so items are added to the third level list
                $this->doAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages<'.$subListType.'><li>%2% test</li></'.$subListType.'></li></'.$subListType.'></li><li>&nbsp;</li><li>Accessibility audit report</li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, FALSE, TRUE);
            }
        }

    }//end testOutdentAndIndentSubListItemThatHasEmptySubList()


    /**
     * Test selecting a second level sub list item, pressing shift + right twice to select its empty sub list item and using indent
     * and outdent.
     *
     * @return void
     */
    public function testOutdentAndIndentSubListItemAndEmptySubList()
    {

        // Test when the sub list is the same list type as the empty list
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {

                if ($listType === 'ul') {
                    $this->useTest(5);
                    $subListType = 'ol';
                    $ulStatusForParent = 'active';
                    $olStatusForParent = TRUE;
                    $ulStatusForSub = TRUE;
                    $olStatusForSub = 'active';
                } else {
                    $this->useTest(6);
                    $subListType = 'ul';
                    $ulStatusForParent = TRUE;
                    $olStatusForParent = 'active';
                    $ulStatusForSub = 'active';
                    $olStatusForSub = TRUE;
                }

                $this->sikuli->tripleClick($this->findKeyword(2));

                for ($i = 0; $i < 2; $i++) {
                    $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
                }

                // Outdent once so the parent and following list item get added to the top level list.
                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li><li>%2% test<'.$subListType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Outdent again so parent and following list items are removed from the list.
                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li></'.$listType.'><p>%2% test</p><'.$subListType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$subListType.'>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                // Indent once so items are added back to list
                $this->doTopToolbarAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li><li>%2% test<'.$subListType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Indent again so items are added back to sub list
                $this->doAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test<'.$subListType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$subListType.'></li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, TRUE, TRUE);

                // Indent again so items are added to the third level list
                $this->doAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages<'.$subListType.'><li>%2% test<'.$subListType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$subListType.'></li></'.$subListType.'></li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, FALSE, TRUE);
            }
        }

        // Test when the sub list is a different list type to the empty list
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {

                if ($listType === 'ul') {
                    $this->useTest(7);
                    $subListType = 'ol';
                    $ulStatusForParent = 'active';
                    $olStatusForParent = TRUE;
                    $ulStatusForSub = TRUE;
                    $olStatusForSub = 'active';
                } else {
                    $this->useTest(8);
                    $subListType = 'ul';
                    $ulStatusForParent = TRUE;
                    $olStatusForParent = 'active';
                    $ulStatusForSub = 'active';
                    $olStatusForSub = TRUE;
                }

                $this->sikuli->tripleClick($this->findKeyword(2));

                for ($i = 0; $i < 2; $i++) {
                    $this->sikuli->keyDown('Key.SHIFT + Key.RIGHT');
                }

                // Outdent once so the parent and following list item get added to the top level list.
                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li><li>%2% test<'.$listType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$listType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Outdent again so parent and following list items are removed from the list.
                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li></'.$listType.'><p>%2% test</p><'.$listType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$listType.'>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                // Indent once so items are added back to list
                $this->doTopToolbarAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li></'.$subListType.'></li><li>%2% test<'.$listType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$listType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Indent again so items are added back to sub list
                $this->doAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages</li><li>%2% test<'.$listType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$listType.'></li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, TRUE, TRUE);

                // Indent again so items are added to the third level list
                $this->doAction($method, 'listIndent');
                $this->assertHTMLMatch('<h2>Meh</h2><'.$listType.'><li>%1%<'.$subListType.'><li>Audit of Homepage and 6 Section Landing pages<'.$subListType.'><li>%2% test<'.$listType.'><li>&nbsp;</li><li>Accessibility audit report</li></'.$listType.'></li></'.$subListType.'></li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, FALSE, TRUE);
            }
        }

    }//end testOutdentAndIndentSubListItemAndEmptySubList()


    /**
     * Test selecting a list item and its sub list and using indent and outdent.
     *
     * @return void
     */
    public function testOutdentAndIndentListItemWithItsSubList()
    {
        // Test selecting items located in the middle of the list
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {

                if ($listType === 'ul') {
                    $this->useTest(9);
                    $subListType = 'ol';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(10);
                    $subListType = 'ul';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(1);
                $this->selectInlineToolbarLineageItem(1);

                // Outdent again so parent is removed from the list
                $this->doAction($method, 'listOutdent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li></'.$listType.'><p>List %1% item here..</p><'.$subListType.'><li>Sub %2% list item</li></'.$subListType.'><'.$listType.'><li>List %3% item here..<'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                // Indent once paragraph is added back to the top list
                $this->doTopToolbarAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$subListType.'><li>Sub %2% list item</li></'.$subListType.'></li><li>List %3% item here..<'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);

                // Indent again so parent is added back to second level list
                $this->doAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan<'.$listType.'><li>List %1% item here..<'.$subListType.'><li>Sub %2% list item</li></'.$subListType.'></li></'.$listType.'></li><li>List %3% item here..<'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);

            }
        }

        // Test selecting items located at the bottom of the list
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {

                 if ($listType === 'ul') {
                    $this->useTest(9);
                    $subListType = 'ol';
                    $ulStatusForParent = 'active';
                    $olStatusForParent = TRUE;
                    $ulStatusForSub = TRUE;
                    $olStatusForSub = 'active';
                } else {
                    $this->useTest(10);
                    $subListType = 'ul';
                    $ulStatusForParent = TRUE;
                    $olStatusForParent = 'active';
                    $ulStatusForSub = 'active';
                    $olStatusForSub = TRUE;
                }

                $this->selectKeyword(3);
                $this->selectInlineToolbarLineageItem(1);

                // Outdent so parent is removed from the list
                $this->doAction($method, 'listOutdent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$subListType.'><li>Sub %2% list item</li></'.$subListType.'></li></'.$listType.'><p>List %3% item here..</p><'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                // Indent once paragraph is added back to the top list
                $this->doTopToolbarAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$subListType.'><li>Sub %2% list item</li></'.$subListType.'></li><li>List %3% item here..<'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Indent again so parent is added back to second level list
                $this->doAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$subListType.'><li>Sub %2% list item</li><li>List %3% item here..<'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'></li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, TRUE, TRUE);

                // Indent again so parent is added back to third level list
                $this->doAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$subListType.'><li>Sub %2% list item<'.$subListType.'><li>List %3% item here..<'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'></li></'.$subListType.'></li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, FALSE, TRUE);

            }
        }

    }//end testOutdentAndIndentListItemWithItsSubList()


    /**
     * Test selecting a list item and its sub list and using indent and outdent.
     *
     * @return void
     */
    public function testOutdentAndIndentListItemWithMixedSubLists()
    {
        // Test selecting items located in the middle of the list where sub list is a different type
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {

                if ($listType === 'ul') {
                    $this->useTest(11);
                    $subListType = 'ol';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(12);
                    $subListType = 'ul';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(1);
                $this->selectInlineToolbarLineageItem(1);

                // Outdent again so parent is removed from the list
                $this->doAction($method, 'listOutdent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li></'.$listType.'><p>List %1% item here..</p><'.$subListType.'><li>Sub %2% list item</li></'.$subListType.'><'.$listType.'><li>List %3% item here..<'.$listType.'><li>Sub %4% list item</li></'.$listType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                // Indent once paragraph is added back to the top list
                $this->doTopToolbarAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$subListType.'><li>Sub %2% list item</li></'.$subListType.'></li><li>List %3% item here..<'.$listType.'><li>Sub %4% list item</li></'.$listType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);

                // Indent again so parent is added back to second level list
                $this->doAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan<'.$listType.'><li>List %1% item here..<'.$subListType.'><li>Sub %2% list item</li></'.$subListType.'></li></'.$listType.'></li><li>List %3% item here..<'.$listType.'><li>Sub %4% list item</li></'.$listType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);

            }
        }

        // Test selecting items located in the middle of the list where sub list is the same type
       foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {

                if ($listType === 'ul') {
                    $this->useTest(13);
                    $subListType = 'ol';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(14);
                    $subListType = 'ul';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(1);
                $this->selectInlineToolbarLineageItem(1);

                // Outdent again so parent is removed from the list
                $this->doAction($method, 'listOutdent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li></'.$listType.'><p>List %1% item here..</p><'.$listType.'><li>Sub %2% list item</li></'.$listType.'><'.$listType.'><li>List %3% item here..<'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                // Indent once paragraph is added back to the top list
                $this->doTopToolbarAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$listType.'><li>Sub %2% list item</li></'.$listType.'></li><li>List %3% item here..<'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);

                // Indent again so parent is added back to second level list
                $this->doAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan<'.$listType.'><li>List %1% item here..<'.$listType.'><li>Sub %2% list item</li></'.$listType.'></li></'.$listType.'></li><li>List %3% item here..<'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);

            }
        }

        // Test selecting items located at the bottom of the list where sub list is of the same type
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {

                 if ($listType === 'ul') {
                    $this->useTest(11);
                    $subListType = 'ol';
                    $ulStatusForParent = 'active';
                    $olStatusForParent = TRUE;
                    $ulStatusForSub = TRUE;
                    $olStatusForSub = 'active';
                } else {
                    $this->useTest(12);
                    $subListType = 'ul';
                    $ulStatusForParent = TRUE;
                    $olStatusForParent = 'active';
                    $ulStatusForSub = 'active';
                    $olStatusForSub = TRUE;
                }

                $this->selectKeyword(3);
                $this->selectInlineToolbarLineageItem(1);

                // Outdent so parent is removed from the list
                $this->doAction($method, 'listOutdent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$subListType.'><li>Sub %2% list item</li></'.$subListType.'></li></'.$listType.'><p>List %3% item here..</p><'.$listType.'><li>Sub %4% list item</li></'.$listType.'>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                // Indent once paragraph is added back to the top list
                $this->doTopToolbarAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$subListType.'><li>Sub %2% list item</li></'.$subListType.'></li><li>List %3% item here..<'.$listType.'><li>Sub %4% list item</li></'.$listType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForParent, $olStatusForParent, TRUE, TRUE);

                // Indent again so parent is added back to second level list
                $this->doAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$subListType.'><li>Sub %2% list item</li><li>List %3% item here..<'.$listType.'><li>Sub %4% list item</li></'.$listType.'></li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, TRUE, TRUE);

                // Indent again so parent is added back to second level list
                $this->doAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$subListType.'><li>Sub %2% list item<'.$subListType.'><li>List %3% item here..<'.$listType.'><li>Sub %4% list item</li></'.$listType.'></li></'.$subListType.'></li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatusForSub, $olStatusForSub, FALSE, TRUE);

            }
        }

        // Test selecting items located at the bottom of the list where sub list is of a different type
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {

                 if ($listType === 'ul') {
                    $this->useTest(13);
                    $subListType = 'ol';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(14);
                    $subListType = 'ul';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(3);
                $this->selectInlineToolbarLineageItem(1);

                // Outdent so parent is removed from the list
                $this->doAction($method, 'listOutdent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$listType.'><li>Sub %2% list item</li></'.$listType.'></li></'.$listType.'><p>List %3% item here..</p><'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                // Indent once paragraph is added back to the top list
                $this->doTopToolbarAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$listType.'><li>Sub %2% list item</li></'.$listType.'></li><li>List %3% item here..<'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);

                // Indent again so parent is added back to second level list
                $this->doAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$listType.'><li>Sub %2% list item</li><li>List %3% item here..<'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'></li></'.$listType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);

                // Indent again so parent is added back to second level list
                $this->doAction($method, 'listIndent');
                sleep(1);
                $this->assertHTMLMatch('<'.$listType.'><li>Recommendations and action plan</li><li>List %1% item here..<'.$listType.'><li>Sub %2% list item<'.$listType.'><li>List %3% item here..<'.$subListType.'><li>Sub %4% list item</li></'.$subListType.'></li></'.$listType.'></li></'.$listType.'></li></'.$listType.'>');
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
            }
        }

    }//end testOutdentAndIndentListItemWithMixedSubLists()


    /**
     * Test indent and outdent all items in a list and sub list.
     *
     * @return void
     */
    public function testOutdentAndIndentAllItemsInListAndSubList()
    {

        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, TRUE) as $method) {

                if ($listType === 'ul') {
                    $this->useTest(15);
                    $subListType = 'ol';
                } else {
                    $this->useTest(16);
                    $subListType = 'ul';
                }

                $this->selectKeyword(1);
                sleep(1);
                $this->selectInlineToolbarLineageItem(1);
                sleep(1);

                // Outdent once so the parent is moved to a paragraph
                $this->doAction($method, 'listOutdent');
                $this->assertHTMLMatch('<p>Some content</p><p>List %1% item here..</p><'.$subListType.'><li>Sub %2% list item</li></'.$subListType.'>');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);

                // Indent once so the parent is added back to a list
                $this->doTopToolbarAction($method, 'listIndent');
                $this->assertHTMLMatch('<p>List:</p><ul> <li> List %1% item here..<'.$subListType.'><li> Sub %2% list item </li> </'.$subListType.'> </li></ul>');
                $this->assertIconStatusesCorrect('active', TRUE, FALSE, FALSE, TRUE, FALSE);
            }
        }

    }//end testAllItemsInListAndSubList()

}//end class

?>