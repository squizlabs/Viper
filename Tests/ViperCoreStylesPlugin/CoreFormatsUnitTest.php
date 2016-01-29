<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperCoreStylesPlugin_CoreFormatsUnitTest extends AbstractViperUnitTest
{    

    /**
     * Test that style can be applied to the selection.
     *
     * @return void
     */
    public function testAllStyles()
    {
        $this->useTest(2);

        $this->selectKeyword(1);

        $this->clickTopToolbarButton('bold');
        $this->clickTopToolbarButton('italic');
        $this->clickTopToolbarButton('subscript');
        $this->clickTopToolbarButton('strikethrough');
        $this->assertHTMLMatch('<p><del><sub><em><strong>%1%</strong></em></sub></del> %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');
        $this->assertTrue($this->topToolbarButtonExists('superscript', 'disabled'), 'Superscript icon should be disabled');

        // Remove sub and apply super.
        $this->clickTopToolbarButton('subscript', 'active');
        sleep(1);
        $this->assertHTMLMatch('<p><del><em><strong>%1%</strong></em></del> %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');
        $this->clickTopToolbarButton('superscript');
        $this->assertHTMLMatch('<p><sup><del><em><strong>%1%</strong></em></del></sup> %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');

        // Remove super.
        $this->clickTopToolbarButton('superscript', 'active');
        $this->assertHTMLMatch('<p><del><em><strong>%1%</strong></em></del> %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');

        // Remove strike.
        $this->clickTopToolbarButton('strikethrough', 'active');
        $this->assertHTMLMatch('<p><em><strong>%1%</strong></em> %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');

        //Remove italics
        $this->clickTopToolbarButton('italic', 'active');
        $this->assertHTMLMatch('<p><strong>%1%</strong> %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');

        //Remove bold
        $this->clickTopToolbarButton('bold', 'active');
        $this->assertHTMLMatch('<p>%1% %2% %3%</p><p>sit<em>%4%</em><strong>%5%</strong></p>');

    }//end testAllStyles()
    
}//end class

?>