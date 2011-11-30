<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperInlineToolbarPlugin_InlineToolbarUnitTest extends AbstractViperUnitTest
{

    private function _getToolbarArrow()
    {
        $toolbarPattern = $this->createPattern(dirname(__FILE__).'/Images/arrow_up.png');
        $toolbarPattern = $this->similar($toolbarPattern, 0.90);

        $toolbar = $this->find($toolbarPattern);
        return $toolbar;

    }//end

    private function _getToolbarArrowLocation()
    {
        $loc = $this->getCenter($this->_getToolbarArrow());
        return $loc;

    }//end


    /**
     * Test for inline toolbar.
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
     * Test for inline toolbar.
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
     * Test for inline toolbar.
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
     * Test for inline toolbar.
     *
     * @return void
     */
    public function testMultiParagraphSelectionPosition()
    {
        $start = $this->find('Lorem');
        $end = $this->find('consectetur');
        $this->selectText('Lorem', 'consectetur');

        $leftX  = $this->getX($this->getTopLeft($start));
        $rightX = $this->getX($this->getTopRight($end));
        $center = $leftX + (($rightX - $leftX) / 2);

        $wordY    = $this->getY($this->getBottomLeft($end));
        $toolbarY = $this->getY($this->getTopLeft($this->_getToolbarArrow()));
        $this->assertTrue(($wordY + 10 < $toolbarY) && ($wordY + 15 > $toolbarY), 'Y Position of toolbar arrow is incorrect.');

        $toolbarX = $this->getX($this->_getToolbarArrowLocation());
        $this->assertTrue(($center + 2 > $toolbarX) || ($center - 2 < $toolbarX), 'X Position of toolbar arrow is incorrect.');

    }//end testMultiParagraphSelectionPosition()


    /**
     * Test for inline toolbar.
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
     * Test for inline toolbar.
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
     * Test for inline toolbar.
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
     * Test for inline toolbar.
     *
     * @return void
     */
    public function testLineageMultiParentSameParagraph()
    {
        $this->selectText('XYZ');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testMultiParentSameParagraph()


    /**
     * Test for inline toolbar.
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
     * Test for inline toolbar.
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
     * Test for inline toolbar.
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
     * Test for inline toolbar.
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


}//end class

?>
