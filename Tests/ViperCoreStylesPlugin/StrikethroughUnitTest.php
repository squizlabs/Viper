<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_StrikethroughUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that strikethrough can be applied and removed to different parts of a paragraph.
     *
     * @return void
     */
    public function testApplyAndRemoveStrikethrough()
    {
        // Apply and remove at the start of a paragraph
        $this->usetest(1);
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p><del>%1%</del> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Apply and remove in the middle of a paragraph
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Apply and remove at the end of a paragraph
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% %2% <del>%3%</del></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');



    }//end testStartOfParaStrikethrough()


    /**
     * Test that strikethrough is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemoveStrikethroughFromPartOfTheContent()
    {
        // Apply format to multiple keywords
        $this->usetest(1);
        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% <del>%2% %3%</del></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove from one keyword
        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is still active');
        $this->assertHTMLMatch('<p>%1% <del>%2% </del>%3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        // Remove from second keyword
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testRemoveStrikethroughFromPartOfTheContent()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentStrikethroughStyling()
    {
        $this->usetest(1);
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough');

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('strikethrough');

        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('strikethrough');

        $this->assertHTMLMatch('<p><del>%1% %2% %3%</del></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAdjacentStrikethroughStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedStrikethroughStyling()
    {
        $this->usetest(1);        
        $this->selectKeyword(2);
         $this->clickTopToolbarButton('strikethrough');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough');

        $this->assertHTMLMatch('<p><del>%1%</del> <del>%2%</del> <del>%3%</del></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testSpaceSeparatedStrikethroughStyling()


    /**
     * Test that you can undo strikethrough after you have applied it and then redo it.
     *
     * @return void
     */
    public function testUndoAndRedoStrikethrough()
    {
        $this->usetest(1);        
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testUndoAndRedoStrikethrough()


     /**
     * Test applying and removing strikethrough for a link in the content of a page.
     *
     * @return void
     */
    public function testAddAndRemoveStrikethroughForLink()
    {
        $this->useTest(2);

        $this->moveToKeyword(1);
        $this->selectInlineToolbarLineageItem(1);
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com"><del>%1%</del></a> more test content.</p>');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'strikethrough icon should be active');

        $this->moveToKeyword(1);
        sleep(1);
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->clickTopToolbarButton('strikethrough', 'active');
        sleep(1);
        $this->assertHTMLMatch('<p>Test content <a href="http://www.squizlabs.com">%1%</a> more test content.</p>');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'strikethrough icon should not be active');

    }//end testAddAndRemoveStrikethroughForLink()

}//end class

?>
