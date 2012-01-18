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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

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
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

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
     * Test that VITP changes when the format of the selected text changes to bold.
     *
     * @return void
     */
    public function testLineageChangesWhenBoldIsApplied()
    {
        $this->selectText('Lorem');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + b');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

    }//end testLineageChangesWhenBoldIsApplied()


    /**
     * Test that VITP changes when the format of the selected text changes to italics.
     *
     * @return void
     */
    public function testLineageChangesWhenItalicIsApplied()
    {
        $this->selectText('Lorem');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText('Lorem');
        $this->keyDown('Key.CMD + i');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

    }//end testLineageChangesWhenItalicIsApplied()


    /**
     * Test that VITP changes when bold is removed from the selected text.
     *
     * @return void
     */
    public function testLineageChangesWhenBoldIsRemoved()
    {
        $this->selectText('XyZ', 'DFG');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);


        $this->selectText('XyZ', 'DFG');
        $this->keyDown('Key.CMD + b');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenBoldIsRemoved()


    /**
     * Test that VITP changes when italic is removed from the selected text.
     *
     * @return void
     */
    public function testLineageChangesWhenItalicIsRemoved()
    {
        $this->selectText('Food', 'Source');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);


        $this->selectText('Food', 'Source');
        $this->keyDown('Key.CMD + i');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

    }//end testLineageChangesWhenItalicIsRemoved()


    /**
     * Test that when you select the Bold tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheBoldTagInTheLineage()
    {
        $this->selectText('XyZ');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->assertEquals('XyZ DFG', $this->getSelectedText(), 'Bold text is not selected.');

        $this->selectText('DFG');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('XyZ DFG', $this->getSelectedText(), 'Bold text is not selected.');

    }//end testSelectingTheBoldTagInTheLineage()


    /**
     * Test that when you select the Italic tag in the lineage both words in the tag are highlighted.
     *
     * @return void
     */
    public function testSelectingTheItalicTagInTheLineage()
    {
        $this->selectText('Food');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Italic</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->assertEquals('Food Source', $this->getSelectedText(), 'Italics text is not selected.');

        $this->selectText('Source');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('Food Source', $this->getSelectedText(), 'Italics text is not selected.');

    }//end testSelectingTheItalicTagInTheLineage()


    /**
     * Test the order of the Bold and Italic lineage
     *
     * @return void
     */
    public function testOrderOfBoldAndItalicLineage()
    {
        $this->selectText('IPSUM');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + b');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + b');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Italic</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + i');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Bold</li>', $lineage);

        $this->selectText('IPSUM');
        $this->keyDown('Key.CMD + i');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

    }//end testOrderOfBoldAndItalicLineage()


    /**
     * Test selecting Bold and Italic in the lineage.
     *
     * @return void
     */
    public function testSelectingBoldAndItalic()
    {
        $this->selectText('IPSUM', 'dolor');
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem selected">Italic</li>', $lineage);

        $this->selectText('dolor');
        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('IPSUM dolor', $this->getSelectedText(), 'Formatted text is not selected');

        $this->selectText('IPSUM');
        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals('IPSUM dolor', $this->getSelectedText(), 'Formatted text is not selected');


    }//end testSelectingBoldAndItalic()


    /**
     * Test that when you select the P tag in the lineage the paragraph is highlighted.
     *
     * @return void
     */
    public function testSelectingThePTagInTheLineage()
    {
        $this->selectText('XyZ');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">P</li><li class="ViperITP-lineageItem">Bold</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->assertEquals('aaaa bbb ZON XyZ DFG Food Source WoW', $this->getSelectedText(), 'Paragraph is not selected.');

        $this->selectInlineToolbarLineageItem(2);
        $this->assertEquals('XyZ', $this->getSelectedText(), 'Original selection is not selected');


    }//end testSelectingThePTagInTheLineage()


    /**
     * Test that when you select the Quote tag in the lineage the blockquote is highlighted.
     *
     * @return void
     */
    public function testSelectingTheQuoteTagInTheLineage()
    {
        $this->selectText('quick');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">Quote</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">Quote</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->assertEquals('the quick brown fox', $this->getSelectedText(), 'Blockquote is not selected.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('quick', $this->getSelectedText(), 'Original selection is not selected');


    }//end testSelectingTheQuoteTagInTheLineage()


    /**
     * Test that when you select the Div tag in the lineage the Div is highlighted.
     *
     * @return void
     */
    public function testSelectingTheDivTagInTheLineage()
    {
        $this->selectText('lazy');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">DIV</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">DIV</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->assertEquals('jumps over the lazy dog', $this->getSelectedText(), 'Div is not selected.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('lazy', $this->getSelectedText(), 'Original selection is not selected');


    }//end testSelectingTheDivTagInTheLineage()


    /**
     * Test that when you select the Pre tag in the lineage the Pre is highlighted.
     *
     * @return void
     */
    public function testSelectingThePreTagInTheLineage()
    {
        $this->selectText('LABS');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">PRE</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">PRE</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);

        $this->assertEquals('Squiz LABS is 0rsm', $this->getSelectedText(), 'Pre is not selected.');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertEquals('LABS', $this->getSelectedText(), 'Original selection is not selected');


    }//end testSelectingThePreTagInTheLineage()


    /**
     * Test correct linelage is shown when you change a paragraph to a blockquote.
     *
     * @return void
     */
    public function testPChangesToQuoteInLineage()
    {
        $this->selectText('IPSUM');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_blockquote.png');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">Quote</li>', $lineage);

    }//end testPChangesToQuoteInLineage()


    /**
     * Test correct linelage is shown when you change a paragraph to a Div.
     *
     * @return void
     */
    public function testPChangesToDivInLineage()
    {
        $this->selectText('IPSUM');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_div.png');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">DIV</li>', $lineage);

    }//end testPChangesToDivInLineage()


    /**
     * Test correct linelage is shown when you change a paragraph to a Pre.
     *
     * @return void
     */
    public function testPChangesToPreInLineage()
    {
        $this->selectText('IPSUM');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton(dirname(__FILE__).'/Images/toolbarIcon_pre.png');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">PRE</li>', $lineage);

    }//end testPChangesToPreInLineage()


    /**
     * Test selecting the H1 tag in the toolbar.
     *
     * @return void
     */
    public function testSelectingH1Tag()
    {
        $this->selectText('Unit');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H1</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">H1</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);
        
        $this->assertEquals('Inline Toolbar Unit Test', $this->getSelectedText(), 'The H1 tag is not selected');
        
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H1</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);
        
        $this->assertEquals('Unit', $this->getSelectedText(), 'Original text is not selected');

    }//end testSelectingH1Tag()


    /**
     * Test selecting the H2 tag in the toolbar.
     *
     * @return void
     */
    public function testSelectingH2Tag()
    {
        $this->selectText('Two');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H2</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">H2</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);
        
        $this->assertEquals('Heading Two', $this->getSelectedText(), 'The H2 tag is not selected');
        
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H2</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);
        
        $this->assertEquals('Two', $this->getSelectedText(), 'Original text is not selected');

    }//end testSelectingH2Tag()
    

    /**
     * Test selecting the H3 tag in the toolbar.
     *
     * @return void
     */
    public function testSelectingH3Tag()
    {
        $this->selectText('Three');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H3</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem selected">H3</li><li class="ViperITP-lineageItem">Selection</li>', $lineage);
        
        $this->assertEquals('Heading Three', $this->getSelectedText(), 'The H3 tag is not selected');
        
        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">H3</li><li class="ViperITP-lineageItem selected">Selection</li>', $lineage);
        
        $this->assertEquals('Three', $this->getSelectedText(), 'Original text is not selected');

    }//end testSelectingH3Tag()
    
}//end class

?>
