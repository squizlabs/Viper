<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_FormatUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that paragraphs can be aligned.
     *
     * @return void
     */
    public function testAlignment()
    {
        $this->selectText('Lorem');

        $dir = dirname(__FILE__).'/Images/';
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignLeft_active.png'));
        $this->assertHTMLMatch('<p style="text-align: left; ">Lorem xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

        $this->selectText('Lorem');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignCenter_active.png'));
        $this->assertHTMLMatch('<p style="text-align: center; ">Lorem xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

        $this->selectText('Lorem');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignRight_active.png'));
        $this->assertHTMLMatch('<p style="text-align: right; ">Lorem xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

        $this->selectText('Lorem');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignJustify.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignJustify_active.png'));
        $this->assertHTMLMatch('<p style="text-align: justify; ">Lorem xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

    }//end testAlignment()


    /**
     * Test that only block level elements are aligned.
     *
     * @return void
     */
    public function testAlignmentInNoneBlockTag()
    {
        $this->selectText('consectetur');
        $this->keyDown('Key.RIGHT');
        $this->keyDown('Key.LEFT');

        $dir = dirname(__FILE__).'/Images/';
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter.png');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignCenter_active.png'));
        $this->assertHTMLMatch('<p>Lorem xtn dolor</p><p style="text-align: center; ">sit amet <strong>consectetur</strong></p>');

    }//end testAlignmentInNoneBlockTag()


    /**
     * Test that selecting text does not show formatting icons in VITP.
     *
     * @return void
     */
    public function testTextSelectionNoOptions()
    {
        $text = $this->find('Lorem');
        $this->selectText('Lorem');

        $dir = dirname(__FILE__).'/Images/';
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_heading.png'), 'VITP Heading icon should not be available for text selection');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_div.png'), 'VITP format icons should not be available for text selection');

        $this->click($text);
        $this->selectText('consectetur');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_heading.png'), 'VITP Heading icon should not be available for text selection');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_div.png'), 'VITP format icons should not be available for text selection');

    }//end testTextSelectionNoOptions()


    /**
     * Test that block formats (blockquote, P, DIV, PRE) works.
     *
     * @return void
     */
    public function testBlockFormats()
    {
        $this->execJS('viper.focus()');
        sleep(1);

        $dir     = dirname(__FILE__).'/Images/';
        $buttons = array(
                    'p',
                    'pre',
                    'blockquote',
                    'div',
                   );

        $count = count($buttons);
        for ($i = 0; $i < $count; $i++) {
            $tag = $buttons[$i];
            for ($k = 0; $k < 15; $k++) {
                $this->keyDown('Key.SHIFT + Key.RIGHT');
            }

            sleep(1);

            if ($tag !== 'p') {
                $this->clickInlineToolbarButton($dir.'toolbarIcon_'.$tag.'.png');
            }

            $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_'.$tag.'_active.png'), 'Toolbar icon not found: toolbarIcon_'.$tag.'_active.png');
            $this->assertHTMLMatch('<'.$tag.'>Lorem xtn dolor</'.$tag.'><p>sit amet <strong>consectetur</strong></p>');

            for ($j = 0; $j < $count; $j++) {
                if ($j === $i) {
                    continue;
                }

                $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_'.$buttons[$j].'.png'));
            }
        }//end for

    }//end testBlockFormats()


    /**
     * Test that heading formats work.
     *
     * @return void
     */
    public function testHeading()
    {
        $this->execJS('viper.focus()');
        sleep(1);

        $dir     = dirname(__FILE__).'/Images/';
        $buttons = array(
                    'h1',
                    'h2',
                    'h3',
                    'h4',
                    'h5',
                    'h6',
                   );

        $count = count($buttons);
        for ($i = 0; $i < $count; $i++) {
            $tag = $buttons[$i];
            for ($k = 0; $k < 15; $k++) {
                $this->keyDown('Key.SHIFT + Key.RIGHT');
            }

            sleep(1);

            if ($i === 0) {
                $this->clickInlineToolbarButton($dir.'toolbarIcon_heading.png');
            }

            $this->clickInlineToolbarButton($dir.'toolbarIcon_'.$tag.'.png');

            $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_'.$tag.'_active.png'), 'Toolbar icon not found: toolbarIcon_'.$tag.'_active.png');
            $this->assertHTMLMatch('<'.$tag.'>Lorem xtn dolor</'.$tag.'><p>sit amet <strong>consectetur</strong></p>');

            for ($j = 0; $j < $count; $j++) {
                if ($j === $i) {
                    continue;
                }

                $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_'.$buttons[$j].'.png'));
            }
        }//end for

    }//end testHeading()


    /**
     * Test that creating anchor works.
     *
     * @return void
     */
    public function testCreateAnchor()
    {
        $dir = dirname(__FILE__).'/Images/';
        $this->selectText('Lorem');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_anchor.png');
        $this->clickInlineToolbarButton($dir.'input_anchor.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span id="test">Lorem</span> xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

        $this->click($this->find('Lorem'));
        $this->selectText('Lorem');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_anchor_active.png'), 'Anchor icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_anchor_active.png'), 'Anchor icon in VITP should be active');

    }//end testCreateAnchor()


    /**
     * Test that adding class works.
     *
     * @return void
     */
    public function testAddClassAttr()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('Lorem');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_class.png');
        $this->clickInlineToolbarButton($dir.'input_class.png');
        $this->type('test');
        $this->keyDown('Key.ENTER');

        $this->assertHTMLMatch('<p><span class="test">Lorem</span> xtn dolor</p><p>sit amet <strong>consectetur</strong></p>');

        $this->click($this->find('Lorem'));
        $this->selectText('Lorem');
        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in Top Toolbar should be active.');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_class_active.png'), 'Class icon in VITP should be active.');

    }//end testAddClassAttr()


    /**
     * Test that selecting text does not show formatting icons in VITP.
     *
     * @return void
     */
    public function testMultiParentNoOpts()
    {
        $this->selectText('amet', 'consectetur');

        $dir = dirname(__FILE__).'/Images/';
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_heading.png'), 'VITP Heading icon should not be available for text selection');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_div.png'), 'VITP format icons should not be available for text selection');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_class.png'), 'Class icon in VITP should not be active.');
        $this->assertFalse($this->inlineToolbarButtonExists($dir.'toolbarIcon_anchor.png'), 'Anchor icon in VITP should not be active.');

    }//end testMultiParentNoOpts()


}//end class

?>
