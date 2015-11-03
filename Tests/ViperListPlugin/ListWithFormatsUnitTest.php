<?php

require_once 'AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperListPlugin_ListWithFormatsUnitTest extends AbstractViperListPluginUnitTest
{


	/**
     * Test that a paragraph is created after a list and before a div.
     *
     * @return void
     */
    public function testCreatingParagraphAfterListBeforeADiv()
    {
        $this->useTest(1);

        //Test unordered list
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New paragraph');

        // Press the down arrow to make sure IE doesn't throw an exception
        $this->sikuli->keyDown('Key.DOWN');

        sleep(1);
        $this->assertHTMLMatch('<p>Unordered lists:</p><ul><li>Item 1</li><li>Item 2 %1%</li></ul><p>New paragraph</p><div>Test div</div><p>Ordered lists:</p><ol><li>Item 1</li><li>Item 2 %2%</li></ol><div>Test div %3%</div><div>Long paragraph for testing that the list icons appear in the top toolbar. %4%</div>');

        //Test ordered list
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New paragraph');

        // Press the down arrow to make sure IE doesn't throw an exception
        $this->sikuli->keyDown('Key.DOWN');

        sleep(1);
        $this->assertHTMLMatch('<p>Unordered lists:</p><ul><li>Item 1</li><li>Item 2 %1%</li></ul><p>New paragraph</p><div>Test div</div><p>Ordered lists:</p><ol><li>Item 1</li><li>Item 2 %2%</li></ol><p>New paragraph</p><div>Test div %3%</div><div>Long paragraph for testing that the list icons appear in the top toolbar. %4%</div>');

    }//end testCreatingParagraphAfterListBeforeADiv()


    /**
     * Test that list tools are not available for a div section.
     *
     * @return void
     */
    public function testListToolsAreNotAvailableForADiv()
    {
        $this->useTest(1);

        // Test single line div
        $this->clickKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        // Test multi-line div
        $this->clickKeyword(4);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(4);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListToolsAreNotAvailableForADiv()


    /**
     * Test that a paragraph is created after a list and before a Pre.
     *
     * @return void
     */
    public function testCreatingParagraphAfterListBeforeAPre()
    {
        $this->useTest(2); 

        //Test unordered list
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New paragraph');

        // Press the down arrow to make sure IE doesn't throw an exception
        $this->sikuli->keyDown('Key.DOWN');

        sleep(1);
        $this->assertHTMLMatch('<p>Unordered lists:</p><ul><li>Item 1</li><li>Item 2 %1%</li></ul><p>New paragraph</p><pre>Test pre</pre><p>Ordered lists:</p><ol><li>Item 1</li><li>Item 2 %2%</li></ol><pre>Test pre %3%</pre><pre>Long paragraph for testing that the list icons appear in...... %4%</pre>');

        //Test ordered list
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New paragraph');

        // Press the down arrow to make sure IE doesn't throw an exception
        $this->sikuli->keyDown('Key.DOWN');

        sleep(1);
        $this->assertHTMLMatch('<p>Unordered lists:</p><ul><li>Item 1</li><li>Item 2 %1%</li></ul><p>New paragraph</p><pre>Test pre</pre><p>Ordered lists:</p><ol><li>Item 1</li><li>Item 2 %2%</li></ol><p>New paragraph</p><pre>Test pre %3%</pre><pre>Long paragraph for testing that the list icons appear in...... %4%</pre>');

    }//end testCreatingParagraphAfterListBeforeAPre()


    /**
     * Test that list tools are not available for a pre section.
     *
     * @return void
     */
    public function testListToolsAreNotAvailableForAPre()
    {
        $this->useTest(2);

        // Test single line pre
        $this->clickKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test multi-line pre
        $this->clickKeyword(4);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(4);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

    }//end testListToolsAreNotAvailableForAPre()


    /**
     * Test that a paragraph is created after a list and before a quote.
     *
     * @return void
     */
    public function testCreatingParagraphAfterListBeforeAQuote()
    {
        $this->useTest(3);

        //Test unordered list
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New paragraph');

        // Press the down arrow to make sure IE doesn't throw an exception
        $this->sikuli->keyDown('Key.DOWN');

        sleep(1);
        $this->assertHTMLMatch('<p>Unordered lists:</p><ul><li>Item 1</li><li>Item 2 %1%</li></ul><p>New paragraph</p><blockquote><p>Test blockquote</p></blockquote><p>Ordered lists:</p><ol><li>Item 1</li><li>Item 2 %2%</li></ol><blockquote><p>Test blockquote %3%</p></blockquote><blockquote><p>Long paragraph for testing that the list icons appear in the top toolbar. %4%</p></blockquote><blockquote><p>test1 test2 test3 sit amet %5%</p><p>Long paragraph for testing that the list icons appear in the top toolbar. %6%</p></blockquote>');

        //Test ordered list
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New paragraph');

        // Press the down arrow to make sure IE doesn't throw an exception
        $this->sikuli->keyDown('Key.DOWN');

        sleep(1);
        $this->assertHTMLMatch('<p>Unordered lists:</p><ul><li>Item 1</li><li>Item 2 %1%</li></ul><p>New paragraph</p><blockquote><p>Test blockquote</p></blockquote><p>Ordered lists:</p><ol><li>Item 1</li><li>Item 2 %2%</li></ol><p>New paragraph</p><blockquote><p>Test blockquote %3%</p></blockquote><blockquote><p>Long paragraph for testing that the list icons appear in the top toolbar. %4%</p></blockquote><blockquote><p>test1 test2 test3 sit amet %5%</p><p>Long paragraph for testing that the list icons appear in the top toolbar. %6%</p></blockquote>');

    }//end testCreatingParagraphAfterListBeforeAQuote()


    /**
     * Test that list tools are not available for a quote section.
     *
     * @return void
     */
    public function testListToolsAreNotAvailableForAQuote()
    {
        $this->useTest(3);

        // Test single line quote
        $this->clickKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test multi-line quote
        $this->clickKeyword(4);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(4);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test quote section inside multiple P's
        $this->clickKeyword(5);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(5);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(5, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->clickKeyword(6);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(6);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(6, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

    }//end testListToolsAreNotAvailableForAQuote()


    /**
     * Test that a paragraph is created after a list and before a paragraph.
     *
     * @return void
     */
    public function testCreatingParagraphAfterListBeforeAParagraph()
    {
        $this->useTest(4);

        //Test unordered
        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New paragraph');

        // Press the down arrow to make sure IE doesn't throw an exception
        $this->sikuli->keyDown('Key.DOWN');
        $this->assertHTMLMatch('<p>Unordered lists:</p><ul><li>Item 1</li><li>Item 2 %1%</li></ul><p>New paragraph</p><p>Test para</p><p>Ordered lists:</p><ol><li>Item 1</li><li>Item 2 %2%</li></ol><p>Test para %3%</p><p>Long paragraph for testing that the list icons appear in the top toolbar. %4%</p>');

        //Test ordered
        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->sikuli->keyDown('Key.ENTER');
        $this->type('New paragraph');

        // Press the down arrow to make sure IE doesn't throw an exception
        $this->sikuli->keyDown('Key.DOWN');
        $this->assertHTMLMatch('<p>Unordered lists:</p><ul><li>Item 1</li><li>Item 2 %1%</li></ul><p>New paragraph</p><p>Test para</p><p>Ordered lists:</p><ol><li>Item 1</li><li>Item 2 %2%</li></ol><p>New paragraph</p><p>Test para %3%</p><p>Long paragraph for testing that the list icons appear in the top toolbar. %4%</p>');

    }//end testCreatingParagraphAfterListBeforeAParagraph()


    /**
     * Test that list tools are available for a paragraph.
     *
     * @return void
     */
    public function testListToolsAvailableForAParagraph()
    {
        $this->useTest(4);

        // Test single line paragraph
        $this->clickKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        // Test multi-line paragraph
        $this->clickKeyword(4);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectKeyword(4);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->moveToKeyword(4, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListToolsAvailableForAParagraph()


    /**
     * Test that list tools are available for P sections inside a Div section.
     *
     * @return void
     */
    public function testListToolsAvailableForPSectionsInsideDivSection()
    {
        $this->useTest(5);

        // Test one P inside a Div
        $this->moveToKeyword(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        // Test two P's inside a div
        $this->moveToKeyword(2);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->moveToKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListToolsAvailableForPSectionsInsideDivSection()


    /**
     * Test that list tools are not available for Div sections inside a Div section.
     *
     * @return void
     */
    public function testListToolsNotAvailableForDivSectionsInsideDivSection()
    {
        $this->useTest(6);

        // Test one Div inside a Div
        $this->clickKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        // Test two P's inside a div
        $this->clickKeyword(2);
        sleep(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        sleep(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        sleep(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(2, 'right');
        sleep(2);
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

        $this->clickKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        sleep(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, NULL);

    }//end testListToolsAvailableForPSectionsInsideDivSection()


    /**
     * Test that list tools are not available for quote sections inside a Div section.
     *
     * @return void
     */
    public function testListToolsNotAvailableForQuoteSectionsInsideDivSection()
    {
        $this->useTest(7);

        // Test one quote inside a Div
        $this->clickKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test two quote's inside a div
        $this->clickKeyword(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->clickKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

    }//end testListToolsNotAvailableForQuoteSectionsInsideDivSection()


    /**
     * Test that list tools are not available for Pre sections inside a Div section.
     *
     * @return void
     */
    public function testListToolsNotAvailableForPreSectionsInsideDivSection()
    {
        $this->useTest(8);

        // Test one Pre inside a Div
        $this->clickKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(1, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        // Test two Pre's inside a div
        $this->clickKeyword(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(2);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(2, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->clickKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectKeyword(3);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(1);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->selectInlineToolbarLineageItem(0);
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

        $this->moveToKeyword(3, 'right');
        $this->sikuli->keyDown('Key.ENTER');
        $this->assertIconStatusesCorrect(NULL, NULL, NULL, NULL);

    }//end testListToolsNotAvailableForPreSectionsInsideDivSection()

}