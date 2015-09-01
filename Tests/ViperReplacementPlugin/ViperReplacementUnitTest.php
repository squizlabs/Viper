<?php

require_once 'AbstractViperUnitTest.php';

class Viper_Tests_ViperReplacementPlugin_ViperReplacementUnitTest extends AbstractViperUnitTest
{


    /**
     * Test that you can open and close the source editor.
     *
     * @return void
     */
    public function testKeywordsReplaced()
    {
        $this->clickKeyword(1);
        sleep(1);

        $raw = $this->getRawHtml();
        $this->assertEquals(
            '<p>Lorem <span title="((prop:productName))" data-viper-keyword="((prop:productName))">Viper</span> XAX</p><p><strong>XBX</strong> sit amet</p><p>test <img src="../../Examples/Paper-reel/Images/testImage.png" data-viper-src="((prop:url))" alt="Viper" data-viper-alt="((prop:productName))" title="Test Image" data-viper-height="((prop:height))" data-viper-width="((prop:width))" height="200px" width="100px"></p>',
            $raw
        );

        $visible = $this->getHtml();
        $this->assertHTMLMatch('<p>Lorem ((prop:productName)) %1%</p><p><strong>%2%</strong> sit amet</p><p>test <img src="((prop:url))" alt="((prop:productName))" title="Test Image" height="((prop:height))" width="((prop:width))" /></p>');

    }//end testKeywordsReplaced()


}//end class

?>
