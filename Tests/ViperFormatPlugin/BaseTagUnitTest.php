<?php

require_once 'AbstractFormatsUnitTest.php';

class Viper_Tests_ViperFormatPlugin_BaseTagUnitTest extends AbstractFormatsUnitTest
{


    /**
     * Test that format conversions work fine with defaultBlockTag set as P.
     *
     * @return void
     */
    public function testBaseTagAsPConversions()
    {
        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('P', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% %2%</p>');

        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, NULL, 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% test</p><p>test %2%</p>');

        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% %2%</p><div>test test</div>');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% %2%</p>');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% %2%</p>');

        $this->useTest(6);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, NULL, 'disabled');
        $this->assertHTMLMatch('<p>%1% %2%</p><p>test test</p>');

        $this->useTest(7);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->assertHTMLMatch('<p>%1% %2%</p><div>test test</div><p>test1 test2<br />test3 test4</p><p>test</p>');

    }//end testBaseTagAsPConversions()


    /**
     * Test that format conversions work fine with defaultBlockTag set as nothing.
     *
     * @return void
     */
    public function testNoBaseTagConversions()
    {
        $this->execJS('viper.setSetting("defaultBlockTag", "")');

        $this->useTest(1);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('P', 'active', TRUE);
        $this->assertHTMLMatch('%1% %2%');

        $this->useTest(2);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, NULL, 'disabled');
        $this->clickTopToolbarButton('DIV', NULL, TRUE);
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% test</p><p>test %2%</p>');

        $this->useTest(3);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->checkStatusOfFormatIconsInTheInlineToolbar('active', NULL, NULL, NULL);
        $this->clickTopToolbarButton('Quote', NULL, TRUE);
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->assertHTMLMatch('<p>%1% %2%</p><div>test test</div>');

        $this->useTest(4);
        $this->selectKeyword(1, 2);
        $this->clickInlineToolbarButton('formats-div', 'active');
        $this->clickInlineToolbarButton('DIV', 'active', TRUE);
        $this->clickTopToolbarButton('formats');
        $this->checkStatusOfFormatIconsInTheTopToolbar(NULL, NULL, NULL, NULL);
        $this->assertHTMLMatch('%1% %2%');

        $this->useTest(5);
        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('formats-blockquote', 'active');
        $this->clickTopToolbarButton('Quote', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('active', NULL, NULL, NULL);
        $this->assertHTMLMatch('<p>%1% %2%</p>');

        $this->useTest(6);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, NULL, 'disabled');
        $this->assertHTMLMatch('%1% %2%<p>test test</p>');

        $this->useTest(7);
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-div', 'active');
        $this->clickTopToolbarButton('DIV', 'active', TRUE);
        $this->checkStatusOfFormatIconsInTheTopToolbar('disabled', NULL, 'disabled', 'disabled');
        $this->assertHTMLMatch('%1% %2% <div>test test</div> test1 test2<br />test3 test4<p>test</p>');

    }//end testNoBaseTagConversions()


}//end class

?>
