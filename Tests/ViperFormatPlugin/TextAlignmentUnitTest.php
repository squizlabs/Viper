<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_TextAlignmentUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that you can apply left justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingLeftJustify()
    {
        // Stop here as we need a way to click the icon in the sub toolbar.
        $this->markTestIncomplete('Need a way to click the icon in the sub toolbar.');

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LOREM', 'dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft.png');

        $this->assertHTMLMatch('<p style="text-align: left;">LOREM xtn dolor</p><p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignLeft_active.png'), 'Active left justify icon does not appear in the top toolbar');

    }//end testApplyingLeftJustify()


    /**
     * Test that when you select a paragraph that has left justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithLeftJustification()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('sit', 'WoW');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignLeft_active.png'), 'Left justify icon is not active in the top toolbar');

    }//end testSelectingParagraphWithLeftJustification()


    /**
     * Test removing left justification.
     *
     * @return void
     */
    public function testRemovingLeftJustification()
    {
        // Stop here as we need a way to click the icon in the sub toolbar.
        $this->markTestIncomplete('Need a way to click the icon in the sub toolbar.');

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('sit', 'WoW');

        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft_active.png');

        $this->assertHTMLMatch('<p>LOREM xtn dolor</p><p>sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_justification.png'), 'Left justify active icon still appears in the top toolbar');

    }//end testRemovingLeftJustification()


    /**
     * Test that you can apply right justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingRightJustify()
    {
        // Stop here as we need a way to click the icon in the sub toolbar.
        $this->markTestIncomplete('Need a way to click the icon in the sub toolbar.');

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LOREM', 'dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight.png');

        $this->assertHTMLMatch('<p style="text-align: right;">LOREM xtn dolor</p><p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignRight_active.png'), 'Right justify active icon does not appear in the top toolbar');

    }//end testApplyingRightJustify()


    /**
     * Test that when you select a paragraph that has right justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithRightJustification()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('QvQ', 'Kyk');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignRight_active.png'), 'Right justify active icon does not appear in the top toolbar');

    }//end testSelectingParagraphWithRightJustification()


    /**
     * Test removing right justification.
     *
     * @return void
     */
    public function testRemovingRightJustification()
    {
        // Stop here as we need a way to click the icon in the sub toolbar.
        $this->markTestIncomplete('Need a way to click the icon in the sub toolbar.');

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('QvQ', 'Kyk');

        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight_active.png');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignRight_active.png'), 'Right justify icon is still active');

        $this->assertHTMLMatch('<p>LOREM xtn dolor</p><p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p>QvQ KyK</p><p style="text-align: justify;">MrM GaG</p>');

    }//end testRemovingRightJustification()


    /**
     * Test that you can apply centre justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingCentreJustify()
    {
        // Stop here as we need a way to click the icon in the sub toolbar.
        $this->markTestIncomplete('Need a way to click the icon in the sub toolbar.');

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LOREM', 'dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter.png');

        $this->assertHTMLMatch('<p style="text-align: center;">LOREM xtn dolor</p><p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignCenter_active.png'), 'Centre justify active icon does not appear in the top toolbar');

    }//end testApplyingCentreJustify()


    /**
     * Test that when you select a paragraph that has centre justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithCentreJustification()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('RsR', 'TpT');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignCenter_active.png'), 'Centre justify active icon does not appear int he top toolbar');

    }//end testSelectingParagraphWithCentreJustification()


    /**
     * Test removing centre justification.
     *
     * @return void
     */
    public function testRemovingCentreJustification()
    {
        // Stop here as we need a way to click the icon in the sub toolbar.
        $this->markTestIncomplete('Need a way to click the icon in the sub toolbar.');

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('RsR', 'TpT');

        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignCenter_active.png');

        $this->assertHTMLMatch('<p>LOREM xtn dolor</p><p style="text-align: left;">sit amet WoW</p><p>RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_justification.png'), 'Centre justify active icon still apepars in the top toobar');

    }//end testRemovingCentreJustification()


    /**
     * Test that you can apply block justification to a paragraph.
     *
     * @return void
     */
    public function testApplyingBlockJustify()
    {
        // Stop here as we need a way to click the icon in the sub toolbar.
        $this->markTestIncomplete('Need a way to click the icon in the sub toolbar.');

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LOREM', 'dolor');
        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignJustify.png');

        $this->assertHTMLMatch('<p style="text-align: justify;">LOREM xtn dolor</p><p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p>');


        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignJustify_active.png'), 'Toogle justification icon is not selected');

    }//end testApplyingBlockJustify()


    /**
     * Test that when you select a paragraph that has block justification applied, that the toolbar icon is hightlighted.
     *
     * @return void
     */
    public function testSelectingParagraphWithBlockJustification()
    {
        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('MrM', 'GaG');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignJustify_active.png'), 'Block justify active icon does not appear in the toolbar');

    }//end testSelectingParagraphWithBlockJustification()


    /**
     * Test removing block justification.
     *
     * @return void
     */
    public function testRemovingBlockJustification()
    {
        // Stop here as we need a way to click the icon in the sub toolbar.
        $this->markTestIncomplete('Need a way to click the icon in the sub toolbar.');

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('MrM', 'GaG');

        $this->clickTopToolbarButton($dir.'toolbarIcon_alignJustify_active.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignJustify_active.png');

        $this->assertFalse($this->topToolbarButtonExists($dir.'toolbarIcon_toggle_justification.png'), 'Block justify active icon still appears in the top toolbar');

        $this->assertHTMLMatch('<p>LOREM xtn dolor</p><p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p>MrM GaG</p>');

    }//end testRemovingBlockJustification()


    /**
     * Test that justification is applied to the paragraph when you select a word.
     *
     * @return void
     */
    public function testJustificationWhenSelectingAWord()
    {
        // Stop here as we need a way to click the icon in the sub toolbar.
        $this->markTestIncomplete('Need a way to click the icon in the sub toolbar.');

        $dir = dirname(__FILE__).'/Images/';

        $this->selectText('LOREM');

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignLeft.png');

        $this->assertHTMLMatch('<p style="text-align: left;">LOREM xtn dolor</p><p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignLeft_active.png'), 'Acitve left justify icon does not appear in the top toolbar');

    }//end testJustificationWhenSelectingAWord()



    /**
     * Test that when you click in a word and select a justification, it is applied to the paragraph that the word is in..
     *
     * @return void
     */
    public function testJustificationWhenClickingInAWord()
    {
        // Stop here as we need a way to click the icon in the sub toolbar.
        $this->markTestIncomplete('Need a way to click the icon in the sub toolbar.');

        $dir = dirname(__FILE__).'/Images/';

        $this->click($$this->find('dolor'));

        $this->clickTopToolbarButton($dir.'toolbarIcon_toggle_justification.png');
        $this->clickTopToolbarButton($dir.'toolbarIcon_alignRight.png');

        $this->assertHTMLMatch('<p style="text-align: right;">LOREM xtn dolor</p><p style="text-align: left;">sit amet WoW</p><p style="text-align: center;">RsR TpT</p><p style="text-align: right;">QvQ KyK</p><p style="text-align: justify;">MrM GaG</p>');

        $this->assertTrue($this->topToolbarButtonExists($dir.'toolbarIcon_alignRight_active.png'), 'Acitve right justify icon does not appear in the top toolbar');

    }//end testJustificationWhenClickingInAWord()


}//end class

?>
