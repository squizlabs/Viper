<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperInlineToolbarPlugin_InlineToolbarUnitTest extends AbstractViperUnitTest
{


    /**
     * Returns the match variable for the toolbar arrow.
     *
     * @return string
     */
    private function _getToolbarArrow($pos=NULL)
    {
        $img = 'arrow_up';
        if ($pos !== NULL) {
            $img .= '_'.$pos;
        }

        $toolbarPattern = $this->createPattern(dirname(__FILE__).'/Images/'.$img.'.png');
        $toolbarPattern = $this->similar($toolbarPattern, 0.90);

        $toolbar = $this->find($toolbarPattern);
        return $toolbar;

    }//end _getToolbarArrow()


    /**
     * Returns the center location of the toolbar arrow.
     *
     * @return string
     */
    private function _getToolbarArrowLocation($pos=NULL)
    {
        $loc = $this->getCenter($this->_getToolbarArrow($pos));
        return $loc;

    }//end _getToolbarArrowLocation()


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

        $wordX    = $this->getX($this->getCenter($word));
        $toolbarX = $this->getX($this->_getToolbarArrowLocation());

        $this->assertTrue(($wordX + 2 > $toolbarX) || ($wordX - 2 < $toolbarX), 'X Position of toolbar arrow is incorrect.');

        $wordY    = $this->getY($this->getBottomLeft($word));
        $toolbarY = $this->getY($this->getTopLeft($this->_getToolbarArrow()));

        $this->assertTrue(($wordY + 10 < $toolbarY) && ($wordY + 15 > $toolbarY), 'Y Position of toolbar arrow is incorrect.');

    }//end testSimpleSelectionPosition()


    /**
     * Test that VITP is positioned correctly for a paragraph selection.
     *
     * @return void
     */
    public function testParagraphSelectionPosition()
    {
        $para = $this->find('ABC');
        $this->selectText('ABC');

        $wordY    = $this->getY($this->getBottomLeft($para));
        $toolbarY = $this->getY($this->getTopLeft($this->_getToolbarArrow()));
        $this->assertTrue(($wordY + 10 < $toolbarY) && ($wordY + 15 > $toolbarY), 'Y Position of toolbar arrow is incorrect.');

        $wordLoc = $this->getCenter($para);
        $this->assertEquals($this->getX($wordLoc), $this->getX($this->_getToolbarArrowLocation()), 'X Position of toolbar arrow is incorrect.');

    }//end testParagraphSelectionPosition()


    /**
     * Test that VITP is positioned correctly for multiple paragraph selection.
     *
     * @return void
     */
    public function testMultiParagraphSelectionPosition()
    {
        $start = $this->find('Lorem');
        $end   = $this->find('consectetur');
        $this->selectText('Lorem', 'consectetur');

        $leftX  = $this->getX($this->getTopLeft($start));
        $rightX = $this->getX($this->getTopRight($end));
        $center = ($leftX + (($rightX - $leftX) / 2));

        $wordY    = $this->getY($this->getBottomLeft($end));
        $toolbarY = $this->getY($this->getTopLeft($this->_getToolbarArrow()));
        $this->assertTrue(($wordY + 10 < $toolbarY) && ($wordY + 15 > $toolbarY), 'Y Position of toolbar arrow is incorrect.');

        $toolbarX = $this->getX($this->_getToolbarArrowLocation());
        $this->assertTrue(($center + 2 > $toolbarX) || ($center - 2 < $toolbarX), 'X Position of toolbar arrow is incorrect.');

    }//end testMultiParagraphSelectionPosition()


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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageOneParent()


    /**
     * Test that VITP lineage is correct when there are more than one parent in same paragraph.
     *
     * @return void
     */
    public function testLineageMultiParentSameParagraph()
    {
        $this->selectText('XYZ');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageMultiParentSameParagraph()


    /**
     * Test that VITP lineage is correct when a whole node is selected, e.g. not show 'Selection'.
     *
     * @return void
     */
    public function testLineageNodeSelection()
    {
        $this->selectText('consectetur');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

    }//end testLineageNodeSelection()


    /**
     * Test that VITP lineage is correct when multiple parents are selected in the same paragraph.
     *
     * @return void
     */
    public function testLineageDiffParentSameParagraph()
    {
        $this->selectText('ZON', 'XYZ');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

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
        $this->assertEquals('<li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

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
     * Test that VITP does not close when mouse is clicked on it.
     *
     * @return void
     */
    public function testPositionOrientationLeft()
    {
        $this->resizeWindow(1100, 800);

        $word = $this->find('Lorem');
        $this->selectText('Lorem');

        $wordX    = $this->getX($this->getCenter($word));
        $toolbarX = $this->getX($this->_getToolbarArrowLocation());
        $this->assertTrue(($wordX + 2 > $toolbarX) || ($wordX - 2 < $toolbarX), 'X Position of toolbar arrow is incorrect.');

        $wordY    = $this->getY($this->getBottomLeft($word));
        $toolbarY = $this->getY($this->getTopLeft($this->_getToolbarArrow()));
        $this->assertTrue(($wordY + 10 < $toolbarY) && ($wordY + 15 > $toolbarY), 'Y Position of toolbar arrow is incorrect.');

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

        $word = $this->find('GUX');
        $this->selectText('GUX');

        $wordX    = $this->getX($this->getCenter($word));
        $toolbarX = $this->getX($this->_getToolbarArrowLocation('right'));
        $this->assertTrue(($wordX + 2 > $toolbarX) || ($wordX - 2 < $toolbarX), 'X Position of toolbar arrow is incorrect.');

        $wordY    = $this->getY($this->getBottomLeft($word));
        $toolbarY = $this->getY($this->getTopLeft($this->_getToolbarArrow('right')));
        $this->assertTrue(($wordY + 10 < $toolbarY) && ($wordY + 15 > $toolbarY), 'Y Position of toolbar arrow is incorrect.');

        try {
            $this->find(dirname(__FILE__).'/Images/toolbarRight.png', NULL, 0.83);
        } catch (Exception $e) {
            $this->fail('Right side of the toolbar is off screen');
        }

    }//end testPositionOrientationRight()


}//end class

?>
