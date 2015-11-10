<?php

require_once 'AbstractCopyPasteFromWordAndGoogleDocsUnitTest.php';

class Viper_Tests_ViperCopyPastePlugin_OrderedListsFormatsUnitTest extends AbstractCopyPasteFromWordAndGoogleDocsUnitTest
{

	/**
     * Test that copying/pasting from the OrderedListsFormats word doc works correctly with aggressive mode off.
     *
     * @return void
     */
    public function testOrderedListsFormatsFromWordWithAggressiveModeOff()
    {
        $this->setPluginSettings('ViperCopyPastePlugin', array('aggressiveMode' => false));
        $this->copyAndPasteFromWordDoc('OrderedListsFormats.txt', '<ol><li>First item</li><li>Second item</li><li>Third Item</li></ol><ol><li>First item</li><li>Second item</li><li>Third Item</li></ol><ol type="A"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="a"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="a"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="I"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="i"><li>First item</li><li>Second item</li><li>Third item</li></ol>');

    }//end testOrderedListsFormatsFromWordWithAggressiveModeOff()


    /**
     * Test that copying/pasting from the OrderedListsFormats word doc works correctly with aggressive mode on.
     *
     * @return void
     */
    public function testOrderedListsFormatsFromWordWithAggressiveModeOn()
    {
        $this->copyAndPasteFromWordDoc('OrderedListsFormats.txt', '<ol><li>First item</li><li>Second item</li><li>Third Item</li></ol><ol><li>First item</li><li>Second item</li><li>Third Item</li></ol><ol type="A"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="a"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="a"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="I"><li>First item</li><li>Second item</li><li>Third item</li></ol><ol type="i"><li>First item</li><li>Second item</li><li>Third item</li></ol>');

    }//end testOrderedListsFormatsFromWordWithAggressiveModeOn()


    /**
     * Test that copying/pasting from the OrderedListsFormats google doc works correctly with aggressive mode off.
     *
     * @return void
     */
    public function testOrderedListsFormatsFromGoogleDocWithAggressiveModeOff()
    {
        $this->setPluginSettings('ViperCopyPastePlugin', array('aggressiveMode' => false));
        $this->copyAndPasteFromGoogleDocs('OrderedListsFormats.txt', '<ol><li style="list-style-type:decimal">First item</li><li style="list-style-type:decimal">Second item</li><li style="list-style-type:decimal">Third Item</li></ol><ol><li style="list-style-type:decimal">First item</li><li style="list-style-type:decimal">Second item</li><li style="list-style-type:decimal">Third Item</li></ol><ol><li style="list-style-type:upper-alpha">First item</li><li style="list-style-type:upper-alpha">Second item</li><li style="list-style-type:upper-alpha">Third item</li></ol><ol><li style="list-style-type:upper-roman">First item</li><li style="list-style-type:upper-roman">Second item</li><li style="list-style-type:upper-roman">Third item</li></ol><ol><li style="list-style-type:decimal-leading-zero">First item</li><li style="list-style-type:decimal-leading-zero">Second item</li><li style="list-style-type:decimal-leading-zero">Third item</li></ol>');

    }//end testOrderedListsFormatsFromGoogleDocWithAggressiveModeOff()


    /**
     * Test that copying/pasting from the OrderedListsFormats google doc works correctly with aggressive mode on.
     *
     * @return void
     */
    public function testOrderedListsFormatsFromGoogleDocWithAggressiveModeOn()
    {
        $this->copyAndPasteFromGoogleDocs('OrderedListsFormats.txt', '<ol><li style="list-style-type:decimal">First item</li><li style="list-style-type:decimal">Second item</li><li style="list-style-type:decimal">Third Item</li></ol><ol><li style="list-style-type:decimal">First item</li><li style="list-style-type:decimal">Second item</li><li style="list-style-type:decimal">Third Item</li></ol><ol><li style="list-style-type:upper-alpha">First item</li><li style="list-style-type:upper-alpha">Second item</li><li style="list-style-type:upper-alpha">Third item</li></ol><ol><li style="list-style-type:upper-roman">First item</li><li style="list-style-type:upper-roman">Second item</li><li style="list-style-type:upper-roman">Third item</li></ol><ol><li style="list-style-type:decimal-leading-zero">First item</li><li style="list-style-type:decimal-leading-zero">Second item</li><li style="list-style-type:decimal-leading-zero">Third item</li></ol>');

    }//end testOrderedListsFormatsFromGoogleDocWithAggressiveModeOn()

}//end class

?>