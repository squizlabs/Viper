<?php

require_once __DIR__.'/../ViperListPlugin/AbstractViperListPluginUnitTest.php';

class Viper_Tests_ViperReplacementPlugin_ListsWithKeywordsUnitTest extends AbstractViperListPluginUnitTest
{

    /**
     * Test creating and removing lists with keywords
     *
     * @return void
     */
    public function testCreatingAndRemovingLists()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, FALSE, TRUE) as $method) {
                if ($listType === 'ul') {
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->useTest(1, 1);
                $this->clickKeyword(5);
                $this->doAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
                $this->assertHTMLMatch('<p>%1%</p><'.$listType.'><li>((prop:viperKeyword))</li></'.$listType.'>');
                $this->assertRawHTMLMatch('<p>%1%</p><'.$listType.'><li> <span title="((prop:viperKeyword))" data-viper-keyword="((prop:viperKeyword))">%5%</span></li></'.$listType.'>');

                // Remove list
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
                $this->assertHTMLMatch('<p>%1%</p><p>((prop:viperKeyword))</p>');
                $this->assertRawHTMLMatch('<p>%1%</p><p><span title="((prop:viperKeyword))" data-viper-keyword="((prop:viperKeyword))">%5%</span></p>');
            }
        }

    }//end testCreatingAndRemovingLists()


    /**
     * Test creating lists with keywords that are linked
     *
     * @return void
     */
    public function testCreateListWithLinkedKeyword()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, FALSE, TRUE) as $method) {
                if ($listType === 'ul') {
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->useTest(2, 1);
                $this->clickKeyword(5);
                $this->doAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
                $this->assertHTMLMatch('<p>%1%</p><'.$listType.'><li><a href="www.squizlabs.com.au">((prop:viperKeyword))</a></li></'.$listType.'>');
                $this->assertRawHTMLMatch('<p>%1%</p><'.$listType.'><li> <a href="www.squizlabs.com.au"><span title="((prop:viperKeyword))" data-viper-keyword="((prop:viperKeyword))">%5%</span></a></li></'.$listType.'>');

                // Remove list
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
                $this->assertHTMLMatch('<p>%1%</p><p><a href="www.squizlabs.com.au">((prop:viperKeyword))</a></p>');
                $this->assertRawHTMLMatch('<p>%1%</p><p><a href="www.squizlabs.com.au"><span title="((prop:viperKeyword))" data-viper-keyword="((prop:viperKeyword))">%5%</span></a></p>');
            }
        }

    }//end testCreateListWithLinkedKeyword()


    /**
     * Test that you can create lists with content that has an image in it that uses a keyword
     *
     * @return void
     */
    public function testCreateListWithImage()
    {
        foreach (array('ol', 'ul') as $listType) {
            foreach ($this->getTestMethods(TRUE, FALSE, TRUE) as $method) {
                if ($listType === 'ul') {
                    $listIconToClick = 'listUL';
                    $ulStatus = 'active';
                    $olStatus = TRUE;
                } else {
                    $listIconToClick = 'listOL';
                    $ulStatus = TRUE;
                    $olStatus = 'active';
                }

                $this->useTest(3, 1);
                $this->selectKeyword(2);
                $this->doAction($method, $listIconToClick);
                $this->assertIconStatusesCorrect($ulStatus, $olStatus, FALSE, TRUE);
                $this->assertHTMLMatch('<p>%1%</p><'.$listType.'><li>Test %2% content<img alt="TITLE" src="((prop:url))" /> more test content.</li></'.$listType.'>');
                $this->assertRawHTMLMatch('<p>%1%</p><'.$listType.'><li>Test %2% content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /> more test content.</li></'.$listType.'>');

                // Remove list
                $this->doAction($method, $listIconToClick, 'active');
                $this->assertIconStatusesCorrect(TRUE, TRUE, TRUE, FALSE, FALSE, FALSE);
                $this->assertHTMLMatch('<p>%1%</p><p>Test %2% content <img alt="TITLE" src="((prop:url))" /> more test content.</p>');
                $this->assertRawHTMLMatch('<p>%1%</p><p>Test %2% content<img alt="TITLE" data-viper-src="((prop:url))" src="'.$this->getTestURL('/Web/testImage.png').'" /> more test content.</p>');
            }
        }

    }//end testCreateListWithImage()


    /**
     * Test the inline toolbar lineage works correctly when list items are linked
     *
     * @return void
     */
    public function testInlineToolbarLineageWithLinkedKeywords()
    {
        foreach (array('ol', 'ul') as $listType) {
            if ($listType === 'ul') {
                $this->useTest(4);
            } else {
                $this->useTest(5);
            }

            // Test using the lineage when the content is linked using keywords
            $this->clickKeyword(1);
            $lineage = $this->getHtml('.ViperITP-lineage');
            $this->assertEquals('<li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

            $this->selectInlineToolbarLineageItem(2);
            $lineage = $this->getHtml('.ViperITP-lineage');
            $this->assertEquals('<li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem Viper-selected">Link</li>', $lineage);

            $this->selectInlineToolbarLineageItem(1);
            $lineage = $this->getHtml('.ViperITP-lineage');
            $this->assertEquals('<li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem Viper-selected">Item</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

            $this->selectInlineToolbarLineageItem(0);
            $lineage = $this->getHtml('.ViperITP-lineage');
            $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem">Link</li>', $lineage);

            // Test using the lineage when a keyword is linked
            $this->clickKeyword(5);
            $lineage = $this->getHtml('.ViperITP-lineage');
            $this->assertEquals('<li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem">Link</li><li class="ViperITP-lineageItem Viper-selected">Keyword</li>', $lineage);

            $this->selectInlineToolbarLineageItem(2);
            $lineage = $this->getHtml('.ViperITP-lineage');
            $this->assertEquals('<li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem Viper-selected">Link</li><li class="ViperITP-lineageItem">Keyword</li>', $lineage);

            $this->selectInlineToolbarLineageItem(1);
            $lineage = $this->getHtml('.ViperITP-lineage');
            $this->assertEquals('<li class="ViperITP-lineageItem">List</li><li class="ViperITP-lineageItem Viper-selected">Item</li><li class="ViperITP-lineageItem">Link</li><li class="ViperITP-lineageItem">Keyword</li>', $lineage);

            $this->selectInlineToolbarLineageItem(0);
            $lineage = $this->getHtml('.ViperITP-lineage');
            $this->assertEquals('<li class="ViperITP-lineageItem Viper-selected">List</li><li class="ViperITP-lineageItem">Item</li><li class="ViperITP-lineageItem">Link</li><li class="ViperITP-lineageItem">Keyword</li>', $lineage);
        }

    }//end testInlineToolbarLineageWithLinkedKeywords()

}
