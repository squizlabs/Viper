<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperInlineToolbarPlugin_InlineToolbarLinkUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that when you select link in the lineage, the link is selected
     *
     * @return void
     */
    public function testClickingLinkInLineage()
    {
        $this->click($this->find('WoW'));
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Link</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Link</li>', $lineage);

        $this->click($this->find('LoreM'));
        $this->click($this->find('BROWN'));
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Link</li>', $lineage);

        $this->selectInlineToolbarLineageItem(0);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">P</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

        $this->selectInlineToolbarLineageItem(1);
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Link</li>', $lineage);


    }//end testClickingLinkInLineage()


    /**
     * Test that when you create a link
     *
     * @return void
     */
    public function testLinkAppearsInLineage()
    {
        $this->selectText('DOLOR');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);

        $this->clickInlineToolbarButton(dirname(dirname(__FILE__)).'/ViperLinkPlugin/Images/toolbarIcon_link.png');
        $this->type('http://www.squizlabs.com');
        $this->keyDown('Key.ENTER');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Link</li>', $lineage);
    }


    /**
     * Test that when you remove a link the lineage changes
     *
     * @return void
     */
    public function testLineageChangesWhenRemoveLink()
    {
        $this->selectText('WoW');
        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Link</li>', $lineage);

        $this->clickInlineToolbarButton(dirname(dirname(__FILE__)).'/ViperLinkPlugin/Images/toolbarIcon_removeLink.png');

        $lineage = $this->getHtml('.ViperITP-lineage');
        $this->assertEquals('<li class="ViperITP-lineageItem">P</li><li class="ViperITP-lineageItem Viper-selected">Selection</li>', $lineage);
    }

}//end class

?>
