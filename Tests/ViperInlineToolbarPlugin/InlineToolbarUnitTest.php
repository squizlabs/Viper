<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperInlineToolbarPlugin_InlineToolbarUnitTest extends AbstractViperUnitTest
{


    /**
     * Returns the match variable for the toolbar arrow.
     *
     * @param integer $orientation The orientation of the inline toolbar
     *                             (left, right or NULL for center).
     *
     * @return string
     */
    private function _getToolbarArrow($orientation=NULL)
    {

        $arrowImg = 'vitp_arrow';

        if ($orientation === 'left') {
            $arrowImg .= 'Left';
        } else if ($orientation === 'right') {
            $arrowImg .= 'Right';
        }

        $arrowImg .= '.png';

        return $this->find($this->getBrowserImagePath().'/'.$arrowImg, NULL, 0.95);

    }//end _getToolbarArrow()


    /**
     * Returns the center location of the toolbar arrow.
     *
     * @param integer $orientation The orientation of the inline toolbar
     *                             (left, right or NULL for center).
     *
     * @return string
     */
    private function _getToolbarArrowLocation($orientation=NULL)
    {
        $loc = $this->getCenter($this->_getToolbarArrow($orientation));
        return $loc;

    }//end _getToolbarArrowLocation()


    /**
     * Asserts that the position of the inline toolbar is correct.
     *
     * @param integer $targetX     The X position.
     * @param integer $targetY     The Y position.
     * @param integer $orientation The orientation of the inline toolbar
     *                             (left, right or NULL for center).
     *
     * @return void
     */
    private function _assertPosition($targetX, $targetY, $orientation=NULL)
    {
        $toolbarX = $this->getX($this->_getToolbarArrowLocation($orientation));
        $diff     = abs($targetX - $toolbarX);
        $this->assertTrue(($diff <= 4), 'X Position of toolbar arrow is incorrect. Difference was '.$diff.' pixels');

        $toolbarY = $this->getY($this->getTopLeft($this->_getToolbarArrow($orientation)));
        $diff     = abs($targetY - $toolbarY);
        $this->assertTrue(($diff <= 15), 'Y Position of toolbar arrow is incorrect. Difference was '.$diff.' pixels');

    }//end _assertPosition()


    /**
     * Test that VITP is not shown when page is loaded.
     *
     * @return void
     */
    public function testNoToolbarAtStart()
    {
        try {
            $this->getInlineToolbar();
        } catch (Exception $e) {
            return;
        }

        $this->fail('There should be no inline toolbar on page load.');

    }//end testNoToolbarAtStart()


    /**
     * Test that VITP is positioned correctly for a simple word selection.
     *
     * @return void
     */
    public function testSimpleSelectionPosition()
    {
        $word = $this->findKeyword(2);
        $this->selectKeyword(2);

        $wordX = $this->getX($this->getCenter($word));
        $wordY = $this->getY($this->getBottomLeft($word));
        $this->_assertPosition($wordX, $wordY);

    }//end testSimpleSelectionPosition()


    /**
     * Test that VITP is positioned correctly for a paragraph selection.
     *
     * @return void
     */
    public function testParagraphSelectionPosition()
    {
        $para = $this->findKeyword(4);
        $this->selectKeyword(4);

        $bottomLeft = $this->getBottomLeft($para);
        $wordY      = $this->getY($bottomLeft);

        // Add 400 (width of the Paragraph divided by 2).
        $wordX = ($this->getX($bottomLeft) + 400);
        $this->_assertPosition($wordX, $wordY);

    }//end testParagraphSelectionPosition()


    /**
     * Test that VITP is positioned correctly for multiple paragraph selection.
     *
     * @return void
     */
    public function testMultiParagraphSelectionPosition()
    {
        $start = $this->findKeyword(1);
        $end   = $this->findKeyword(4);
        $this->selectKeyword(1, 4);

        $leftX  = ($this->getX($this->getTopLeft($start)));
        $width  = ($this->execJS('dfx.getElementWidth(dfx.getId("content"))') / 2);
        $center = ($leftX + $width);
        $wordY  = $this->getY($this->getBottomLeft($end));
        $this->_assertPosition($center, $wordY);

    }//end testMultiParagraphSelectionPosition()


    /**
     * Test that VITP is positioned correctly for multiple paragraph selection.
     *
     * @return void
     */
    public function testPositionAfterWindowResize()
    {
        $this->selectKeyword(2);
        $this->resizeWindow(1600, 800);

        $word = $this->findKeyword(2);

        $wordX = $this->getX($this->getCenter($word));
        $wordY = $this->getY($this->getBottomLeft($word));

        $this->_assertPosition($wordX, $wordY);

    }//end testPositionAfterWindowResize()


    /**
     * Test that VITP does not close when mouse is clicked on it.
     *
     * @return void
     */
    public function testPositionOrientationLeft()
    {
        $this->execJS('viperTest.getWindow().dfx.setStyle(viperTest.getWindow().dfx.getId("content"), "margin-left", "10px")');

        $word = $this->findKeyword(1);
        $this->selectKeyword(1);
        sleep(1);

        $wordX = $this->getX($this->getCenter($word));
        $wordY = $this->getY($this->getBottomLeft($word));
        $this->_assertPosition($wordX, $wordY, 'left');

    }//end testPositionOrientationLeft()


    /**
     * Test that VITP does not close when mouse is clicked on it.
     *
     * @return void
     */
    public function testPositionOrientationRight()
    {
        $this->resizeWindow(1100, 800);

        $word = $this->findKeyword(5);
        $this->selectKeyword(5);

        $wordX = $this->getX($this->getCenter($word));
        $wordY = $this->getY($this->getBottomLeft($word));
        $this->_assertPosition($wordX, $wordY, 'right');

    }//end testPositionOrientationRight()


    /**
     * Test that VITP is removed when mouse is clicked in content.
     *
     * @return void
     */
    public function testHideOnClick()
    {
        $word = $this->findKeyword(1);
        $this->selectKeyword(1);
        $this->click($word);
        sleep(2);

        try {
            $this->getInlineToolbar();
        } catch (Exception $e) {
            return;
        }

        $this->fail('There should be no inline toolbar when there is no selection after a click.');

    }//end testHideOnClick()


    /**
     * Test that VITP is hidden when caret is moved using keyboard.
     *
     * @return void
     */
    public function testHideOnCaretMove()
    {
        $this->moveToKeyword(1, 'right');
        sleep(2);

        try {
            $this->getInlineToolbar();
        } catch (Exception $e) {
            return;
        }

        $this->fail('There should be no inline toolbar when there is no selection after keyboard navigation.');

    }//end testHideOnCaretMove()


    /**
     * Test that VITP lineage is correct when there is only one parent and a selection.
     *
     * @return void
     */
    public function testLineageOneParent()
    {
        $this->selectKeyword(1);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageOneParent()


    /**
     * Test that VITP lineage is correct when there are more than one parent in same paragraph.
     *
     * @return void
     */
    public function testLineageMultiParentSameParagraph()
    {
        $this->selectKeyword(7);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageMultiParentSameParagraph()


    /**
     * Test that VITP lineage is correct when a whole node is selected, e.g. not show 'Selection'.
     *
     * @return void
     */
    public function testLineageNodeSelection()
    {
        $this->selectKeyword(7, 8);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Bold</li>', $lineage);

    }//end testLineageNodeSelection()


    /**
     * Test that VITP lineage is correct when multiple parents are selected in the same paragraph.
     *
     * @return void
     */
    public function testLineageDiffParentSameParagraph()
    {
        $this->selectKeyword(6, 7);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageDiffParentSameParagraph()


    /**
     * Test that VITP lineage is correct when multiple parents are selected in different paragraphs.
     *
     * @return void
     */
    public function testLineageMultiParentDiffParagraph()
    {
        $this->selectKeyword(1, 6);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testLineageMultiParentDiffParagraph()


    /**
     * Test that VITP does not close when mouse is clicked on it.
     *
     * @return void
     */
    public function testClickOnToolbarNotHideToolbar()
    {
        $this->selectKeyword(1);

        $this->click($this->_getToolbarArrow());
        sleep(2);
        $this->getInlineToolbar();

    }//end testClickOnToolbarNotHideToolbar()


    /**
     * Test that you can switch between a selection and paragraph when the sub toolbar is open.
     *
     * @return void
     */
    public function testSwitchingFromSelectionToParagraphWhenSubToolbarIsOpen()
    {
        $this->selectKeyword(2);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->clickInlineToolbarButton('cssClass');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals($this->replaceKeywords('%1% %2% dolor'), $this->getSelectedText(), 'P tag is not selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

    }//end testSwitchingFromSelectionToParagraphWhenSubToolbarIsOpen()


    /**
     * Test that you can switch between a paragraph and selection when the sub toolbar is open.
     *
     * @return void
     */
    public function testSwitchingFromParagraphToSelectionWhenSubToolbarIsOpen()
    {
        $this->selectKeyword(1);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('cssClass');
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->assertEquals($this->replaceKeywords('%1%'), $this->getSelectedText(), 'P tag is selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testSwitchingFromParagraphToSelectionWhenSubToolbarIsOpen()


}//end class

?>
