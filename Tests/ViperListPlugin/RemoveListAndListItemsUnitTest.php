<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_RemoveListAndListItemsUnitTest extends AbstractViperListPluginUnitTest
{


 	/**
     * Test revmoing and adding back the first list item.
     *
     * @return void
     */
    public function testRemoveAndAddBackTheFirstListItem()
    {
        //Test list when click inside a list item
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
                $listIconToClick = 'listUL';
                $ulStatus = 'active';
                $olStatus = TRUE;
            } else {
                $this->useTest(2);
                $listIconToClick = 'listOL';
                $ulStatus = TRUE;
                $olStatus = 'active';
            }

            $this->moveToKeyword(1);
            $this->clickTopToolbarButton($listIconToClick, 'active');
            $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
            $this->assertHTMLMatch('<p>List:</p><p>%1% first item</p><'.$listType.'><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');
            $this->clickTopToolbarButton($listIconToClick);
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE, FALSE, FALSE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');
        }

        //Test list when select a word in the list item
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(2);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(1);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><p>%1% first item</p><'.$listType.'><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');
                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');
            }
        }

        //Test list when select the whole list item
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(2);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(1);
                $this->selectInlineToolbarLineageItem(1);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><p>%1% first item</p><'.$listType.'><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');
                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');
            }
        }

    }//end testRemoveAndAddBackTheFirstListItem()


    /**
     * Test removing and adding back in the middle list item.
     *
     * @return void
     */
    public function testRemoveAndAddBackTheMiddleListItem()
    {
        //Test list when click inside a list item
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
                $listIconToClick = 'listUL';
                $ulStatus = 'active';
                $olStatus = TRUE;
            } else {
                $this->useTest(2);
                $listIconToClick = 'listOL';
                $ulStatus = TRUE;
                $olStatus = 'active';
            }

            $this->moveToKeyword(2);
            $this->clickTopToolbarButton($listIconToClick, 'active');
            $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li></'.$listType.'><p>%2% second item</p><'.$listType.'><li>%3% third item</li></'.$listType.'>');
            $this->clickTopToolbarButton($listIconToClick);
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE, FALSE, FALSE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');
        }

        //Test list when select a word in the list item
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(2);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(2);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li></'.$listType.'><p>%2% second item</p><'.$listType.'><li>%3% third item</li></'.$listType.'>');
                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');
            }
        }

        //Test list when select the whole list item
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(2);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(2); 
                $this->selectInlineToolbarLineageItem(1);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li></'.$listType.'><p>%2% second item</p><'.$listType.'><li>%3% third item</li></'.$listType.'>');
                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');
            }
        }

    }//end testRemoveAndAddBackTheMiddleListItem()


    /**
     * Test removing and adding back in the last list item.
     *
     * @return void
     */
    public function testRemoveAndAddBackTheLastListItem()
    {
        //Test list when click inside a list item
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
                $listIconToClick = 'listUL';
                $ulStatus = 'active';
                $olStatus = TRUE;
            } else {
                $this->useTest(2);
                $listIconToClick = 'listOL';
                $ulStatus = TRUE;
                $olStatus = 'active';
            }

            $this->moveToKeyword(3);
            $this->clickTopToolbarButton($listIconToClick, 'active');
            $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item</li></'.$listType.'><p>%3% third item</p>');
            $this->clickTopToolbarButton($listIconToClick);
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE, FALSE, FALSE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');
        }

        //Test list when select a word in the list item
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(2);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(3);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item</li></'.$listType.'><p>%3% third item</p>');
                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');
            }
        }

        //Test list when select the whole list item
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(2);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(3);
                $this->selectInlineToolbarLineageItem(1);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item</li></'.$listType.'><p>%3% third item</p>');
                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');
            }
        }

    }//end testRemoveAndAddBackTheLastListItem()


    /**
     * Test list is removed when you click the list icon
     *
     * @return void
     */
    public function testRemoveListUsingListIcon()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(1);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(2);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

            $this->selectKeyword(2);
            $this->selectInlineToolbarLineageItem(0);
            $this->doAction($method, $listIconToClick, 'active');
            $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);
            $this->assertHTMLMatch('<p>List:</p><p>%1% first item</p><p>%2% second item</p><p>%3% third item</p>');
            $this->doTopToolbarAction($method, $listIconToClick);
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');
            }
        }

    }//end testRemoveListUsingListIcon()


    /**
     * Test revmoing and adding back the first list item in a sub list.
     *
     * @return void
     */
    public function testRemoveAndAddBackTheFirstItemInASubList()
    {
        //Test list when click inside a list item
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(3);
                $listIconToClick = 'listUL';
                $ulStatus = 'active';
                $olStatus = TRUE;
            } else {
                $this->useTest(4);
                $listIconToClick = 'listOL';
                $ulStatus = TRUE;
                $olStatus = 'active';
            }

            $this->moveToKeyword(1);
            $this->clickTopToolbarButton($listIconToClick, 'active');
            $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<br /><p>sub item 1 %1%</p><'.$listType.'><li>sub item 2 %2%</li><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
            $this->clickTopToolbarButton($listIconToClick);
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE, FALSE, FALSE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
        }

        //Test list when select a word in the list item
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(3);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(4);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(1);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<br /><p>sub item 1 %1%</p><'.$listType.'><li>sub item 2 %2%</li><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
            }
        }

        //Test list when select the whole list item
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(3);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(4);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(1);
                $this->selectInlineToolbarLineageItem(3);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<br /><p>sub item 1 %1%</p><'.$listType.'><li>sub item 2 %2%</li><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
            }
        }

    }//end testRemoveAndAddBackTheFirstItemInASubList()


    /**
     * Test revmoing and adding back the middle list item in a sub list.
     *
     * @return void
     */
    public function testRemoveAndAddBackTheMiddleItemInASubList()
    {
        //Test list when click inside a list item
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(3);
                $listIconToClick = 'listUL';
                $ulStatus = 'active';
                $olStatus = TRUE;
            } else {
                $this->useTest(4);
                $listIconToClick = 'listOL';
                $ulStatus = TRUE;
                $olStatus = 'active';
            }

            $this->moveToKeyword(2);
            $this->clickTopToolbarButton($listIconToClick, 'active');
            $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li></'.$listType.'><p>sub item 2 %2%</p><'.$listType.'><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
            $this->clickTopToolbarButton($listIconToClick);
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE, FALSE, FALSE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
        }

        //Test list when select a word in the list item
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(3);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(4);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(2);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li></'.$listType.'><p>sub item 2 %2%</p><'.$listType.'><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
            }
        }

        //Test list when select the whole list item
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(3);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(4);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(2);
                $this->selectInlineToolbarLineageItem(3);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li></'.$listType.'><p>sub item 2 %2%</p><'.$listType.'><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
            }
        }

    }//end testRemoveAndAddBackTheMiddleItemInASubList()


    /**
     * Test revmoing and adding back the last list item in a sub list.
     *
     * @return void
     */
    public function testRemoveAndAddBackTheLastItemInASubList()
    {
        //Test list when click inside a list item
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(3);
                $listIconToClick = 'listUL';
                $ulStatus = 'active';
                $olStatus = TRUE;
            } else {
                $this->useTest(4);
                $listIconToClick = 'listOL';
                $ulStatus = TRUE;
                $olStatus = 'active';
            }

            $this->moveToKeyword(3);
            $this->clickTopToolbarButton($listIconToClick, 'active');
            $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li><li>sub item 2 %2%</li></'.$listType.'><p>sub item 3 %3%</p></li><li>second item %4%</li></'.$listType.'>');
            $this->clickTopToolbarButton($listIconToClick);
            $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE, FALSE, FALSE);
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
        }

        //Test list when select a word in the list item
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(3);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(4);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(3);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li><li>sub item 2 %2%</li></'.$listType.'><p>sub item 3 %3%</p></li><li>second item %4%</li></'.$listType.'>');
                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
            }
        }

        //Test list when select the whole list item
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(3);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(4);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(3);
                $this->selectInlineToolbarLineageItem(3);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li><li>sub item 2 %2%</li></'.$listType.'><p>sub item 3 %3%</p></li><li>second item %4%</li></'.$listType.'>');
                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, TRUE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
            }
        }

    }//end testRemoveAndAddBackTheLastItemInASubList()


    /**
     * Test sub list is removed when you click the list icon
     *
     * @return void
     */
    public function testRemoveSubListUsingListIcon()
    {
         foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listType === 'ul') {
                    $this->useTest(3);
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $this->useTest(4);
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->selectKeyword(2);
                $this->selectInlineToolbarLineageItem(2);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, TRUE, FALSE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<br /><p>sub item 1 %1%</p><p>sub item 2 %2%</p><p>sub item 3 %3%</p></li><li>second item %4%</li></'.$listType.'>');
                $this->doTopToolbarAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
                $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>first item<'.$listType.'><li>sub item 1 %1%</li><li>sub item 2 %2%</li><li>sub item 3 %3%</li></'.$listType.'></li><li>second item %4%</li></'.$listType.'>');
            }
        }

    }//end testRemoveListUsingListIcon()


    /**
     * Test removing an item from a list by pressing backspace.
     *
     * @return void
     */
    public function testRemoveItemUsingBackspace()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            $this->moveToKeyword(3, 'left');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item%3% third item</li></'.$listType.'>');
            $this->moveToKeyword(2, 'left');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item%2% second item%3% third item</li></'.$listType.'>');
            $this->moveToKeyword(1, 'left');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->assertHTMLMatch('<p>List:%1% first item%2% second item%3% third item</p>');
        }

    }//end testRemoveItemUsingBackspace()


    /**
     * Test removing all items in the list using backspace
     *
     * @return void
     */
    public function testRemovingAllItemUsingBackspace()
    {
        //Test removing from the start of list
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            $this->moveToKeyword(1, 'left');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->assertHTMLMatch('<p>List:%1% first item</p><'.$listType.'><li>%2% second item</li><li>%3% third item</li></'.$listType.'>');

            $this->moveToKeyword(2, 'left');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->assertHTMLMatch('<p>List:%1% first item%2% second item</p><'.$listType.'><li>%3% third item</li></'.$listType.'>');

            $this->moveToKeyword(3, 'left');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->assertHTMLMatch('<p>List:%1% first item%2% second item%3% third item</p>');
        }
        
        //Test removing from the end of the list
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(1);
            } else {
                $this->useTest(2);
            }

            $this->moveToKeyword(3, 'left');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item</li><li>%2% second item%3% third item</li></'.$listType.'>');

            $this->moveToKeyword(2, 'left');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->assertHTMLMatch('<p>List:</p><'.$listType.'><li>%1% first item%2% second item%3% third item</li></'.$listType.'>');

            $this->moveToKeyword(1, 'left');
            $this->sikuli->keyDown('Key.BACKSPACE');
            $this->assertHTMLMatch('<p>List:%1% first item%2% second item%3% third item</p>');
        }

    }//end testRemovingAllItemUsingBackspace()


    /**
     * Test removing all items in the list using backspace and forward delete
     *
     * @return void
     */
    public function testAddAndRemoveNewBulletsToList()
    {
        //Test using backspace
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $listIconToClick = 'listUL';
            } else {
                $listIconToClick = 'listOL';
            }

            $this->useTest(5);

            // Create list
            $this->moveToKeyword(1, 'right');
            $this->sikuli->keyDown('Key.ENTER');
            $this->type('%2% new list');
            $this->clickTopToolbarButton($listIconToClick);
            $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><'.$listType.'><li>%2% new list</li></'.$listType.'>');
            $this->moveToKeyword(2, 'left');
            $this->sikuli->keyDown('Key.ENTER');
            sleep(1);
            $this->sikuli->keyDown('Key.ENTER');
            sleep(1);
            $this->sikuli->keyDown('Key.ENTER');
            sleep(1);
            $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><'.$listType.'><li></li><li></li><li></li><li>%2% new list</li></'.$listType.'>');

            // Delete using backspace
            $this->moveToKeyword(2, 'left');
            $this->sikuli->keyDown('Key.BACKSPACE');
            sleep(1);
            $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><'.$listType.'><li></li><li></li><li>%2% new list</li></'.$listType.'>');
            $this->sikuli->keyDown('Key.BACKSPACE');
            sleep(1);
            $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><'.$listType.'><li></li><li>%2% new list</li></'.$listType.'>');
            $this->sikuli->keyDown('Key.BACKSPACE');
            sleep(1);
            $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><'.$listType.'><li>%2% new list</li></'.$listType.'>');
        }

        //Test using forward delete
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $listIconToClick = 'listUL';
            } else {
                $listIconToClick = 'listOL';
            }

            $this->useTest(5);

            // Create list
            $this->moveToKeyword(1, 'right');
            $this->sikuli->keyDown('Key.ENTER');
            $this->type('%2% new list');
            $this->clickTopToolbarButton($listIconToClick);
            sleep(1);
            $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><'.$listType.'><li>%2% new list</li></'.$listType.'>');

            $this->moveToKeyword(2, 'left');
            $this->sikuli->keyDown('Key.ENTER');
            sleep(1);
            $this->sikuli->keyDown('Key.ENTER');
            sleep(1);
            $this->sikuli->keyDown('Key.ENTER');
            sleep(1);
            $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><'.$listType.'><li></li><li></li><li></li><li>%2% new list</li></'.$listType.'>');

            // Delete using forward delete
            $this->sikuli->keyDown('Key.UP');
            sleep(1);
            $this->sikuli->keyDown('Key.UP');
            sleep(1);
            $this->sikuli->keyDown('Key.UP');
            sleep(1);
            $this->sikuli->keyDown('Key.DELETE');
            sleep(1);
            $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><'.$listType.'><li></li><li></li><li>%2% new list</li></'.$listType.'>');
            $this->sikuli->keyDown('Key.DELETE');
            sleep(1);
            $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><'.$listType.'><li></li><li>%2% new list</li></'.$listType.'>');
            $this->sikuli->keyDown('Key.DELETE');
            sleep(1);
            $this->assertHTMLMatch('<p>Adding and Removing Bullets %1%</p><'.$listType.'><li>%2% new list</li></'.$listType.'>');
        }

    }//end testAddAndRemoveNewBulletsToList()


    /**
     * Test for removing multiple lists.
     *
     * @return string
     */
    public function testRemoveMultipleLists()
    {
        // Test multiple lists of the same type
        foreach (array('listOL', 'listUL') as $listIconToClick) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listIconToClick === 'listUL') {
                    $this->useTest(6);
                } else {
                    $this->useTest(7);
                }
        
                $this->selectKeyword(1, 2);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertHTMLMatch('<p>List:</p><p>%1% first item</p><p>second item</p><p>third item</p><p>Another list:</p><p>first item</p><p>second item</p><p>third item %2%</p>');
            }
        }
        
        // Test multiple lists of different types
        foreach (array('listOL', 'listUL') as $listIconToClick) {
            foreach ($this->getTestMethods(TRUE, TRUE, FALSE) as $method) {
                if ($listIconToClick === 'listUL') {
                    $this->useTest(8);
                } else {
                    $this->useTest(9);
                }

                $this->selectKeyword(1, 2);
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertHTMLMatch('<p>List:</p><p>%1% first item</p><p>second item</p><p>third item</p><p>Another list:</p><p>first item</p><p>second item</p><p>third item %2%</p>');
            }
        }

    }//end testRemoveMultipleLists

}//end class

?>
