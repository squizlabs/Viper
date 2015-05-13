<?php

require_once 'AbstractCopyPasteFromWordAndGoogleDocsUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_OrderedListsFormatsUnitTest extends AbstractCopyPasteFromWordAndGoogleDocsUnitTest
{

	/**
     * Test that copying/pasting from the OrderedListsFormats word doc works correctly.
     *
     * @return void
     */
    public function testOrderedListsFormatsFromWord()
    {
        $this->copyAndPasteFromWordDoc('OrderedListsFormats.txt', '<ol><li>First item</li><li>Second item</li><li>Third Item</li></ol><ol><li>First item</li><li>Second item</li><li>Third Item</li></ol><ol type="A"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="a"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="a"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="I"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="i"><li>First item</li><li>Second item</li><li>Third item</li></ol>');

    }//end testOrderedListsFormatsFromWord()


    /**
     * Test that copying/pasting from the OrderedListsFormats google doc works correctly.
     *
     * @return void
     */
    public function testOrderedListsFormatsFromGoogleDoc()
    {
        $this->copyAndPasteFromGoogleDocs('OrderedListsFormats.txt', '<ol><li style="list-style-type:decimal">First item</li><li style="list-style-type:decimal">Second item</li><li style="list-style-type:decimal">Third Item</li></ol><ol><li style="list-style-type:decimal">First item</li><li style="list-style-type:decimal">Second item</li><li style="list-style-type:decimal">Third Item</li></ol><ol><li style="list-style-type:upper-alpha">First item</li><li style="list-style-type:upper-alpha">Second item</li><li style="list-style-type:upper-alpha">Third item</li></ol><ol><li style="list-style-type:upper-roman">First item</li><li style="list-style-type:upper-roman">Second item</li><li style="list-style-type:upper-roman">Third item</li></ol><ol><li style="list-style-type:decimal-leading-zero">First item</li><li style="list-style-type:decimal-leading-zero">Second item</li><li style="list-style-type:decimal-leading-zero">Third item</li></ol>');

    }//end testOrderedListsFormatsFromGoogleDoc()

}//end class

?>