<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_SuperscriptInListsUnitTest extends AbstractViperUnitTest
{


    /**
     * Test applying superscript to a word in a list.
     *
     * @return void
     */
    public function testAddAndRemoveSuperscriptToWordInListItem()
    {
        // Apply superscript using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <sup>%1%</sup></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 <sup>%1%</sup></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <sup>%2%</sup></li><li>item 3</li></ol>');

         // Remove superscript using top toolbar
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 <sup>%2%</sup></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testAddAndRemoveSuperscriptToWordInListItem()


    /**
     * Test applying superscript to a word a list item.
     *
     * @return void
     */
    public function testAddAndRemoveSuperscriptToListItem()
    {
        // Apply superscript using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><sup>item 2 %1%</sup></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li><sup>item 2 %1%</sup></li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><sup>item 2 %2%</sup></li><li>item 3</li></ol>');

         // Remove superscript using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li><sup>item 2 %2%</sup></li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testAddAndRemoveSuperscriptToListItem()


    /**
     * Test applying superscript to a word a list.
     *
     * @return void
     */
    public function testAddAndRemoveSuperscriptToList()
    {
        // Apply superscript using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li><sup>item 1</sup></li><li><sup>item 2 %1%</sup></li><li><sup>item 3</sup></li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('superscript');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'active'), 'Superscript icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li><sup>item 1</sup></li><li><sup>item 2 %1%</sup></li><li><sup>item 3</sup></li></ul><p>Ordered list:</p><ol><li><sup>item 1</sup></li><li><sup>item 2 %2%</sup></li><li><sup>item 3</sup></li></ol>');

         // Remove superscript using top toolbar
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li><sup>item 1</sup></li><li><sup>item 2 %2%</sup></li><li><sup>item 3</sup></li></ol>');

        $this->selectKeyword(2);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertTrue($this->topToolbarButtonExists('superscript'), 'Superscript icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>Unordered list:</p><ul><li>item 1</li><li>item 2 %1%</li><li>item 3</li></ul><p>Ordered list:</p><ol><li>item 1</li><li>item 2 %2%</li><li>item 3</li></ol>');

    }//end testAddAndRemoveSuperscriptToListItem()

}//end class

?>
