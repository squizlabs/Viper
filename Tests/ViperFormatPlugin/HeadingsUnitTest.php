<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperFormatPlugin_HeadingsUnitTest extends AbstractViperUnitTest
{

    
   /**
     * Test that heading formats work.
     *
     * @return void
     */
    public function testChangingAHeadingStyle()
    {
        $dir  = dirname(__FILE__).'/Images/';
        
       $this->selectText('HEADINGS', 'Test');
        
        $this->clickInlineToolbarButton($dir.'toolbarIcon_heading_subActive.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_h3.png');
        
        $this->assertHTMLMatch('<h3>HEADINGS Test</h3><p>Lorem xtn dolor</p><p>sit amet <strong>WoW</strong></p>');
        
    }//end testChangingAHeadingStyle()
         
    
    /**
     * Test that removing a heading works.
     *
     * @return void
     */
    public function testRemovingAHeadingStyle()
    {
        $dir  = dirname(__FILE__).'/Images/';
        
       $this->selectText('HEADINGS', 'Test');
       
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_heading_subHighlighted.png'), 'Headings icon is not highlighted in the inline toolbar');
        
        $this->clickInlineToolbarButton($dir.'toolbarIcon_toggle_formats.png');
        $this->clickInlineToolbarButton($dir.'toolbarIcon_p.png');
        
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_heading.png'), 'Headings icon is still highlighted in the inline toolbar');
        $this->assertTrue($this->inlineToolbarButtonExists($dir.'toolbarIcon_toggle_formats_highlighted.png'), 'Formats icon is not highlighted in the inline toolbar');
        $this->assertHTMLMatch('<p>HEADINGS Test</p><p>Lorem xtn dolor</p><p>sit amet <strong>WoW</strong></p>');
        
    }//end testRemovingAHeadingStyle()
    
}//end class

?>
