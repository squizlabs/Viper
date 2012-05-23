<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperInlineToolbarPlugin_InlineToolbarImageUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that image is shown in the lineage when you select an image
     *
     * @return void
     */
    public function testImageInLineage()
    {
        $this->clickElement('img', 1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Image</li>', $lineage);
        $this->assertTrue($this->inlineToolbarButtonExists('image', 'active'), 'Image icon should be active.');

        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Image</li>', $lineage);
        $this->assertFalse($this->inlineToolbarButtonExists('image', 'active'), 'Image icon should not appear in the inline toolbar.');

        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Image</li>', $lineage);
        $this->assertTrue($this->inlineToolbarButtonExists('image', 'active'), 'Image icon should be active.');

    }//end testImageInLineage()

}//end class

?>
