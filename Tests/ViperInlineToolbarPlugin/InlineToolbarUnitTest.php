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
        $img = 'arrow_up';
        if ($orientation !== NULL) {
            $img .= '_'.$orientation;
        }

        $toolbarPattern = $this->createPattern(dirname(__FILE__).'/Images/'.$img.'.png');
        $toolbarPattern = $this->similar($toolbarPattern, 0.90);

        $toolbar = $this->find($toolbarPattern);
        return $toolbar;

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
        $this->assertTrue(($diff <= 2), 'X Position of toolbar arrow is incorrect. Difference was '.$diff.' pixels');

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
        $word = $this->find('Lorem');
        $this->selectText('Lorem');

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
        $para = $this->find('AbC');
        $this->selectText('AbC');

        $wordY = $this->getY($this->getBottomLeft($para));
        $wordX = $this->getX($this->getCenter($para));
        $this->_assertPosition($wordX, $wordY);

    }//end testParagraphSelectionPosition()


    /**
     * Test that VITP is positioned correctly for multiple paragraph selection.
     *
     * @return void
     */
    public function testMultiParagraphSelectionPosition()
    {
        $start = $this->find('Lorem');
        $end   = $this->find('Cat');
        $this->selectText('Lorem', 'Cat');

        $leftX  = $this->getX($this->getTopLeft($start));
        $width  = ($this->execJS('dfx.getElementWidth(dfxjQuery("p")[0])') / 2);
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
        $this->selectText('Lorem');
        $this->resizeWindow(1600, 800);

        $word = $this->find('Lorem');

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
        $this->resizeWindow(1100, 800);

        $word = $this->find('Lorem');
        $this->selectText('Lorem');

        $wordX = $this->getX($this->getCenter($word));
        $wordY = $this->getY($this->getBottomLeft($word));
        $this->_assertPosition($wordX, $wordY);

        try {
            $this->find(dirname(__FILE__).'/Images/toolbarLeft.png', NULL, 0.83);
        } catch (Exception $e) {
            $this->fail('Left side of the toolbar is off screen');
        }

    }//end testPositionOrientationLeft()


    /**
     * Test that VITP does not close when mouse is clicked on it.
     *
     * @return void
     */
    public function testPositionOrientationRight()
    {
        $this->resizeWindow(1100, 800);

        $word = $this->find('Goat');
        $this->selectText('Goat');

        $wordX = $this->getX($this->getCenter($word));
        $wordY = $this->getY($this->getBottomLeft($word));
        $this->_assertPosition($wordX, $wordY, 'right');

        try {
            $this->find(dirname(__FILE__).'/Images/toolbarRight.png', NULL, 0.83);
        } catch (Exception $e) {
            $this->fail('Right side of the toolbar is off screen');
        }

    }//end testPositionOrientationRight()


    /**
     * Test that VITP is removed when mouse is clicked in content.
     *
     * @return void
     */
    public function testHideOnClick()
    {
        $word = $this->find('Lorem');
        $this->selectText('Lorem');
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
        $this->selectText('Lorem');
        $this->keyDown('Key.RIGHT');
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
        $this->selectText('Lorem');

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
        $this->selectText('Xyz');

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
        $this->selectText('XyZ', 'DFG');

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
        $this->selectText('ZON', 'XyZ');

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
        $this->selectText('Lorem', 'ZON');

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
        $this->selectText('Lorem');

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
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('IPSUM');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->selectInlineToolbarLineageItem(0);
        $this->assertEquals('Lorem IPSUM dolor', $this->getSelectedText(), 'P tag is not selected');
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
        $this->markTestIncomplete('Fails for some reason. Have reported this in issue 1764');

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->selectInlineToolbarLineageItem(1);
        sleep(1);
        $this->assertEquals('IPSUM', $this->getSelectedText(), 'P tag is selected');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

    }//end testSwitchingFromParagraphToSelectionWhenSubToolbarIsOpen()


}//end class

?>
