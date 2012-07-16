<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_PreUnitTest extends AbstractViperUnitTest
{


    /**
     * Test applying the pre tag to a paragraph using the inline toolbar.
     *
     * @return void
     */
    public function testApplingThePreStyleUsingInlineToolbar()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);

        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><pre>%4% paragraph to change to a pre</pre>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');

        $this->clickInlineToolbarButton('formats-pre', 'active');

        $this->assertTrue($this->inlineToolbarButtonExists('PRE', NULL, TRUE), 'Pre icon is not active');

    }//end testApplingThePreStyleUsingInlineToolbar()


    /**
     * Test applying the pre tag to a paragraph using the top toolbar.
     *
     * @return void
     */
    public function testApplingThePreStyleUsingTopToolbar()
    {
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><pre>%4% paragraph to change to a pre</pre>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');

        $this->clickTopToolbarButton('formats-pre', 'active');

        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'Pre icon is not active');

    }//end testApplingThePreStyleUsingTopToolbar()


    /**
     * Test that applying styles to whole pre and selecting the PRE in lineage shows correct icons.
     *
     * @return void
     */
    public function testSelectPreAfterStylingShowsCorrectIcons()
    {

        $this->click($this->findKeyword(3));
        $this->selectKeyword(1, 2);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);

        // Make sure the correct icons are being shown in the inline toolbar.
        $this->assertTrue($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('PRE', NULL, TRUE), 'Pre icon is not active');

        // Make sure the correct icons are being shown in the top toolbar.
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'Pre icon is not active');

    }//end testSelectPreAfterStylingShowsCorrectIcons()


     /**
     * Test selecting text in a Pre shows the Pre icons in the inline toolbar.
     *
     * @return void
     */
    public function testSelectingPreWithFormattedTextShowsCorrectIcons()
    {

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->assertEquals($this->replaceKeywords('%1% xtn %2%'), $this->getSelectedText(), 'Original selection is not selected');
        $this->assertTrue($this->inlineToolbarButtonExists('PRE', NULL, TRUE), 'Pre icon is not active');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(3);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->topToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');
        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->assertEquals($this->replaceKeywords('%3% amet WoW'), $this->getSelectedText(), 'Original selection is not selected');
        $this->assertTrue($this->topToolbarButtonExists('PRE', NULL, TRUE), 'Pre icon is not active');

    }//end testSelectingPreWithFormattedTextShowsCorrectIcons()


    /**
     * Test bold works in Pre.
     *
     * @return void
     */
    public function testUsingBoldInPre()
    {

        $this->click($this->findKeyword(3));
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<pre><strong>%1%</strong> xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><p>%4% paragraph to change to a pre</p>');

        $this->click($this->findKeyword(2));
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><p>%4% paragraph to change to a pre</p>');

    }//end testUsingBoldInPre()


    /**
     * Test that when you apply bold and italic formatting to all text in a PRE, the inline toolbar stays on the screen.
     *
     * @return void
     */
    public function testInlineToolbarWhenApplyingBoldAndItalicToPre()
    {

        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + b');

        $this->assertHTMLMatch('<pre><strong>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</strong></pre>');

        // Check that the inline toolbar is still on the screen
       /* $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }

        $this->assertTrue($inlineToolbarFound, 'The inline toolbar was not found');
*/
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.CMD + b');
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<pre><em>%1% Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ornare ipsum nec felis lacinia a feugiat lectus pellentesque. Praesent in sapien sapien.</em></pre>');

        // Check that the inline toolbar is still on the screen
        $inlineToolbarFound = true;
        try
        {
            $this->getInlineToolbar();
        }
        catch  (Exception $e) {
            $inlineToolbarFound = false;
        }

        $this->assertTrue($inlineToolbarFound, 'The inline toolbar was not found');

    }//end testInlineToolbarWhenApplyingBoldAndItalicToPre()


    /**
     * Test italics works in pre.
     *
     * @return void
     */
    public function testUsingItalicInPre()
    {

        $this->click($this->findKeyword(3));
        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<pre><em>%1%</em> xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><p>%4% paragraph to change to a pre</p>');

        $this->selectKeyword(1);
        $this->keyDown('Key.CMD + i');

        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><p>%4% paragraph to change to a pre</p>');

    }//end testUsingItalicInPre()


    /**
     * Test that the Pre icon is selected when you switch between selection and pre.
     *
     * @return void
     */
    public function testPreIconIsActiveWhenSelectingPreTag()
    {

        $this->click($this->findKeyword(3));
        $this->selectKeyword(1);
        $this->selectInlineToolbarLineageItem(0);
        $this->assertTrue($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is not selected');
        $this->clickInlineToolbarButton('formats-pre', 'active');
        $this->assertTrue($this->inlineToolbarButtonExists('PRE', NULL, TRUE), 'Pre icon is not active');

        $this->selectInlineToolbarLineageItem(1);
        $this->assertFalse($this->inlineToolbarButtonExists('formats-pre', 'active'), 'Toogle formats icon is still active in the inline toolbar');

    }//end testPreIconIsActiveWhenSelectingPreTag()


    /**
     * Test that when you only select part of a paragraph and apply the pre, it applies it to the whole paragraph.
     *
     * @return void
     */
    public function testPreAppliedToParagraphOnPartialSelection()
    {

        $this->selectKeyword(4);
        $this->assertFalse($this->inlineToolbarButtonExists('formats'), 'Toogle formats icon should not appear in the inline toolbar');

        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><pre>%4% paragraph to change to a pre</pre>');

    }//end testPreAppliedToParagraphOnPartialSelection()


    /**
     * Test applying and then removing the Pre format.
     *
     * @return void
     */
    public function testApplyingAndRemovingPre()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('formats-p', 'active');
        $this->clickTopToolbarButton('PRE', NULL, TRUE);

        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><pre>%4% paragraph to change to a pre</pre>');

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);

        $this->clickTopToolbarButton('formats-pre', 'active');
        $this->clickTopToolbarButton('PRE', 'active', TRUE);

        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre>%4% paragraph to change to a pre');

    }//end testApplyingAndRemovingPre()


    /**
     * Test creating new content in pre tags.
     *
     * @return void
     */
    public function testCreatingNewContentWithAPreTag()
    {

        $this->selectKeyword(4);
        $this->selectInlineToolbarLineageItem(0);
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.ENTER');
        $this->type('New %5%');
        $this->selectKeyword(5);
        $this->selectInlineToolbarLineageItem(0);
        $this->clickInlineToolbarButton('formats-p', 'active');
        $this->clickInlineToolbarButton('PRE', NULL, TRUE);
        $this->selectKeyword(5);
        $this->keyDown('Key.RIGHT');
        $this->type(' on the page');
        $this->keyDown('Key.ENTER');
        $this->type('More new content');
        $this->keyDown('Key.ENTER');
        $this->keyDown('Key.ENTER');
        $this->type('This should be a paragraph');


        $this->assertHTMLMatch('<pre>%1% xtn %2%</pre><pre>%3% amet <strong>WoW</strong></pre><p>%4% paragraph to change to a pre</p><pre>New %5% on the pageMore new content</pre><p>This should be a paragraph</p>');

    }//end testCreatingNewContentWithAPreTag()


}//end class

?>
