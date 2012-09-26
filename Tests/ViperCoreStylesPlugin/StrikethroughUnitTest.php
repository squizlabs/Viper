<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_StrikethroughUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that style can be applied to the selection at start of a paragraph.
     *
     * @return void
     */
    public function testStartOfParaStrikethrough()
    {
        $this->selectKeyword(1);

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p><del>%1%</del> %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testStartOfParaStrikethrough()


    /**
     * Test that style can be applied to middle of a paragraph.
     *
     * @return void
     */
    public function testMidOfParaStrikethrough()
    {
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testMidOfParaStrikethrough()


    /**
     * Test that style can be applied to the end of a paragraph.
     *
     * @return void
     */
    public function testEndOfParaStrikethrough()
    {
        $this->selectKeyword(3);

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% %2% <del>%3%</del></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testEndOfParaStrikethrough()


    /**
     * Test that strikethrough is applied to two words and then removed from one word.
     *
     * @return void
     */
    public function testRemovingFormatFromPartOfTheContent()
    {
        $this->selectKeyword(2, 3);

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <del>%2% %3%</del></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->selectKeyword(3);

        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon in the top toolbar is still active');

        $this->assertHTMLMatch('<p>%1% <del>%2% </del>%3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

    }//end testRemovingFormatFromPartOfTheContent()


    /**
     * Test that correct HTML is produced when adjacent words are styled.
     *
     * @return void
     */
    public function testAdjacentWordStyling()
    {
        $this->selectKeyword(2);
        $this->clickTopToolbarButton('strikethrough');

        $this->selectKeyword(1, 2);
        $this->clickTopToolbarButton('strikethrough');

        $this->selectKeyword(2, 3);
        $this->clickTopToolbarButton('strikethrough');

        $this->assertHTMLMatch('<p><del>%1% %2% %3%</del></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testAdjacentWordStyling()


    /**
     * Test that correct HTML is produced when words separated by space are styled.
     *
     * @return void
     */
    public function testSpaceSeparatedAdjacentWordStyling()
    {
        $this->selectKeyword(2);
         $this->clickTopToolbarButton('strikethrough');

        $this->selectKeyword(1);
        $this->clickTopToolbarButton('strikethrough');

        $this->selectKeyword(3);
        $this->clickTopToolbarButton('strikethrough');

        $this->assertHTMLMatch('<p><del>%1%</del> <del>%2%</del> <del>%3%</del></p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testSpaceSeparatedAdjacentWordStyling()


    /**
     * Test that strikethrough can be removed.
     *
     * @return void
     */
    public function testRemoveFormating()
    {
        $this->selectKeyword(5);

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong><del>%5%</del></strong></p>');

        $this->selectKeyword(5);

        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough'), 'Strikethrough icon is still active in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testRemoveFormating()


    /**
     * Test that the Strikethrough icon is active when you select a word that has strikethrough applied.
     *
     * @return void
     */
    public function testIconsIsActive()
    {
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

        $this->selectKeyword(2);
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Strikethrough icon in the top toolbar is not active');

    }//end testIconsIsActive()


    /**
     * Test that you can undo strikethrough after you have applied it and then redo it.
     *
     * @return void
     */
    public function testUndoAndRedoStrikethrough()
    {
        $this->selectKeyword(2);

        $this->clickTopToolbarButton('strikethrough');
        $this->assertTrue($this->topToolbarButtonExists('strikethrough', 'active'), 'Subscript icon in the top toolbar is not active');

        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyUndo');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

        $this->clickTopToolbarButton('historyRedo');
        $this->assertHTMLMatch('<p>%1% <del>%2%</del> %3%</p><p>sit <em>%4%</em> <strong>%5%</strong></p>');

    }//end testUndoAndRedoStrikethrough()

}//end class

?>
